<?php

namespace App\Http\Controllers\Counsellor\Chat;

use App\Http\Controllers\BaseChatController;
use Illuminate\Http\Request;

class ChatController extends BaseChatController
{
    public function createChat(Request $request)
    {
        $this->validate($request, [
            'counsellee_id' => 'required|exists:counsellees,id',
            'counsellor_id' => 'required|exists:counsellors,id'
        ]);

        if (!$this->establishChat($request->counsellor_id, $request->counsellee_id))
            return $this->badRequestAlert("Chat cannot be established with a Counsellor");

        return $this->successResponse("Chat established successfully with a Counsellor");
    }
}
