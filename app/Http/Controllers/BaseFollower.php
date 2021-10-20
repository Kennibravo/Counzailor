<?php

namespace App\Http\Controllers;

class BaseFollower extends Controller
{
    /**
     * Allowed Model names for Following
     * @var string[]
     */
    protected $modelsAllowed = [
        'counsellor' => 'CounsellorFollower',
        'counsellee' => 'CounselleeFollower',
    ];

    /**
     * Follows a User
     * @param string $userType
     * @param int|null $followerId (CounsellorID or CounselleeID)
     * @return bool|void
     */
    public function follow(string $userType, int $followerId = null)
    {
        if ($userType != 'counsellor' and $userType != 'counsellee' and is_null($followerId)) return;

        $this->getModelForUserType($userType)::create([
            $userType . '_id' => auth()->id(),
            "following_{$this->getOtherUserToFollow($userType)}" => $followerId
        ]);

        return true;
    }

    /**
     * Gets the Model for the specified User type for Followers
     * @param string $userType
     * @return string
     */
    private function getModelForUserType($userType = 'counsellor')
    {
        $path = 'App' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR;
        return $path . ($userType == 'counsellor' ? $this->modelsAllowed['counsellor'] : $this->modelsAllowed['counsellee']);
    }

    /**
     * Get the Other User type using the passed in
     * user type.
     * @param string $userType
     * @return string
     */
    public function getOtherUserToFollow($userType = 'counsellor')
    {
        return ($userType == 'counsellor') ? 'counsellee' : 'counsellor';
    }

    /**
     * Unfollows a User using the User type and the followerId
     * @param string $userType
     * @param int|null $followerId (CounsellorID or CounselleeID)
     * @return bool|void
     */
    public function unfollow(string $userType, int $followerId = null)
    {
        if ($userType != 'counsellor' and $userType != 'counsellee' and is_null($followerId)) return;

        $follower = $this->getModelForUserType($userType)::where($userType . '_id', auth()->id())
            ->where("following_{$this->getOtherUserToFollow($userType)}", $followerId)
            ->first();

        if (!is_null($follower)) {
            $follower->delete();
        }

        return true;
    }

    /**
     * Checks if User has followed another User
     * @param string $userType
     * @param int|null $followerId (CounsellorID or CounselleeID)
     * @return bool|void
     */
    public function userAlreadyFollowed(string $userType, int $followerId = null)
    {
        if ($userType != 'counsellor' and $userType != 'counsellee' and is_null($followerId)) return;

        $model = $this->getModelForUserType($userType);
        $following = $model::where($userType . '_id', auth()->id())
            ->where("following_{$this->getOtherUserToFollow($userType)}", $followerId)
            ->first();


        return !is_null($following);
    }

    /**
     * Get all Followers of a specifed User type
     * @param string $userType
     */
    public function getAllFollowers(string $userType)
    {
        if ($userType != 'counsellor' and $userType != 'counsellee') return;

        $model = $this->getModelForUserType($userType);

        return $model::where($userType . '_id', auth()->id());
    }

    /**
     * Get all Followers with the passed in ID
     * @param string $userType
     * @param int $followerId (CounsellorID or CounselleeId)
     */
    public function getAllFollowersWithId(string $userType, int $followerId)
    {
        if ($userType != 'counsellor' and $userType != 'counsellee') return;

        $model = $this->getModelForUserType($userType);

        return $model::where($userType . '_id', $followerId);
    }

    /**
     * Checks if a User is following another User
     * @param string $userType
     * @param int $followerId
     * @return bool|void
     */
    public function checkIfFollowing(string $userType, int $followerId)
    {
        if ($userType != 'counsellor' and $userType != 'counsellee') return;

        $model = $this->getModelForUserType($userType);

        $check = $model::where($userType . '_id', auth()->id())
            ->where('following_' . $this->getOtherUserToFollow($userType), $followerId)
            ->first();

        return $check != null;
    }

    //TODO Search Through Followers
    /*    public function searchThroughFollowers(string $userType, string $search = null)
        {
            if ($userType != 'counsellor' and $userType != 'counsellee') return;

            $model = $this->getModelForUserType($userType);

           return $model::where($userType . '_id', auth()->id())->with('counsellee')->each(function($query){
              dd($query->whereOneLike('username', $query->counsellee->username))->get();
           });

        }*/
}
