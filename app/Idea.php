<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    protected $guarded = ["id"];
    protected $with = ["changeType", "justification", "circle", "superCircle", "sme", "pendingAt", "status"];

    public function changeType()
    {
        return $this->belongsTo(ChangeType::class);
    }

    public function justification()
    {
        return $this->belongsTo(Justification::class);
    }

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function superCircle()
    {
        return $this->belongsTo(SuperCircle::class);
    }

    public function sme()
    {
        return $this->belongsTo(User::class);
    }

    public function pendingAt()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
