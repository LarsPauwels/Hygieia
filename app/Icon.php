<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $table = 'icons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image_url', 'type'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}