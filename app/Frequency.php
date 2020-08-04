<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    protected $table = 'frequencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}