<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryHasTag extends Model
{
    /**
     * The database table used by the model
     *
     * @var string
     */
    protected $table = 'entry_has_tags';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['entry_id', 'tag_id'];

    /**
     * The attributes excluded from the model's JSON form
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Indicates if the model should be timestamped
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Define the relationship between two eloquent models: EntryHasTag & Entry
     */
    public function entry()
    {
        return $this->belongsTo('App\Entry');
    }

    /**
     * Define the relationship between two eloquent models: EntryHasTag & Tag
     */
    public function tag()
    {
        return $this->belongsTo('App\Tag');
    }
}