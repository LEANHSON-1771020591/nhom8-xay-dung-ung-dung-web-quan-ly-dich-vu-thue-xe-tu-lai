<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class AdminBlogController extends Controller
{
    private function ensureAdmin()
    {
        $u = Auth::user();
        if (!$u || $u->role !== 'admin') {
            return redirect('/admin/login')->with('error', 'Vui lòng đăng nhập với tài khoản admin');
        }
        return null;
    }

    public function index()
    {
        if ($r = $this->ensureAdmin()) return $r;
        $blogs = Blog::orderByDesc('id')->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        if ($r = $this->ensureAdmin()) return $r;
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $data = $request->validate([
            'title' => 'required|string|min:3',
            'link' => 'nullable|url',
            'content_text_preview' => 'required|string|min:3',
            'content_html' => 'required|string|min:3',
            'thumbnail' => 'required|url',
        ]);
        Blog::create($data);
        return redirect('/admin/blogs')->with('success', 'Đã tạo bài blog');
    }

    public function edit(Blog $blog)
    {
        if ($r = $this->ensureAdmin()) return $r;
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $data = $request->validate([
            'title' => 'required|string|min:3',
            'link' => 'nullable|url',
            'content_text_preview' => 'required|string|min:3',
            'content_html' => 'required|string|min:3',
            'thumbnail' => 'required|url',
        ]);
        $blog->update($data);
        return redirect('/admin/blogs')->with('success', 'Đã cập nhật bài blog');
    }

    public function destroy(Blog $blog)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $blog->delete();
        return redirect('/admin/blogs')->with('success', 'Đã xóa bài blog');
    }
}