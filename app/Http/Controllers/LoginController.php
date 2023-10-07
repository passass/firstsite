<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function create()
    {   
        return view('login');
    }

    public function destroy()
    {   
        auth()->logout();
        return redirect()->to('/');
    }

    public function store()
    {
        if (auth()->attempt(request(['name', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'The name or password is incorrect, please try again'
            ]);
        }
        
        return redirect()->to('/');
    }
}
