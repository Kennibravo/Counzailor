<?php

namespace App\Http\Controllers\Counsellor\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|max:191',
            'password' => 'required|max:191|min:8'
        ]);

        $token = null;

        try {
            if(!$token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password])){
                return $this->formValidationErrorAlert("Invalid Email or Password");
            }
        }catch (JWTException $e){
            return $this->badRequestAlert("Failed to create token");
        }

        return $this->successResponse("Log in success", ['token' => $token]);
    }
}
