<?php

namespace App\Http\Controllers;
use App\Mail\ResetPasswordEmail;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Admin; 
use App\Models\GuestClient; 
use App\Models\Trainer; 
use App\Models\Client; 
use App\Models\Goal; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public $successStatus = 200;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'full_name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 422);            
            }

        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 

        $userType = $request->userType;

        if($userType == 0){ // Client
            $user = Client::create($input);
        } else if($userType == 1) { // Trainer
            $user = Trainer::create($input);
        } else {
            $user = Client::create([ // GuestClient
                'full_name' => $input['full_name'], 
                'email' => $input['email'], 
                'password' => $input['password'],
                'user_type' => 'guest',
                'trainer_id' => 1, 
            ]);
        }

        if($userType != 1){ //Client or GuestClient create default goal
            Goal::create([
                'client_id' => $user->id
            ]);
        };

        $success['email'] =  $user->email;

        return response()->json(['success'=>$success], $this-> successStatus); 
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $userType = $request->userType;
        $credentials = request(['email', 'password']);

        if($userType == 0 || $userType == 2){ // Client or GuestClient
            $guard = 'api-client';
        } else { // Trainer
            $guard = 'api-trainer';
        } 

        if (! $token = auth($guard)->setTTL(99999)->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, $userType);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {

    $userType = $request->userType;

    // if($userType == 0){ // Client
    //     return response()->json(auth('api-client')->user());
    // } else if ($userType == 1){ // Trainer
    //     return response()->json(auth('api-trainer')->user());
    // } else {
    //     return response()->json(auth('api-guests-clients')->user());
    // }
    
    $trainer = Trainer::find(2);
    return response()->json($trainer->clients);
    }

    public function resetPassword(Request $request)
    {
        $email = $request['email'];
        $newPassword = ['message' => Str::random(10)];
        $userType = $request->userType;

        if($userType == 0 || $userType == 2){ // Client
            $user = Client::where('email', $email)->first();
        } else { // Trainer
            $user = Trainer::where('email', $email)->first();
        } 

        if(!empty($user)){
            $user['password'] = bcrypt($newPassword['message']);
            $user->save();
            return Mail::to($email)->send(new ResetPasswordEmail($newPassword));
        } else {
            return response()->json(['error' => 'Email not found.'], 401);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $userType)
    {
        if($userType == 0 || $userType == 2){ // Client or GuestClient
            $user = auth('api-client')->user();
            $guard = 'api-client';
        } else { // Trainer
            $user = auth('api-trainer')->user();
            $guard = 'api-trainer';
        }

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($guard)->factory()->getTTL() * 60
        ]);
    }
}