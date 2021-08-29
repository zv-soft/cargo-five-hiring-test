<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use Validator;


class AuthController extends Controller
{
    public function login(Request $request) { //Inicio de Sesión mediante Laravel Passport


        if($request->isMethod('POST')) {

            $rules = [
                'email'       => 'required|string|email',
                'password'    => 'required|string',
                'remember_me' => 'nullable|boolean',
            ];

            $customMessages = [
                'required' => 'The :attribute field can not be blank.',
                'string'   => 'The :attribute field should be a string of text',
                'email'    => 'The :attribute field should be a valid email',
            ];


            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) //Verificar si el Validator fallo
            {  return response()->json(['status' => 'error', 'color' => 'error', 'message' => $validator->errors()->first(), 'failedMessages' => $validator->getMessageBag(), 'failedRules' => $validator->failed(), 'validator->messages' => $validator->errors()], 400);  }


            $credentials = request(['email', 'password']); //Credenciales Ingresadas por el Usuarios
            if (!Auth::attempt($credentials)) //Verificar si las credenciales existen
            {  return response()->json(['status' => 'error', 'color' => 'error', 'message' => 'Invalid credentials, check email and password.'], 401);  }


            $user = Auth::user(); //Información del Usuario recien Autenticado
            $tokenResult = $user->createToken('APP Personal Access Token'); //Generar Registro de Token de Acceso
            $token = $tokenResult->token; //Token

            // if ($request->get('remember_me') == true) //Si la opción de "Recuerdame"" fue marcada
            // {  $token->expires_at = Carbon::now()->addWeeks(52);  } //El Token expirara en 52 semanas

            $token->save(); //Guardamos el cambio de la fecha de expiración del Token

            // $roles = array(); $permissions = array();
            // if (count($user->roles) > 0) { //Si cuenta con al menos 1 Rol
            //     foreach ($user->roles as $key => $role) { //Recorro los Roles del usuario
            //         array_push($roles, $role->name); //Almaceno el nombre del Rol

            //         foreach ($role->permissions as $key => $permission) { //Recorro los Permisos del Rol
            //             array_push($permissions, $permission->name); //Almaceno el nombre del Permiso
            //         }
            //     }
            // }

            // if ($user->hasRole('Empresa')) //Si el usuario Autenticado es una Empresa, entonces la información a mostrar sera la contemplada en la tabla Empresas
            // { $user = Company::where(['email' => $user->email, 'name' => $user->name, 'phone' => $user->phone])->first(); }

            return response()->json([
                'status'       => 'OK',
                'color'        => 'success',
                'message'      => 'Bienvenido!',
                'user'         => $user,
                // 'roles'        => $roles,
                // 'permissions'  => $permissions,
                // // 'token_type'   => 'Bearer',
                'access_token' => $tokenResult->accessToken,
                'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            ], 200);
        } else {
            return response()->json(['status' => 'error', 'color' => 'error', 'message' => 'Your HTTP method is not correct.'], 400);
        }
    }

    public function logout(Request $request) { //Cerrar Sesión
        // if ($request->isMethod('GET')) {

        //     if ( $request->user() != null ) { //Si viene la información del Usuario
        //         $request->user()->token()->revoke();

        //         return response()->json(['status' => 'OK', 'color' => 'success', 'message' => 'Logged out.', ], 200);
        //     } else {
        //         return response()->json(['status' => 'error', 'color' => 'error', 'message' => 'The session could not be ended.'], 400);
        //     }

        // } else {
        //     return response()->json(['status' => 'error', 'color' => 'error', 'message' => 'Your HTTP method is not correct.'], 400);
        // }

    }

    public function authenticatedUserData(Request $request) { //Información del Usuario Autenticado en el Sistema

        // if (Auth::user() != null) {
        //     $user = Auth::user();
        //     $user->companies;


        //     $roles = array(); $permissions = array();
        //     if (count($user->roles) > 0) { //Si cuenta con al menos 1 Rol
        //         foreach ($user->roles as $key => $role) { //Recorro los Roles del usuario
        //             array_push($roles, $role->name); //Almaceno el nombre del Rol

        //             foreach ($role->permissions as $key => $permission) { //Recorro los Permisos del Rol
        //                 array_push($permissions, $permission->name); //Almaceno el nombre del Permiso
        //             }
        //         }
        //     }

        //     if ($user->hasRole('Empresa')) //Si el usuario Autenticado es una Empresa, entonces la información a mostrar sera la contemplada en la tabla Empresas
        //     { $user = Company::where(['email' => $user->email, 'name' => $user->name, 'phone' => $user->phone])->first(); }

        //     return response()->json([
        //         'status'       => 'OK',
        //         'color'        => 'success',
        //         'user'         => $user,
        //         'roles'        => $roles,
        //         'permissions'  => $permissions,
        //     ], 200);

        // } else {
        //     return response()->json(['status' => 'error', 'color' => 'error', 'message' => 'Lo sentimos, al parecer no hay usuario autenticado actualmente'], 400);
        // }
    }
}
