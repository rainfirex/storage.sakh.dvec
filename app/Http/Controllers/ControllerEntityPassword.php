<?php namespace App\Http\Controllers;

use App\EntityUserPassword;

class ControllerEntityPassword extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('delete');
        $this->middleware('check.handler');
    }

    public function delete(int $id) {
        $password = EntityUserPassword::find($id);
        $result = $password->delete();

        return response()->json([
            'success' => $result
        ]);
    }
}
