<?php namespace App\Models;

class Group extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'archive',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * A group can have many colourisations.
     */
    public function colourisations()
    {
        return $this->hasMany('App\Models\Colourisation');
    }
}
