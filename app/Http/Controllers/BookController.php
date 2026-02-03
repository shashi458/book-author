<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class BookController extends Controller
{

    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => Book::with('author')->get()
        ], 200);
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title'     => 'required|string|max:255',
                'author_id' => 'required|integer|exists:authors,id',
            ]);

            $book = Book::create($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Book created successfully',
                'data'    => $book,
            ], 201);

        } catch (ValidationException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $e->errors(),
            ], 422);

        } catch (Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $book = Book::with('author')->findOrFail($id);

            return response()->json([
                'status' => true,
                'data'   => $book,
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Book not found',
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title'     => 'required|string|max:255',
                'author_id' => 'required|integer|exists:authors,id',
            ]);

            $book = Book::findOrFail($id);
            $book->update($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Book updated successfully',
                'data'    => $book,
            ], 200);

        } catch (ValidationException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $e->errors(),
            ], 422);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Book not found',
            ], 404);

        } catch (Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Book deleted successfully',
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Book not found',
            ], 404);
        }
    }
}
