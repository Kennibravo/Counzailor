<?php

namespace App\Http\Controllers\Counsellor\Follower;

use App\Http\Controllers\BaseFollower;
use App\Models\Counsellee;
use Illuminate\Http\JsonResponse;

class FollowerController extends BaseFollower
{
    /**
     * The User Type using this controller
     * @var string
     */
    protected $userType = 'counsellor';

    /**
     * Follows a Counsellee using their ID
     * @param int|null $followerId
     * @return JsonResponse
     */
    public function followCounsellee(int $followerId = null)
    {
        $counsellee = Counsellee::findOrFail($followerId);

        if (parent::userAlreadyFollowed($this->userType, $followerId)) {
            return $this->badRequestAlert("You have already followed {$counsellee->username}");
        }

        if (parent::follow($this->userType, $followerId)) {
            return $this->successResponse("You are now following {$counsellee->username}");
        }

    }

    /**
     * Unfollows a Counsellee using their ID
     * @param int|null $followerId
     * @return JsonResponse|void
     */
    public function unfollowCounsellee(int $followerId = null)
    {
        $counsellee = Counsellee::findOrFail($followerId);

        if (!parent::userAlreadyFollowed($this->userType, $followerId)) {
            return;
        }

        if (parent::unfollow($this->userType, $followerId)) {
            return $this->successResponse("You have unfollowed {$counsellee->username}");
        }
    }

    /**
     * Gets the Followers for a Counsellor
     * @param int|null $counselleeId
     * @return JsonResponse
     */
    public function getAllCounsellorFollowers()
    {
        $followers = parent::getAllFollowers($this->userType)->get();
        return $this->successResponse("All followers", $followers);
    }

    /**
     * Checks if a current Counsellor is Following a Counsellee
     * @param int|null $counselleeId
     * @return JsonResponse
     */
    public function checkIfCounsellorFollowCounsellee(int $counselleeId = null)
    {
        $check = parent::checkIfFollowing($this->userType, $counselleeId);
        return $this->successResponse("Following", $check);
    }

    //TODO search through followers
    /*public function searchThroughCounsellorFollowers(string $search = null)
    {
        $e = parent::searchThroughFollowers($this->userType, $search);
        return $this->successResponse('', $e);
    }*/
}
