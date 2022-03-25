<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

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
    public function loginBackup(Request $request)
    {
        try {

            $attr = $request->validate([

                'email' => 'required|string|email',

                'password' => 'required|string|min:6'

            ]);
    
            if (!Auth::attempt($attr)) {

                $response['success'] = false;

                $response['message'] = 'Your Email or password is wrong';

                return response()->json($response, 200);

            }

            $token = auth()->user()->createToken('API Token')->plainTextToken;

            $response['success'] = true;

            $response['message'] = 'Login successfully';

            $response['data']['token'] = $token;

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
                return response()->json($validator->errors(), 422);
            }
            if (! $token = auth()->attempt($validator->validated())) {
                // return response()->json(['error' => 'Unauthorized'], 401);

                return response()->json([
                    'success' => false,
                    'message' => 'Your Email or password is wrong',
                ], 401);
            }

            return $this->createNewToken($token);

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Login successfully',
            //     'data' => $temp_token,
            // ], 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), 400);

        }
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
}
