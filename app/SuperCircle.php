<?php

namespace App;

class SuperCircle extends Model
{
    public function circles()
    {
        return $this->hasMany(Circle::class);
    }
}
