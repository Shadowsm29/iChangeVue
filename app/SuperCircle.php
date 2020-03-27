<?php

namespace App;

class SuperCircle extends Model
{
    protected $with = ["headOf"];

    public function circles()
    {
        return $this->hasMany(Circle::class);
    }

    public function headOf()
    {
        return $this->belongsTo(User::class, "head_of_id");
    }
}
