<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Marketplace\AiAssistant;
use Illuminate\Http\Request;

/** POST /ai/assistant — one chat turn of Terra AI (search + questions). */
class AiAssistantController extends Controller
{
    public function __invoke(Request $request, AiAssistant $assistant)
    {
        $data = $request->validate([
            'message' => 'required|string|min:2|max:500',
            'history' => 'nullable|array|max:12',
            'history.*.role' => 'required|in:user,assistant',
            'history.*.content' => 'required|string|max:1500',
        ]);

        // The conversation must alternate and start with the user, as the API expects.
        $history = [];
        foreach ($data['history'] ?? [] as $turn) {
            $last = end($history);
            if ((!$history && $turn['role'] !== 'user') || ($last && $last['role'] === $turn['role'])) {
                continue;
            }
            $history[] = ['role' => $turn['role'], 'content' => trim($turn['content'])];
        }
        if ($history && end($history)['role'] === 'user') {
            array_pop($history);
        }

        return response()->json($assistant->respond(trim($data['message']), $history));
    }
}
