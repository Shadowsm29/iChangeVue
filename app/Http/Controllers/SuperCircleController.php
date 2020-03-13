<?php

namespace App\Http\Controllers;

use App\Circle;
use App\SuperCircle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SuperCircleController extends Controller
{
    public function fetchSuperCircles()
    {
        return SuperCircle::with("circles")->get();
    }

    public function updateSuperCircle(Request $request, SuperCircle $superCircle)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique("super_circles")->ignore($superCircle)],
        ]);

        $superCircle->update($request->only(["name"]));

        return SuperCircle::where("id", $superCircle->id)->first();
    }

    public function createNewSuperCircle(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique("super_circles")],
        ]);

        $superCircle = SuperCircle::create([
            "name" => $request->name,
        ]);

        return SuperCircle::where("id", $superCircle->id)->first();;
    }

    public function deleteSuperCircle(SuperCircle $superCircle)
    {
        if (Circle::where("super_circle_id", $superCircle->id)->count() > 0) {

            return response()->json([
                'errors' => [
                    'message' => ['Super circle is still attached to one or more Circles']
                ]
            ], 422);
        }

        $superCircleId = $superCircle->id;

        $superCircle->delete();

        return $superCircleId;
    }
}
