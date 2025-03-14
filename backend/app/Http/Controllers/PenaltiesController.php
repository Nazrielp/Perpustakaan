<?php

namespace App\Http\Controllers;

use App\Models\Penalties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenaltiesController extends Controller
{
    public function index()
    {
        $data = Penalties::get();

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        if ($request->user()->tokenCant('admin')) {
            return response()->json([
                'message' => 'forbidden'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'penalties_name' => 'required',
            'description' => 'required',
            'book_id' => 'required',
            'penalties_total' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid fields'
            ], 422);
        }

        $db = new Penalties();

        $db->penalties_name = $request->penalties_name;
        $db->description = $request->description;
        $db->book_id = $request->book_id;
        $db->penalties_total = $request->penalties_total;
        $db->save();

        return response()->json([
            'message' => 'create Penalties success'
        ]);
    }

    public function show($id)
    {

        $data = Penalties::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Penalties not found'
            ]);
        }

        return response()->json([
            'message' => 'data Penalties',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->tokenCant('admin')) {
            return response()->json([
                'message' => 'forbidden'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'penalties_name' => 'required',
            'description' => 'required',
            'book_id' => 'required',
            'penalties_total' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid fields'
            ], 422);
        }

        $db = Penalties::find($id);

        $db->penalties_name = $request->penalties_name;
        $db->description = $request->description;
        $db->book_id = $request->book_id;
        $db->penalties_total = $request->penalties_total;
        $db->save();

        return response()->json([
            'message' => 'update Penalties success'
        ]);
    }

    public function destroy(Request $request, $id)
    {

        if ($request->user()->tokenCant('admin')) {
            return response()->json([
                'message' => 'forbidden'
            ], 403);
        }

        $db = Penalties::find($id);

        if (!$db) {
            return response()->json([
                'message' => 'Penalties not found'
            ]);
        }

        $db->delete();
        return response()->json([
            'message' => 'Penalties deleted'
        ]);
    }
}
