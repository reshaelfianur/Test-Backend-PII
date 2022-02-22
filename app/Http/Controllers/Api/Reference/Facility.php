<?php

namespace App\Http\Controllers\Api\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Facility as mFacility;

class Facility extends Controller
{
    public function index(Request $req)
    {
        $get = mFacility::all();

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
                return (stristr($col->facility_name, $search) ||
                    stristr($col->facility_description, $search));
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
        if ($req->facility_id == 'undefined') {
            $duplicate = mFacility::orWhere([
                'facility_name'             => $req->facility_name,
                'facility_description'      => $req->facility_description,
            ])
                ->get();
        } else {
            $duplicate = mFacility::orWhere([
                'facility_name'             => $req->facility_name,
                'facility_description'      => $req->facility_description,
            ])
                ->where('facility_id', '<>', $req->facility_id)->get();
        }

        $response = [];

        if ($duplicate->count() > 0) {
            $duplicate = $duplicate->first();

            if ($duplicate->facility_name == $req->facility_name) {
                $message = 'Facility name has already exists.';
            } elseif ($duplicate->facility_description == $req->facility_description) {
                $message = 'Facility Description has already exists.';
            }

            $response = [
                'data'      => $duplicate,
                'status'    => false,
                'message'   => $message,
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
        $data = mFacility::create([
            'facility_name'             => trim($req->facility_name),
            'facility_description'      => trim($req->facility_description),
        ]);

        return response()->json([
            'data'      => $data,
            'status'    => true,
            'message'   => 'New record has been saved.'
        ], 200);
    }

    public function save(Request $req)
    {
        $row = mFacility::find($req->facility_id);

        $row->facility_name             = trim($req->facility_name);
        $row->facility_description      = trim($req->facility_description);

        $row->save();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully modified.'
        ], 200);
    }

    public function destroy(Request $req)
    {
        $row = mFacility::find($req->facility_id);

        $row->save();
        $row->delete();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully deleted.'
        ], 200);
    }
}
