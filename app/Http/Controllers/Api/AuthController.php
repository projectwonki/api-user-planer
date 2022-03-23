<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * register new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {

            $attr = $request->validate([

                'name' => 'required|string',
                
                'email' => 'required|string|email',

                'password' => 'required|string|min:6'

            ]);

            User::create([

                'name' => $request->name,

                'email' => $request->email,

                'password' => Hash::make($request->password),

            ]);

            $response['success'] = true;

            $response['message'] = 'Register sukses';

            return response()->json($response, 200);            

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), 400);

            throw new BadRequestHttpException();

        }
    }
    
    /**
     * login authentication user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {

            $attr = $request->validate([

                'email' => 'required|string|email',

                'password' => 'required|string|min:6'

            ]);
    
            if (!Auth::attempt($attr)) {

                $response['success'] = false;

                $response['message'] = 'Email atau password salah';

                return response()->json($response, 200);

            }

            $token = auth()->user()->createToken('API Token')->plainTextToken;

            $response['success'] = true;

            $response['message'] = 'Login sukses';

            $response['token'] = $token;

            return response()->json($response, 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), 400);

            throw new BadRequestHttpException();

        }
    }
}
