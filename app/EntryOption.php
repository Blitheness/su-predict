<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryOption extends Model
{
    protected $fillable = ['outcome', 'value'];
    public $timestamps = false;

    public function gameEntry() {
        return $this->belongsTo('App\GameEntry');
    }
}
