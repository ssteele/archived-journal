<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Logger extends Model {

    protected $fillable = array(
        'user_id',
        'date',
        'tempo',
        'entry',
    );

    protected $dates = array(
        'date',
    );

}
