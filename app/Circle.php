<?php

namespace App;

class Circle extends Model
{
    protected $with = ['superCircle'];

    public function superCircle()
    {
        return $this->belongsTo(SuperCircle::class);
    }
}
