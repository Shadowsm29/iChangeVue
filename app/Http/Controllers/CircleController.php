<?php

namespace App\Http\Controllers;

use App\Circle;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CircleController extends Controller
{
    public function fetchCircles()
    {
        return Circle::all();
    }

    public function updateCircle(Request $request, Circle $circle)
    {
        $request->validate([
            'name' => ['required','string', Rule::unique("circles")->ignore($circle)],
            'super_circle_id' => 'required|exists:super_circles,id',
        ]);

        $circle->update($request->only(["name", "super_circle_id"]));

        return Circle::where("id", $circle->id)->first();
    }

    public function ceateNewCircle(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique("circles")],
            'super_circle_id' => 'required|exists:super_circles,id',
        ]);

        $circle = Circle::create([
            "name" => $request->name,
            "super_circle_id" => $request->super_circle_id,
        ]);

        return Circle::where("id", $circle->id)->first();;
    }

    public function deleteCircle(Circle $circle)
    {
        $circleId = $circle->id;

        $circle->delete();

        return $circleId;
    }
}
