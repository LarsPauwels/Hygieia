<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'space_id', 'frequency_id', 'procedure_id', 'image_id'
    ];

    public function icon()
    {
        return $this->belongsTo(Icon::class, 'image_id');
    }

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function frequency() {
        return $this->belongsTo(Frequency::class);
    }

    public function procedure() {
        return $this->belongsTo(Procedure::class);
    }
}