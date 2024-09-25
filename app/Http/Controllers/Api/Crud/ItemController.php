<?php

namespace App\Http\Controllers\Api\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('category');

        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('code', 'like', "%{$searchTerm}%")
                    ->orWhere('location', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $allowedSorts = ['name', 'code', 'location', 'stock', 'created_at', 'updated_at'];
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'asc');

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $perPage = $request->input('per_page', 10);
        $items = $query->paginate($perPage);

        return response()->json($items);
    }

    public function store(ItemRequest $request)
    {
        $item = Item::create($request->validated());

        return response()->json($item, 201);
    }

    public function show(string $id)
    {
        $item = Item::with('category')->find($id);

        if (!$item) {
            return response()->json([
                'message' => 'Item not found',
            ], 404);
        }

        return response()->json($item);
    }

    public function update(ItemRequest $request, string $id)
    {
        $item = $this->findItemOrFail($id);

        $item->update($request->validated());

        return response()->json($item);
    }

    public function destroy(string $id)
    {
        $item = $this->findItemOrFail($id);

        $item->delete();

        return response()->json(null, 204);
    }

    protected function findItemOrFail(string $id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json([
                'message' => 'Item not found',
            ], 404);
        }
        return $item;
    }
}
