<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowingController extends Controller
{
    public function index()
    {
        $data = Borrowing::get();

        return response()->json([
            'message' => 'data borrowing',
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
            'borrow_date' => 'required',
            'return_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid field'
            ], 401);
        }

        $db = new Borrowing();

        $db->user_id = $request->user_id;
        $db->book_id = $request->book_id;
        $db->borrow_date = $request->borrow_date;
        $db->return_date = $request->return_date;
        $db->save();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function show($id)
    {

        $data = Borrowing::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Borrowing not found'
            ]);
        }

        return response()->json([
            'message' => 'data Borrowing',
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
            'borrow_date' => 'required',
            'return_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid fields'
            ], 422);
        }

        $db = Borrowing::find($id);

        $db->user_id = $request->user_id;
        $db->book_id = $request->book_id;
        $db->borrow_date = $request->borrow_date;
        $db->return_date = $request->return_date;
        $db->save();

        return response()->json([
            'message' => 'update Borrowing success'
        ]);
    }

    public function destroy(Request $request, $id)
    {

        if ($request->user()->tokenCant('admin')) {
            return response()->json([
                'message' => 'forbidden'
            ], 403);
        }

        $db = Borrowing::find($id);

        if (!$db) {
            return response()->json([
                'message' => 'Borrowing not found'
            ]);
        }

        $db->delete();
        return response()->json([
            'message' => 'Borrowing deleted'
        ]);
    }
}
