<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;



class ArticleController extends Controller
{
    // Menampilkan daftar artikel
    public function index()
    {
        $articles = Article::with('category')->get();
        return view('articles.index', compact('articles'));
    }

    // Menampilkan form untuk membuat artikel baru
    public function create()
    {
        // Ambil seluruh kategori dari tabel kategori
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    // Menyimpan artikel baru
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Proses upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/articles');
        }

        // Menyimpan data artikel
        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully');
    }

    // Menampilkan form untuk mengedit artikel
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    // Memperbarui artikel
    public function update(Request $request, $id)
    {
        // Validasi inputan
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $article = Article::findOrFail($id);

        // Proses upload gambar jika ada
        $imagePath = $article->image; // Menyimpan path gambar lama jika tidak diubah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($article->image) {
                Storage::delete($article->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('public/articles');
        }

        // Memperbarui data artikel
        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully');
    }

    // Menghapus artikel
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        // Hapus gambar jika ada
        if ($article->image) {
            Storage::delete($article->image);
        }

        // Hapus artikel
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully');
    }
}