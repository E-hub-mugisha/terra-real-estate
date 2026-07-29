<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AiSearchController extends Controller
{
    protected $aiSearch;

    public function __construct()
    {
        $this->aiSearch = app(\App\Services\AiSearchService::class);
    }

    /**
     * Show the AI search page.
     */
    public function index()
    {
        return view('front.aisearch');
    }

    /**
     * Handle an AI search query (AJAX). Returns extracted filters + grouped results.
     */
    public function query(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|max:500',
        ]);

        $result = $this->aiSearch->search(trim($request->input('q')));

        return response()->json($result);
    }
}
