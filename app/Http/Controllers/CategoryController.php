<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use App\Models\User;

class CategoryController extends Controller
{

    use HasFactory;

    public function index()
    {
        return response()->json(User::all());
    }

    public function show($uuid)
    {
        return response()->json(User::findOrFail($uuid));
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function update(Request $request, $uuid)
    {
        $user = User::findOrFail($uuid);
        $user->update($request->all());
        return response()->json($user);
    }

    public function destroy($uuid)
    {
        $user = User::findOrFail($uuid);
        $user->delete();
        return response()->json(null, 204);
    }
}
