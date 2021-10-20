<?php

namespace App\Http\Controllers\Counsellor\Auth;

use App\Http\Controllers\Controller;
use App\Models\Counsellor;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    /**
     * Registers a Counsellor
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:counsellors,username|max:15',
            'email' => 'required|unique:counsellors,email|max:191|email',
            'password' => 'required|max:191|min:8',
        ]);

        Counsellor::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => app('hash')->make($request->password),
        ]);

        return $this->createdResponse("Counsellor Successfully registered");
    }

    /**
     * Counsellor's Step two Registration
     * @param Request $request
     * @param int $counsellorId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function registerStepTwo(Request $request, int $counsellorId)
    {
        $counsellor = Counsellor::findOrFail($counsellorId);

        if (is_null($counsellor)) return $this->notFoundAlert("Counsellor Not Found");

        $this->validate($request, [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'dob' => 'required|max:10',
        ]);

        $counsellor->update($request->all());

        return $this->successResponse("Profile Updated Successfully");
    }
}
