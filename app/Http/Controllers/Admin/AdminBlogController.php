<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'content_text_preview' => 'required|string|min:3',
            'content_html' => 'required|string|min:3',
            'thumbnail' => 'required|string',
        ]);
        $data['thumbnail'] = $this->persistThumbnail($data['thumbnail']);
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
            'content_text_preview' => 'required|string|min:3',
            'content_html' => 'required|string|min:3',
            'thumbnail' => 'required|string',
        ]);
        $data['thumbnail'] = $this->persistThumbnail($data['thumbnail']);
        $blog->update($data);
        return redirect('/admin/blogs')->with('success', 'Đã cập nhật bài blog');
    }

    public function destroy(Blog $blog)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $blog->delete();
        return redirect('/admin/blogs')->with('success', 'Đã xóa bài blog');
    }

    private function persistThumbnail(string $url): string
    {
        try {
            if (!Str::startsWith($url, ['http://','https://','//'])) return $url;
            $resp = Http::timeout(10)->get($url);
            if ($resp->ok()) {
                $mime = $resp->header('Content-Type') ?: 'image/jpeg';
                $ext = Str::contains($mime, 'png') ? 'png' : (Str::contains($mime, 'webp') ? 'webp' : 'jpg');
                $name = 'blog_thumbs/'.Str::uuid().'.'.$ext;
                Storage::disk('public')->put($name, $resp->body());
                return $name;
            }
        } catch (\Throwable $e) {}
        return $url;
    }
}