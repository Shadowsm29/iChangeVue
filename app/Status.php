<?php

namespace App;

class Status extends Model
{
    const LINE_MAN_APPR = "Initial Line Manager Approval";
    const CORR_NEEDED = "Correction Needed";
    const REJECTED = "Rejected";
    const WIP = "Work in Progress";
    const HEAD_APPR = "Head of Supercircle Approval";
    const SUPPORT_TEAM_ASSESSMENT = "Support Team Assessment";
    const MT_APPROVAL = "Management Team Approval";
    const CHG_BOARD_PRIORIT = "Change Board Prioritization";
    const REWORK_NEEDED = "Rework Needed";
    const IMPLEMENTED = "Implemented";

    public static function getStatusId($statusTitle)
    {
        $status = Status::where("title", $statusTitle)->firstOrFail();
        return $status->id;
    }
}
