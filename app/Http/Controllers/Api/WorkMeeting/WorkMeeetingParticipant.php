<?php

namespace App\Http\Controllers\Api\WorkMeeting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Work_meeting_participant;

class WorkMeeetingParticipant extends Controller
{
    public function index(Request $req)
    {
        $get = Work_meeting_participant::all();

        if (empty($req->_page)) {
            return response()->json([
                'data'      => $get,
                'status'    => true
            ], 200);
        }

        $search     = $req->_search;
        $limit      = $req->_pageSize;
        $offset     = ($req->_page - 1) * $limit;
        $sort       = explode(':', $req->_sortby);
        $column     = $sort[0];
        $get        = $sort[1] == 1 ? $get->sortBy($column) : $get->sortByDesc($column);
        $total      = $get->count();
        $numPage    = $total / $limit;

        if (!empty($search)) {
            $get = $get->filter(function ($col, $val) use ($search) {
                return (stristr($col->wm_name, $search) ||
                    stristr($col->employee_full_name, $search));
            });
        }

        return response()->json([
            'documentSize'  => $get->count(),
            'numberOfPages' => $numPage <= 1 ? 1 : floor($numPage) + 1,
            'page'          => $req->_page,
            'pageSize'      => $limit,
            'data'          => $get->slice($offset, $limit)->values()->all(),
            'status'        => true,
        ], 200);
    }

    public function absenceSave(Request $req)
    {
        $row = Work_meeting_participant::where('wm_id', $req->wm_id)
            ->where('employee_id', $req->employee_id)
            ->update([
                'wmp_absence_status'    => $req->wmp_absence_status,
                'wmp_datetime_absence'  => $req->wmp_datetime_absence,
                'wmp_absence_note'      => trim($req->wmp_absence_note),
            ]);

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully modified.'
        ], 200);
    }
}
