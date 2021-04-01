<?php namespace App\Http\Controllers;

use App\EntityUserComputer;

class ControllerEntityComputer extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('delete');
        $this->middleware('check.handler');

    }

    public function delete(int $id){
        $comp = EntityUserComputer::find($id);
        $result = $comp->delete();

        return response()->json([
           'success' => $result
        ]);
    }
}
