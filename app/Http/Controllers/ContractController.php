<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractRequest;
use App\Imports\RateImport;
use App\Models\Contract;
use App\Models\Rate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ContractController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Store(Request $request)
    {

        /**
         * Validamos los datos que necesitamos para crargar un contrato
         */
        $validator = $this->validator(
            $request->all(),
            Contract::$rules,
            Contract::$messages
        );

        if($validator->fails())
        {
            return $this->sendError($validator->getMessageBag()->first());
        }
        try{
            /**
             * Iniciamos la tansaccion.
             * Asi nos aseguramos que se completen todas las operaciones
             * y no queden procesos por la mitad
             */
            DB::beginTransaction();

            /**
             * Agregamos los datos a la table de Contracts
             * Name.
             * Date.
             */
            $contract = Contract::Create([
                'name'=>$request['name'],
                'date'=>$request['date']
            ]);

            /**
             * Verificamos si la variable file del Request es un archivo
             */
            if ($request->hasFile('file')) {

                /**
                 * Obtenemos los datos del Excel y los almacenamos en un array
                 */
                $rate = Excel::toArray(new RateImport, $request->file('file'));
                $rate = $rate[0];

                /**
                 * Recorremos el array con las rutas que obtuvimos del excel
                 */
                foreach($rate as $data){

                    /**
                     * Validamos cada una de las filas, si contiene los datos que necesitamos.
                     * De lo contrario devilvemos un error.
                     */
                    $validatorRate = $this->validator(
                        $request->all(),
                        Rate::$rules,
                        Rate::$messages
                    );

                    if ($validatorRate->fails()) {
                        DB::rollback();
                        return $this->sendError($validatorRate->getMessageBag()->first());
                    }

                    /**
                     * Agregamos la ruta a la table Rates, relacionada con el Contract
                     */
                    Rate::create([
                        'origin'        =>$data['pol'],
                        'destination'   =>$data['pod'],
                        'currency'      =>$data['curr'],
                        'twenty'        =>$data['20gp'],
                        'forty'         =>$data['40gp'],
                        'fortyhc'       =>$data['40hc'],
                        'contract_id'    =>$contract->id,
                    ]);
                }

            }

            /**
             * Si todo esta OK salimos por el Commit y respondemos positivamente
             */
            DB::commit();
            return $this->sendSuccess('Contrato Cargado', $contract->id);
        }
        catch(Exception $e)
        {
            /**
             * Si se lanza una excepcion, relizamos un rollback de la transaccion y respondemos con errro.
             */
            DB::rollback();
             return $this->sendError($e->getMessage());
        }

    }

    public function validator($request, $rules, $messages = [])
    {

        /**
         * Esta funcion ejecuta el Validator y
         * retorna el resultado.
         */
        $validator = Validator::make(
            $request,
            $rules,
            $messages);

        return $validator;
    }

    public function index ()
    {

        /**
         * Usamos el modelo Contract para obtener
         * todos los contractos que estan en la base de datos.
         */
        $contracts = Contract::all();

        //Por cada contrato, cargamos las rutas relacionadas
        $contracts->load('rate');

        return $contracts;
    }

    public function getContractbyID($id)
    {
        /**
         * Obtenemos un contrato a travez de un ID que se pasa por url.
         */
        $contracts = Contract::find($id);

        //Si existe un contrato, cargamos sus rutas.
        if(isset($contracts)) $contracts->load('rate');

        return $contracts;
    }
}
