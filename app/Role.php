<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * Get the users for the role.
     */
    public function users() {
        return $this->hasMany(User::class);
    }
}