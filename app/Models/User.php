<?php namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * A user can have many colourisations.
     */
    public function colourisations()
    {
        return $this->hasMany('App\Models\Colourisation');
    }

    /**
     * Get the user's incomplete groups.
     */
    public function incompleteGroups()
    {
        return \App\Models\Group::select('groups.*')
            ->join('colourisations', 'groups.id', '=', 'colourisations.group_id')
            ->where('colourisations.user_id', '=', \Auth::user()->id)
            ->whereNull('groups.archive')
            ->groupBy('groups.id')->get();
    }

    /**
     * Get the user's complete groups.
     */
    public function completeGroups()
    {
        return \App\Models\Group::select('groups.*')
            ->join('colourisations', 'groups.id', '=', 'colourisations.group_id')
            ->where('colourisations.user_id', '=', \Auth::user()->id)
            ->whereNotNull('groups.archive')
            ->groupBy('groups.id')->get();
    }
}
