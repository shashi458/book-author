<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class AuthorController extends Controller
{

    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => Author::with('books')->get(),
        ], 200);
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:authors,email',
            ]);

            $author = Author::create($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Author created successfully',
                'data'    => $author,
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
            $author = Author::with('books')->findOrFail($id);

            return response()->json([
                'status' => true,
                'data'   => $author,
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Author not found',
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:authors,email,' . $id,
            ]);

            $author = Author::findOrFail($id);
            $author->update($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Author updated successfully',
                'data'    => $author,
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
                'message' => 'Author not found',
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
            $author = Author::findOrFail($id);
            $author->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Author deleted successfully',
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Author not found',
            ], 404);
        }
    }
}
