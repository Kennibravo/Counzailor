<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselleeFollower extends Model
{
    protected $guarded = ['id'];

    public function counsellee()
    {
        return $this->belongsTo(Counsellee::class)->withDefault();
    }

    public function counsellor()
    {
        return $this->belongsTo(Counsellor::class, 'following_counsellor');
    }
}
