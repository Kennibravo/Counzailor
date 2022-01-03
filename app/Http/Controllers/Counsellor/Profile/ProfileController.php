<?php

namespace App\Http\Controllers\Counsellor\Profile;

use App\Http\Controllers\Controller;
use App\Models\Counsellee;
use App\Models\Counsellor;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    /**
     * Updates a Counsellor's Profile
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'dob' => 'required|max:10'
        ]);

        Counsellor::findOrFail(auth()->id())
            ->update($request->only(['firstname', 'lastname', 'dob']));

        return $this->successResponse("Counsellor's Profile updated successfully");
    }

    /**
     * Get a Counsellor's Profile Details
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile()
    {
        $counsellor = Counsellor::findOrFail(auth()->id());

        return $this->successResponse("Counsellor details", $counsellor);
    }

    /**
     * Deactivate/SoftDeletes a Counsellor's account
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivateAccount()
    {
        $counsellor = Counsellor::findOrFail(auth()->id());
        $counsellor->delete();

        return $this->successResponse("Counsellor Deactivated Successfully");
    }

    /**
     * Register a Counsellor as Counsellee Automatically with
     * a specified password and set IDS/relationship on both tables
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function registerAsCounsellee(Request $request)
    {
        $this->validate($request, [
           'password' => 'required|max:191|min:8',
           'counsellor_id' => 'required|integer|exists:counsellors,id'
        ]);

        $counsellor = Counsellor::findOrFail($request->counsellor_id);
        if($counsellor->is_counsellee) return $this->forbiddenRequestAlert("You are already a Counsellee");

        $counsellee = Counsellee::create(Arr::add(
            $counsellor->toArray(),
            'password', app('hash')->make($request->password)));

        $counsellee->update(['is_counsellor' => $counsellor->id]);
        $counsellor->update(['is_counsellee' => $counsellee->id]);

        return $this->successResponse("Counsellor Switched and Registered as a Counsellee successfully");


    }

    /**
     * Updates a Counsellor's password
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
           'password' => 'required|max:191|min:8'
        ]);

        $counsellor = Counsellor::findOrFail(auth()->id());
        $counsellor->update(['password' => app('hash')->make($request->password)]);

        return $this->successResponse("Password updated successfully");
    }
}
