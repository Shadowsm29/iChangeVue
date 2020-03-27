<?php

namespace App\Http\Controllers;

use App\ChangeType;
use Illuminate\Http\Request;

class ChangeTypeController extends Controller
{
    public function fetchChangeTypes()
    {
        return ChangeType::all();
    }
}
