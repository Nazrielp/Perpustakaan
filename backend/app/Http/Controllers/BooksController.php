<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    public function index()
    {
        $data = Books::get();

        return response()->json([
            'message' => 'data Books',
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
            'title' => 'required',
            'author' => 'required',
            'year' => 'required',
            'genre' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid field'
            ], 401);
        }

        $db = new Books();

        $db->title = $request->title;
        $db->author = $request->author;
        $db->year = $request->year;
        $db->genre = $request->genre;
        $db->status = $request->status;
        $db->save();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function show($id)
    {

        $data = Books::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Book not found'
            ]);
        }

        return response()->json([
            'message' => 'data Book',
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
            'title' => 'required',
            'author' => 'required',
            'year' => 'required',
            'genre' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid fields'
            ], 422);
        }

        $db = Books::find($id);

        $db->title = $request->title;
        $db->author = $request->author;
        $db->year = $request->year;
        $db->genre = $request->genre;
        $db->status = $request->status;
        $db->save();

        return response()->json([
            'message' => 'update Book success'
        ]);
    }

    public function destroy(Request $request, $id)
    {

        if ($request->user()->tokenCant('admin')) {
            return response()->json([
                'message' => 'forbidden'
            ], 403);
        }

        $db = Books::find($id);

        if (!$db) {
            return response()->json([
                'message' => 'Book not found'
            ]);
        }

        $db->delete();
        return response()->json([
            'message' => 'Book deleted'
        ]);
    }
}
