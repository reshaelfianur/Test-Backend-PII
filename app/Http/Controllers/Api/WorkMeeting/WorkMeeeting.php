<?php

namespace App\Http\Controllers\Api\WorkMeeting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Work_meeting;
use App\Models\Minutes_of_meeting;
use App\Models\Work_meeting_participant;

class WorkMeeeting extends Controller
{
    public function index(Request $req)
    {
        $get = Work_meeting::fetch();

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
                return (stristr($col->room_name, $search) ||
                    stristr($col->employee_full_name, $search) ||
                    stristr($col->wm_name, $search) ||
                    stristr($col->wm_description, $search));
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

    public function unique(Request $req)
    {
        if ($req->wm_id == 'undefined') {
            $duplicate = Work_meeting::whereBetween('wm_datetime_in', [$req->wm_datetime_in, $req->wm_datetime_out])
                ->orWhereBetween('wm_datetime_out', [$req->wm_datetime_in, $req->wm_datetime_out])
                ->get();
        } else {
            $duplicate = Work_meeting::where(function ($query) use ($req) {
                $query->wwhereBetween('wm_datetime_in', [$req->wm_datetime_in, $req->wm_datetime_out])
                    ->orWhereBetween('wm_datetime_out', [$req->wm_datetime_in, $req->wm_datetime_out]);
            })
                ->where('wm_id', '<>', $req->wm_id)
                ->get();
        }

        $response = [];

        if ($duplicate->count() > 0) {
            $response = [
                'data'      => $duplicate,
                'status'    => false,
                'message'   => 'Work Meeting date has already not available.',
            ];
        } else {
            $response = [
                'data'      => true,
                'status'    => true
            ];
        }

        return response()->json($response, 200);
    }

    public function store(Request $req)
    {
        $facilityIds    = json_decode($req->facility_ids);
        $employeeIds    = json_decode(base64_decode($req->employee_ids));

        $data = Work_meeting::create([
            'room_id'                       => $req->room_id,
            'wm_name'                       => trim($req->wm_name),
            'wm_description'                => trim($req->wm_description),
            'wm_datetime_in'                => $req->wm_datetime_in,
            'wm_datetime_out'               => $req->wm_datetime_out,
            'wm_number_of_participants'     => $req->wm_number_of_participants,
            'created_by'                    => $req->created_by,
        ]);

        $data->facilities()->attach($facilityIds);

        $workMeetingParticipant = [];

        foreach ($employeeIds as $key => $value) {
            $workMeetingParticipant[] = [
                'wm_id'             => $data->wm_id,
                'employee_id'       => $value->employee_id,
                'wmp_is_minutes'    => !empty($value->wmp_is_minutes) ? $value->wmp_is_minutes : null,
            ];
        }

        $wmp = Work_meeting_participant::insert($workMeetingParticipant);
        $wmp = Work_meeting_participant::where([
            'wm_id'             => $data->wm_id,
            'wmp_is_minutes'    => 1
        ])->get();

        $minutesOfMeeting = [];

        foreach ($wmp as $key => $value) {
            $minutesOfMeeting[] = [
                'wm_id'     => $data->wm_id,
                'wmp_id'    => $value->wmp_id
            ];
        }

        $mom = Minutes_of_meeting::insert($minutesOfMeeting);

        return response()->json([
            'data'      => $data,
            'status'    => true,
            'message'   => 'New record has been saved.'
        ], 200);
    }

    public function save(Request $req)
    {
        $facilityIds            = json_decode($req->facility_ids);
        $oldFacilityIds         = json_decode($req->old_facility_ids);
        $addEmployeeIds         = json_decode(base64_decode($req->add_employee_ids));
        $deleteEmployeeIds      = json_decode(base64_decode($req->delete_employee_ids));

        $row = Work_meeting::find($req->wm_id);

        $row->room_id                       = $req->room_id;
        $row->wm_name                       = trim($req->wm_name);
        $row->wm_description                = trim($req->wm_description);
        $row->wm_datetime_in                = $req->wm_datetime_in;
        $row->wm_datetime_out               = $req->wm_datetime_out;
        $row->wm_number_of_participants     = $req->wm_number_of_participants;
        $row->updated_by                    = $req->updated_by;

        $row->facilities()->detach($oldFacilityIds);
        $row->facilities()->attach($facilityIds);

        $row->save();

        if (count($addEmployeeIds) > 0) {
            $workMeetingParticipant = [];

            foreach ($addEmployeeIds as $key => $value) {
                $workMeetingParticipant[] = [
                    'wm_id'             => $req->wm_id,
                    'employee_id'       => $value->employee_id,
                    'wmp_is_minutes'    => !empty($value->wmp_is_minutes) ? $value->wmp_is_minutes : null,
                ];
            }

            $wmp = Work_meeting_participant::insert($workMeetingParticipant);
            $wmp = Work_meeting_participant::where([
                'wm_id'             => $req->wm_id,
                'wmp_is_minutes'    => 1
            ])
                ->whereIn('employee_id', array_column($addEmployeeIds, 'employee_id'))
                ->get();

            if ($wmp->count() > 0) {
                $minutesOfMeeting = [];

                foreach ($wmp as $key => $value) {
                    $minutesOfMeeting[] = [
                        'wm_id'     => $req->wm_id,
                        'wmp_id'    => $value->wmp_id
                    ];
                }

                $mom = Minutes_of_meeting::insert($minutesOfMeeting);
            }
        }

        if (count($deleteEmployeeIds) > 0) {
            $wmp = Work_meeting_participant::where([
                'wm_id' => $req->wm_id,
            ])
                ->whereIn('employee_id', array_column($deleteEmployeeIds, 'employee_id'));

            $wmpGet     = $wmp->get();
            $wmpDelete  = $wmp->update(['deleted_at' => now()->format('Y-m-d H:i:s')]);

            $mom = Minutes_of_meeting::where([
                'wm_id' => $req->wm_id,
            ])
                ->whereIn('wmp_id', array_column($wmpGet->toArray(), 'wmp_id'))
                ->update(['deleted_at' => now()->format('Y-m-d H:i:s')]);
        }

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully modified.'
        ], 200);
    }

    public function destroy(Request $req)
    {
        $row = Work_meeting::find($req->wm_id);

        $row->save();
        $row->delete();

        $wmp = Work_meeting_participant::where([
            'wm_id' => $req->wm_id,
        ])->update(['deleted_at' => now()->format('Y-m-d H:i:s')]);

        $mom = Minutes_of_meeting::where([
            'wm_id' => $req->wm_id,
        ])->update(['deleted_at' => now()->format('Y-m-d H:i:s')]);

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully deleted.'
        ], 200);
    }

    public function agrementSave(Request $req)
    {
        $row = Work_meeting::find($req->wm_id);

        $row->wm_agreement_status       = $req->wm_agreement_status;
        $row->wm_agreement_note         = trim($req->wm_agreement_note);

        $row->save();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully modified.'
        ], 200);
    }
}
