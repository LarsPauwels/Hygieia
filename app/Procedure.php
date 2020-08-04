<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
	protected $table = 'procedures';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 'description'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}