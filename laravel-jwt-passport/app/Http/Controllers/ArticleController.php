<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $articles = Article::with('category')->paginate(10);
        return response()->json($articles);
    }

    public function show($id)
    {
        $article = Article::with('category')->findOrFail($id);
        return response()->json($article);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        return response()->json($article, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $article = Article::findOrFail($id);
        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ]);

        return response()->json($article);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json(['message' => 'Article deleted successfully']);
    }
}
