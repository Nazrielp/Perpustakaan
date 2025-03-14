<?php

namespace App\Http\Controllers;

use App\Models\Returning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReturningController extends Controller
{
    public function index()
    {
        $data = Returning::get();

        return response()->json([
            'message' => 'data Returning',
            'data' => $data,
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
            'user_id' => 'required',
            'book_id' => 'required',
            'return_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid field'
            ], 401);
        }

        $db = new Returning();

        $db->user_id = $request->user_id;
        $db->book_id = $request->book_id;
        $db->return_date = $request->return_date;
        $db->save();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function show($id)
    {

        $data = Returning::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Return not found'
            ]);
        }

        return response()->json([
            'message' => 'data Return',
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
            'user_id' => 'required',
            'book_id' => 'required',
            'return_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid fields'
            ], 422);
        }

        $db = Returning::find($id);

        $db->user_id = $request->user_id;
        $db->book_id = $request->book_id;
        $db->return_date = $request->return_date;
        $db->save();

        return response()->json([
            'message' => 'update Return success'
        ]);
    }

    public function destroy(Request $request, $id)
    {

        if ($request->user()->tokenCant('admin')) {
            return response()->json([
                'message' => 'forbidden'
            ], 403);
        }

        $db = Returning::find($id);

        if (!$db) {
            return response()->json([
                'message' => 'Return not found'
            ]);
        }

        $db->delete();
        return response()->json([
            'message' => 'Return deleted'
        ]);
    }
}
