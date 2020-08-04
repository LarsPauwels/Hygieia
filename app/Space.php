<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $fillable = ['name', 'client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items() 
    {
        return $this->hasMany(Item::class);
    }
}