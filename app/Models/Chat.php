<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function counsellee()
    {
        return $this->belongsTo(Counsellee::class)->withDefault();
    }

    public function counsellor()
    {
        return $this->belongsTo(Counsellor::class)->withDefault();
    }
}
