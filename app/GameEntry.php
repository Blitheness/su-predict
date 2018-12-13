<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameEntry extends Model
{
    protected $fillable = [
        'twitter_id', // varchar 255, to match Users table
        'outcome_1',
        'outcome_1_value',
        'outcome_2',
        'outcome_2_value',
        'page'
    ];
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    public function user() {
        return $this->belongsTo('App/User', 'twitter_id', 'provider_id');
    }
}
