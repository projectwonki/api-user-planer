<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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

            $validator = Validator::make($request->all(), [

                'name' => 'required|string',
                
                'email' => 'required|string|email',

                'password' => 'required|string|min:6'

            ]);

            if ($validator->fails()) {

                return response()->json(['message' => 'The given data was invalid.', 'errors' => $validator->errors()], 422);

            }

            User::create([

                'name' => $request->name,

                'email' => $request->email,

                'password' => Hash::make($request->password),

            ]);

            $response['success'] = true;
            
            $response['message'] = 'Register Successfully';

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

            $validator = Validator::make($request->all(), [

                'email' => 'required|email',

                'password' => 'required|string|min:6',

            ]);

            if ($validator->fails()) {

                return response()->json(['message' => 'The given data was invalid.', 'errors' => $validator->errors()], 422);

            }

            if (! $token = auth()->attempt($validator->validated())) {
            
                return response()->json([

                    'success' => false,

                    'message' => 'Your Email or password is wrong',

                ], 401);

            }

            return $this->createNewToken($token);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), 400);

        }
    }

    protected function createNewToken($token)
    {
        return response()->json([

            'access_token' => $token,

            'token_type' => 'bearer',

            'expires_in' => auth('api')->factory()->getTTL() * 60,

            'user' => auth('api')->user()

        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->header( 'Authorization' );

        try {
            JWTAuth::parseToken()->invalidate( $token );

            return response()->json( [
                'success' => true,
                'error'   => false,
                'message' => 'Success logout',
            ] );
        } catch ( TokenExpiredException $exception ) {
            return response()->json( [
                'success' => false,
                'error'   => true,
                'message' => 'Token expired',

            ], 401 );
        } catch ( TokenInvalidException $exception ) {
            return response()->json( [
                'success' => false,
                'error'   => true,
                'message' => 'Token invalid',
            ], 401 );

        } catch ( JWTException $exception ) {
            return response()->json( [
                'success' => false,
                'error'   => true,
                'message' => 'Token is missing',
            ], 500 );
        }
    }
}
