<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Client;

use App\Http\Resources\Auth as AuthResource;

use App\Http\Helpers\MailHelper;
use App\Http\Helpers\ValidationHelper;
use App\Http\Helpers\ErrorHandler as ErrorHelper;

class AuthController extends Controller {
    /**
     * @OA\Post(
     *     path="/v1/login",
     *     tags={"Auth"},
     *     summary="Login into account.",
     *     operationId="login",
     * 
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="remember", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     * )
     *
     * login API 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login(Request $req) {
        $validation = ValidationHelper::auth($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $creadentials = $req->only(['email', 'password']);

        if(Auth::attempt($creadentials, $req->remember)) { 
            $user = Auth::user(); 
            $token =  $user->createToken('Personal Access Token')->accessToken;
            $user->token = $token;
            $user->message = 'You are successfully logged in!';

            return new AuthResource($user);
        }

        $user = User::withTrashed()->where('email', $req->email)->first();
        if ($user !== null) {
            if ($user->trashed()) {
                $message = 'Your access is expired.';
                return ErrorHelper::exceptions($message, 400);
            }
        }

        $message = 'Your e-mail or password is incorrect.';
        return ErrorHelper::exceptions($message, 400);
    }

    /**
     * @OA\Get(
     *     path="/v1/logout",
     *     tags={"Auth"},
     *     summary="Logout of account.",
     *     operationId="logout",
     *     security={{"bearerAuth":{}}},
     *    
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * )
     *
     * Logout api
     *
     * @return \Illuminate\Http\Response 
     */
    public function logout(Request $req) {
        $user = Auth::user();
        $user->token = $req->bearerToken();

        $req->user()->token()->revoke();

        return new AuthResource($user);
    }

    /**
     * @OA\Put(
     *     path="/v1/change",
     *     tags={"Auth"},
     *     summary="Change the password of the account.",
     *     operationId="change",
     *     security={{"bearerAuth":{}}},
     *    
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="remember", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * )
     *
     * Change password api
     *
     * @return \Illuminate\Http\Response 
     */
    public function changePassword(Request $req) {
        $validation = ValidationHelper::auth($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $user = User::where('email', $req->email)->first();

        if ($user == null) {
            $message = 'There is no user with the email \''.$req->email.'\'.';
            return ErrorHelper::exceptions($message, 404);
        }

        $user->password = Hash::make($req->password);

        if ($user->save()) {
            return $this->login($req);
        }
    }

    /**
     * @OA\Put(
     *     path="/v1/forgot",
     *     tags={"Auth"},
     *     summary="Reset the password of the account.",
     *     operationId="forgot",
     *     security={{"bearerAuth":{}}},
     *    
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * )
     *
     * Reset password api
     *
     * @return \Illuminate\Http\Response 
     */
    public function forgotPassword(Request $req) {
        $validation = ValidationHelper::authForgot($req->all());

        if ($validation !== true) {
            return ErrorHelper::exceptions($validation, 400);
        }

        $user = User::where('email', $req->email)->first();

        if ($user == null) {
            $message = 'There is no user with the email \''.$req->email.'\'.';
            return ErrorHelper::exceptions($message, 404);
        }

        $password = Str::random(12);
        $user->password = Hash::make($password);

        if ($user->save()) {
            MailHelper::forgotPassword(Client::where('email', $req->email)->first(), $password);
        }
    }
}