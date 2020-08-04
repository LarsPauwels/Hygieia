<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'address', 'email', 'logo_path'
    ];

    public function getImage()
    {
        return $this->logo_path;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function spaces()
    {
        return $this->hasMany(Space::class);
    }
}