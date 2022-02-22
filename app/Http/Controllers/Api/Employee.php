<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employee as mEmployee;

class Employee extends Controller
{
    public function index(Request $req)
    {
        $get = mEmployee::fetch();

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
                return (stristr($col->employee_code, $search) ||
                    stristr($col->employee_full_name, $search) ||
                    stristr($col->employee_phone_no, $search));
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
        if ($req->employee_id == 'undefined') {
            $duplicate = mEmployee::where('employee_code', $req->employee_code)
                ->get();
        } else {
            $duplicate = mEmployee::where('employee_code', $req->employee_code)
                ->where('employee_id', '<>', $req->employee_id)
                ->get();
        }

        $response = [];

        if ($duplicate->count() > 0) {
            $response = [
                'data'      => $duplicate,
                'status'    => false,
                'message'   => 'Employee Code has already exists.',
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
        $data = mEmployee::create([
            'employee_code'             => trim($req->employee_code),
            'employee_first_name'       => trim($req->employee_first_name),
            'employee_last_name'        => trim($req->employee_last_name),
            'employee_phone_no'         => trim($req->employee_phone_no),
        ]);

        return response()->json([
            'data'      => $data,
            'status'    => true,
            'message'   => 'New record has been saved.'
        ], 200);
    }

    public function save(Request $req)
    {
        $row = mEmployee::find($req->employee_id);

        $row->employee_code         = trim($req->employee_code);
        $row->employee_first_name   = trim($req->employee_first_name);
        $row->employee_last_name    = trim($req->employee_last_name);
        $row->employee_phone_no     = trim($req->employee_phone_no);

        $row->save();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully modified.'
        ], 200);
    }

    public function destroy(Request $req)
    {
        $row = mEmployee::find($req->employee_id);

        $row->save();
        $row->delete();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully deleted.'
        ], 200);
    }
}
