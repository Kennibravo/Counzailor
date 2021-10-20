<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounsellorFollower extends Model
{
    protected $guarded = ['id'];


    public function searchFollowers(string $search = null)
    {
//        $counsellor = $this->where('')

//        dd($counsellor);
    }

    public function counsellor()
    {
        return $this->belongsTo(Counsellor::class)->withDefault();
    }

    public function counsellee()
    {
        return $this->belongsTo(Counsellee::class, 'following_counsellee');
    }
}
