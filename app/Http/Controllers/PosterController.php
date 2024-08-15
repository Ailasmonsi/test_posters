<?php

namespace App\Http\Controllers;

use App\Models\Poster;
use Illuminate\Http\Request;

class PosterController extends Controller
{
    public function index(Request $request)
    {
        $posters = Poster::query();

        if ($request->has('sort_by')) {
            $sortBy = $request->get('sort_by');
            $order = $request->get('order', 'asc');

            if (in_array($sortBy, ['price', 'created_at'])) {
                $posters->orderBy($sortBy, $order);
            }
        }

        $posters = $posters->paginate(10);

        $response = $posters->map(function ($poster) {
            return [
                'id' => $poster->id,
                'title' => $poster->title,
                'main_photo' => $poster->photos[0] ?? null,
                'price' => $poster->price,
            ];
        });

        return response()->json([
            'data' => $response,
            'pagination' => [
                'total' => $posters->total(),
                'per_page' => $posters->perPage(),
                'current_page' => $posters->currentPage(),
                'last_page' => $posters->lastPage(),
                'from' => $posters->firstItem(),
                'to' => $posters->lastItem(),
            ],
        ]);
    }

    public function show($id, Request $request)
    {
        $poster = Poster::findOrFail($id);

        $response = [
            'title' => $poster->title,
            'price' => $poster->price,
            'main_photo' => $poster->photos[0] ?? null,
        ];

        if ($request->has('fields')) {
            $fields = explode(',', $request->get('fields'));

            if (in_array('description', $fields)) {
                $response['description'] = $poster->description;
            }

            if (in_array('photos', $fields)) {
                $response['photos'] = $poster->photos;
            }
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'photos' => 'nullable|array|max:3',
            'photos.*' => 'nullable|url',
            'price' => 'required|numeric|min:0',
        ]);

        $poster = Poster::create($validated);

        return response()->json(['id' => $poster->id, 'status' => 'success']);
    }
}
