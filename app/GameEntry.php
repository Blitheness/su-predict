<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameEntry extends Model
{
    protected $fillable = [
        'twitter_id', // varchar 255, to match Users table
        'page'
    ];
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    public function user() {
        return $this->belongsTo('App/User', 'twitter_id', 'provider_id');
    }
    public function options() {
        return $this->hasMany('App\EntryOption');
    }
}
