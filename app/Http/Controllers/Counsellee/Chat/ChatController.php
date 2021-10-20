<?php

namespace App\Http\Controllers\Counsellee\Chat;

use App\Http\Controllers\BaseChatController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends BaseChatController
{
    /**
     * The User Type using this controller
     * @var string
     */
    protected $userType = 'counsellee';

    /**
     * Establish a Chat between a Counsellee and a Counsellor
     * From the Counsellees Point of View
     * 
     * @param Request $request
     * @return void
     */
    public function createChat(Request $request)
    {
        $this->validate($request, [
            'counsellor_id' => 'required|exists:counsellors,id'
        ]);

        if (!$this->establishChat($request->counsellor_id, auth()->id()))
            return $this->badRequestAlert("Chat already established with Counsellor");

        return $this->successResponse("Chat established successfully with a Counsellor");
    }

    /**
     * Send a Message from A Counsellee to a Counsellor.
     *
     * @param Request $request
     * @return void
     */
    public function sendMessageToCounsellor(Request $request)
    {
        $this->validate($request, [
            'chat_id' => 'required|integer|exists:chats,id',
            'content' => 'required|max:1000',
            'replying_to' => 'sometimes',
        ]);

        if (!$this->sendMessage(
            $request->chat_id,
            $request->content,
            $request->counsellor_id,
            null,
            auth()->id()
        )) return $this->badRequestAlert("Cannot send messages at this time");

        return $this->successResponse("Sent a message to the Counsellor");
    }

    /**
     * Get the currently authenticated Counsellors Messages inside a Chat
     *
     * @param Int $chatId
     * @return void
     */
    public function getCounselleeMessagesInAChat($chatId)
    {
        $messages = $this->getCurrentUserMessagesInAChat($this->userType, $chatId);

        return $this->successResponse("All Messages inside the Chat", $messages);
    }

    /**
     * Get the Current Counsellees Chats
     *
     * @return void
     */
    public function getCurrentCounselleeChats()
    {
        return $this->successResponse("All the Counsellees Messages", $this->getCurrentUserChats($this->userType));
    }
}
