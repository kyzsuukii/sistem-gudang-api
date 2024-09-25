<?php

namespace App\Http\Controllers\Api\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\MutationRequest;
use App\Models\Item;
use App\Models\Mutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MutationController extends Controller
{
    public function index(Request $request)
    {
        $query = Mutation::with(['user', 'item']);

        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->whereHas('item', function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('code', 'like', "%{$searchTerm}%");
            });
        }

        $allowedSortFields = ['date', 'type', 'quantity', 'created_at', 'updated_at'];
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'asc');

        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $perPage = $request->input('per_page', 10);
        $mutations = $query->paginate($perPage);

        return response()->json($mutations);
    }

    public function store(MutationRequest $request)
    {
        $validatedData = $request->validated();

        $item = Item::find($validatedData['item_id']);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        if ($validatedData['type'] === 'out' && $item->stock < $validatedData['quantity']) {
            return response()->json(['error' => 'Insufficient stock'], 400);
        }

        $mutation = DB::transaction(function () use ($item, $validatedData) {
            $item->adjustStock($validatedData['type'], $validatedData['quantity']);

            $mutation = new Mutation($validatedData);
            $mutation->user_id = Auth::id();
            $mutation->save();

            return $mutation;
        });

        $mutation = Mutation::with(['user', 'item'])->find($mutation->id);

        return response()->json($mutation, 201);
    }

    public function show(string $id)
    {
        $mutation = Mutation::with(['user', 'item'])->find($id);

        if (!$mutation) {
            return response()->json(['error' => 'Mutation not found'], 404);
        }

        return response()->json($mutation);
    }

    public function update(Request $request, string $id)
    {
        return response()->json(['error' => 'Mutations cannot be updated'], 403);
    }

    public function destroy(string $id)
    {
        return response()->json(['error' => 'Mutations cannot be deleted'], 403);
    }
}
