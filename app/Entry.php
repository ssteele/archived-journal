<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'date', 'tempo', 'entry'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $dates = ['date'];

    /**
     * Define the relationship between two eloquent models: Entry & User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Define the relationship between two eloquent models: Entry & EntryHasTag
     */
    public function entryHasTag()
    {
        return $this->hasMany('App\EntryHasTag');
    }
}
