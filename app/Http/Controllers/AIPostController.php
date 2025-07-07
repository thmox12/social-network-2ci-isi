<?php
// app/Http/Controllers/AIPostController.php

namespace App\Http\Controllers;

use App\Http\Requests\GeneratePostRequest;
use App\Http\Requests\StorePostRequest;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AIPostController extends Controller
{
    private GeminiService $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function create()
    {
        return view('ai-posts.create');
    }

    public function generate(GeneratePostRequest $request)
    {
        try {
            $content = $this->geminiService->generatePostContent($request->prompt);
            
            return view('ai-posts.preview', [
                'prompt' => $request->prompt,
                'title' => ucfirst($request->prompt),
                'content' => $content,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function store(StorePostRequest $request)
    {
        $post = Auth::user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
            'is_ai_generated' => true,
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'AI-generated post created successfully!');
    }
}