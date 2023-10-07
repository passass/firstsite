<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function create()
    {   
        return view('register');
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create(request(['name', 'email', 'password']));

        //Auth::guard('api')->login($user);
        auth()->login($user);
        
        
        
        return redirect()->to('/');
    }
}