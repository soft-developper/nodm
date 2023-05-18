<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use \App\Models\User;
//use Illuminate\Support\Facades\Hash; 

class Controller extends BaseController
{
    public function register(Request $request){
        $firstName = $request-> firstName;
        $lastName = $request-> lastName;
        $email = $request-> email;
        $password = $request -> password;
        //$password = Hash::make($password);
        $password = md5($password);

        $users = \App\Models\User::where("email", $email)->first();

        if($users == null){
            $users = new User();
            $users ->firstName = $firstName;
            $users ->lastName = $lastName;
            $users ->email = $email;
            $users ->password = $password;
            

            $users ->save();

            $response = [
                "output" => "success",
                "message" => "success",
            ];
            return Response::json($response, 200);
        }
        else {
            $response = [
                "output" => "failed",
                "message" => "email address already exist",
            ];
            return Response::json($response, 200);
        }
    }

    public function login( Request $request){
        $email = $request -> email;
        $password = $request -> password;
        //$password = Hash::make($password);
        $password = md5($password);

        $users = User::where("email", $email)->where("password", $password)->first();

        if ($users != null){

            $response = [
                "output" => "success",
                "message" => "success"
            ];
            return Response::json($response, 200);

        }
        else{
            $response = [
                "output" => "failed",
                "message" => "Email Address and Password mismatch"
            ];
            return Response::json($response, 200);
        }
    }


    public function getUsers(){
        $users =  User::get();

        $response = [
            "output" => "success",
            "users" => $users
        ];
        return Response::json($response, 200);
    }

    public function GetUsersById($id){

        $users = \App\Models\User::where("id", $id)->get();

        $response = [
            'status' => 'success',
            'data' => $users
        ];
        return Response::json($response, 200 );

    }
}
