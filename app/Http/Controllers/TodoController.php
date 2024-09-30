<?php
namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $todos = Todo::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return response()->json(['status' => true, 'data' => $todos]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // Verifica si el usuario está autenticado
        if (!$request->user()) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        $validateUser = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tags' => 'nullable|string',
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateUser->errors()
            ], 400);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $todo = Todo::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'image' => $imagePath,
            'tags' => $request->tags,
        ]);

        return response()->json(['status' => true, 'data' => $todo], 201);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $todo = Todo::findOrFail($id);
        return response()->json(['status' => true, 'data' => $todo], 200);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $todo = Todo::findOrFail($id);

        $validateUser = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
            'tags' => 'nullable|string',
            'has_completed' => 'required|boolean',
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validateUser->errors()
            ], 400);
        }

        $imagePath = $todo->image; 
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $todo->update(array_merge($request->all(), ['image' => $imagePath]));

        return response()->json(['status' => true, 'data' => $todo], 200);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return response()->json(['status' => true, 'message' => 'Todo deleted successfully'], 200);
    }
}
