<?php

namespace App\Http\Controllers;

use App\Justification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JustificationController extends Controller
{
    public function fetchJustifications()
    {
        return Justification::all();
    }

    public function updateJustification(Request $request, Justification $justification)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique("justifications")->ignore($justification)],
        ]);

        $justification->update($request->only(["name"]));

        return Justification::where("id", $justification->id)->first();
    }

    public function createNewJustification(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique("justifications")],
        ]);

        $justification = Justification::create([
            "name" => $request->name,
        ]);

        return Justification::where("id", $justification->id)->first();;
    }

    public function deleteJustification(Justification $justification)
    {
        $justificationId = $justification->id;

        $justification->delete();

        return $justificationId;
    }
}
