<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    //
    public function setsHortTitleAttribute($value)
    {
        $this->attributes['short_title'] = \Str::length($value) > 30 ? \Str::substr($value,0,30). '...' : $value;
    }

//    public function getCreatedAtAttribute($value)
//    {
//        $carbondate = Carbon::parse($value);
//        return $past = $carbondate->diffForHumans();
//    }
    protected $primaryKey ='post_id';
}
