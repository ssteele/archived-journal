<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'tempo',
        'entry',
    ];

    protected $dates = [
        'date',
    ];


    /**
     * Define the relationship between two eloquent models: Entry & User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
