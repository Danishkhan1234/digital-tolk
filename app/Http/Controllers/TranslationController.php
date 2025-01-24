<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationRequest;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('per_page',10);

        $translations = Translation::query()
                            ->select('id', 'lang', 'key', 'tags', 'value')
                            ->whereAny([
                                'lang',
                                'key',
                                'tags',
                                'value',
                            ], 'like', "%".request('q')."%")
                            ->paginate($perPage)
                            ->withQueryString();

        return response()->json([
            'message' => 'Get Translation.',
            'data' => $translations,
        ], 201);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TranslationRequest $request)
    {
        
        $translation = Translation::create([
                            ...$request->validated(),
                            'user_id' => Auth::id(),
                        ]);

        return response()->json([
            'message' => 'Translation created successfully.',
            'data' => $translation,
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TranslationRequest $request, Translation $translation)
    {
        $translation->update($request->validated());

        return response()->json([
            'message' => 'Translation updated successfully.',
            'data' => $translation,
        ], 201);
    }
    
}
