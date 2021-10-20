<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;

class BaseChatController extends Controller
{
    /**
     * Establishes a Chat between a Counsellor and a Counsellee
     * It accepts both parameters below and return true
     * if chats were established successfully
     *
     * @param $counsellorId - Chatting with
     * @param $counselleeId - Starting the Chat
     * @return bool
     */
    public function establishChat($counsellorId, $counselleeId)
    {
        if (!is_null(Chat::where('counsellee_id', $counselleeId)->firstWhere('counsellor_id', $counsellorId))) {
            return false;
        }

        Chat::create([
            'counsellee_id' => $counselleeId,
            'counsellor_id' => $counsellorId
        ]);

        return true;
    }

    /**
     * Create a Message Resource in the database
     * If message created, returns True, otherwise False
     *
     * @param $chatId
     * @param $content
     * @param null $replyingTo
     * @param null $counsellorId
     * @param null $counselleeId
     * @return bool
     */
    public function sendMessage($chatId, $content, $replyingTo = null, $counsellorId = null, $counselleeId = null)
    {
        if (!$this->chatIsTrashed($chatId)) {
            Message::create([
                'counsellor_id' => $counsellorId,
                'counsellee_id' => $counselleeId,
                'replying_to' => !is_null($replyingTo) ? $replyingTo : 1,
                'content' => $content,
                'chat_id' => $chatId
            ]);

            return true;
        }

        return false;
    }

    /**
     * Checks if a Chat has been Trashed
     *
     * @param $chatId
     * @return bool
     */
    public function chatIsTrashed($chatId)
    {
        if (Chat::find($chatId)->trashed()) {
            return true;
        }

        return false;
    }

    /**
     * Trashes a Chat
     *
     * @param $counselleeId
     * @param $chatId
     * @return bool
     */
    public function trashAChat($counselleeId, $chatId)
    {
        $chat = Chat::where('chat_id', $chatId)->firstWhere('counsellee_id', $counselleeId);

        if (is_null($chat)) return false;

        $chat->delete();

        return true;
    }

    /**
     * Set a Message status to Read
     *
     * @param Int $messageId
     * @return void
     */
    public function setMessageStatusToRead($messageId)
    {
        return Message::find($messageId)->update(['is_read' => 1]);
    }

    /**
     * Get all Messages inside a specific Chat
     *
     * @param Int $chatId
     * @return void
     */
    public function getAllMessagesInAChat($chatId)
    {
        return Message::whereChatId($chatId)->get();
    }

    /**
     * Get the Currently authenticated User Messages inside a chat.
     *
     * @param String $userType
     * @param Int $chatId
     * @return void
     */
    public function getCurrentUserMessagesInAChat($userType, $chatId)
    {
        return Message::where('chat_id', $chatId)->where("{$userType}_id", auth()->id())->get();
    }

    /**
     * Get All the Chats the Current User has or belongs to
     *
     * @param String $userType
     * @return void
     */
    public function getCurrentUserChats($userType)
    {
        if ($userType != 'counsellor' and $userType != 'counsellee') return;

        return Chat::where("{$userType}_id", auth()->id())->get();
    }
}
