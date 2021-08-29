<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function sendSuccess($message, $content=null)
    {

        return Response::json([
            'status'    => 'OK',
            'message'   => $message,
            'color'     => 'green darken-1',
            'content'   => $content,
        ], 200);
    }

    public function sendError($message)
    {
        return Response::json([
            'status' => 'ERROR',
            'message' => $message,
            'color'     => 'red darken-2',
        ], 200);
    }
}
