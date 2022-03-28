<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $users = User::get();
        return $this->apiResponse($users);
    }

    public function register(Request $request)
    {
        $validation = $this->validation($request);
        if($validation instanceof Response){
            return $validation;
        }

        $img=$request->file('img');             //bmsek el soura
        $ext=$img->getClientOriginalExtension();   //bgeb extention
        $image="stu -".uniqid().".$ext";            // conncat ext +name elgded
        $img->move(public_path("uploads/users/"),$image);


        $users = User::create([
            'fname'=>$request->fname ,
            'lname'=>$request->lname ,
            'b_date'=>$request->b_date ,
            'img'=>$image,
            'bio'=>$request->bio,
            'country'=>$request->country,
            'username'=>$request->username,

            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        if ($users) {
            return $this->createdResponse($users);
        }

        $this->unKnowError();
    
    }




    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return $this->apiResponse($user);
        }
        return $this->notFoundResponse();
    }


    public function update(Request $request,$id)
    {
        $validation=$this->apiValidation($request , [
            'fname' => 'required|min:3|max:10',
            'lname' => 'required|min:3|max:10',
            'img' => 'required|image|mimes:jpeg,png',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|',
            'bio' => 'required',
            'country' => 'required',
            
            ]);
        if($validation instanceof Response){
            return $validation;
        }

        $user = User::find($id);
        if (!$user) {
            return $this->notFoundResponse();
        }


        $name=$user->img;
        if ($request->hasFile('img'))
        {
            if($name !== null)
            {
                unlink(public_path('uploads/users/'.$name));
            }
            //move
        $img=$request->file('img');             //bmsek el soura
        $ext=$img->getClientOriginalExtension();   //bgeb extention
        $name="stu -".uniqid().".$ext";            // conncat ext +name elgded
        $img->move(public_path("uploads/users"),$name);   //elmkan , $name elgded

        }

        $user->update([
           'fname'=>$request->fname ,
            'lname'=>$request->lname ,
            'b_date'=>$request->b_date ,
            'email'=>$request->email ,
            'img'=>$name,
            'bio'=>$request->bio,
            'country'=>$request->country,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
        ]);

        if ($user) {
            return $this->createdResponse($user);
        }

        $this->unKnowError();

    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return $this->deleteResponse();
        }
        return $this->notFoundResponse();
    }





    public function validation($request){
        return $this->apiValidation($request , [
            'fname' => 'required|min:3|max:10',
            'lname' => 'required|min:3|max:10',
            'img' => 'image|mimes:jpeg,png',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|',
            'bio' => 'required',
          
            
        ]);
    }
}
