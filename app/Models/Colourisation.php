<?php namespace App\Models;

class Colourisation extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'unprocessed', 'colourised',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * A colourisation belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
