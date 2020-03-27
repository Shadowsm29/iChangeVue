<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Permission as AppPermission;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    public function fetchAllIdeas()
    {
        return Idea::all();
    }

    public function fetchMyIdeas()
    {
        return Idea::where("initiator_id", Auth::user()->id)->get();
    }

    public function fetchIdeasPendingAtMe()
    {
        return Idea::where("pending_at_id", Auth::user()->id)->get();
    }

    public function fetchIdea(Idea $idea)
    {
        if(
            Auth::user()->id == $idea->initiator_id ||
            Auth::user()->id == $idea->pending_at_id ||
            Auth::user()->id == $idea->sme_id ||
            Auth::user()->can(AppPermission::SEE_ALL_IDEAS)
            ) {
                return Idea::where("id", $idea->id)->firstOrFail();
            } 

            return response()->json([
                'errors' => [
                    'message' => ['You are not authorized to see this content']
                ]
            ], 403); 
    }

    public function createIdea(Request $request)
    {
        $request->validate([
            "title" => "required|string",
            "changeType" => "required|exists:change_types,id",
            "justification" => "required|exists:justifications,id",
            "superCircle" => "required|exists:super_circles,id",
            "circle" => "required|exists:circles,id",
            "expectedEffort" => "nullable|integer",
            "expectedBenefit" => "required|integer",
            "description" => "required|string",
            "sme" => "required|exists:users,id",
        ]);

        $idea = Idea::create([
            "title" => $request->title,
            "change_type_id" => $request->changeType,
            "justification_id" => $request->justification,
            "super_circle_id" => $request->superCircle,
            "circle_id" => $request->circle,
            "expected_effort" =>
            $request->expectedEffort ? $request->expectedEffort : null,
            "expected_benefit" => $request->expectedBenefit,
            "description" => $request->description,
            "sme_id" => $request->sme,
            "pending_at_id" => Auth::user()->manager_id,
            "initiator_id" => Auth::user()->id,
            "status_id" => Status::getStatusId(Status::LINE_MAN_APPR),
        ]);

        $idea->update([
            "request_number" => "REQ" . sprintf("%05d", $idea->id),
        ]);

        return $idea;
    }
}
