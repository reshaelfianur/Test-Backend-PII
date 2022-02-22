<?php

namespace App\Http\Controllers\Api\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Room as mRoom;

class Room extends Controller
{
    public function index(Request $req)
    {
        $get = mRoom::all();

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
                    stristr($col->room_capacity, $search) ||
                    stristr($col->room_description, $search));
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
        if ($req->room_id == 'undefined') {
            $duplicate = mRoom::orWhere([
                'room_name'             => $req->room_name,
                'room_description'      => $req->room_description,
            ])
                ->get();
        } else {
            $duplicate = mRoom::orWhere([
                'room_name'             => $req->room_name,
                'room_description'      => $req->room_description,
            ])
                ->where('room_id', '<>', $req->room_id)->get();
        }

        $response = [];

        if ($duplicate->count() > 0) {
            $duplicate = $duplicate->first();

            if ($duplicate->room_name == $req->room_name) {
                $message = 'Room name has already exists.';
            } elseif ($duplicate->room_description == $req->room_description) {
                $message = 'Room Description has already exists.';
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
        $data = mRoom::create([
            'room_name'             => trim($req->room_name),
            'room_description'      => trim($req->room_description),
            'room_capacity'         => trim($req->room_capacity),
        ]);

        return response()->json([
            'data'      => $data,
            'status'    => true,
            'message'   => 'New record has been saved.'
        ], 200);
    }

    public function save(Request $req)
    {
        $row = mRoom::find($req->room_id);

        $row->room_name             = trim($req->room_name);
        $row->room_description      = trim($req->room_description);
        $row->room_capacity         = trim($req->room_capacity);

        $row->save();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully modified.'
        ], 200);
    }

    public function destroy(Request $req)
    {
        $row = mRoom::find($req->room_id);

        $row->save();
        $row->delete();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully deleted.'
        ], 200);
    }
}
