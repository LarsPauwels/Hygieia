<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'quantity', 'image_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function icon()
    {
        return $this->belongsTo(Icon::class, 'image_id');
    }
}