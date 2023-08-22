<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;

class AuthController extends Controller
{
    private $response = [
        'message' => null,
        'data' => null,
    ];

    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $this->response['message'] = 'success';
        return response()->json($this->response, 200);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required', 
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || ! Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'failed',
               
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;
        $this->response['message'] = 'success';
        $this->response['data'] = [
            'token' => $token
        ];
        return response()->json($this->response, 200);
    }

    public function me(){
        $user = Auth::user();
        $this->response['message'] = 'success';
        $this->response['data'] = $user;

        return response()->json($this->response, 200);
    }

    public function logout(){
        $logout = auth()->user()->currentAccessToken()->delete();
        $this->response['messege'] = 'success';
        return response()->json($this->response,200);
    }
}
