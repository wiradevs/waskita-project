<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MediaUploadController extends Controller
{
    private array $allowedKeys = [
        'hero_video', 'hero_image', 'about_video', 'about_image', 'company_logo',
    ];

    public function store(Request $request)
    {
        $key = $request->input('key');

        if (! in_array($key, $this->allowedKeys)) {
            return back()->with('upload_error', 'Key tidak valid.');
        }

        $isVideo = str_ends_with($key, '_video');
        $rules   = $isVideo
            ? ['file' => 'required|file|mimes:mp4,webm|max:524288']
            : ['file' => 'required|file|mimes:jpg,jpeg,png,webp,gif|max:20480'];

        $request->validate($rules);

        // Hapus file lama jika ada
        $old = CompanySetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }

        // Simpan file baru
        $path = $request->file('file')->store('settings', 'public');

        CompanySetting::set($key, $path, 'image');
        Cache::forget("setting_{$key}");

        return back()->with('upload_success', 'File berhasil diupload!');
    }

    public function destroy(Request $request)
    {
        $key = $request->input('key');

        if (! in_array($key, $this->allowedKeys)) {
            return back()->with('upload_error', 'Key tidak valid.');
        }

        $path = CompanySetting::get($key);
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        CompanySetting::set($key, null, 'image');
        Cache::forget("setting_{$key}");

        return back()->with('upload_success', 'File berhasil dihapus.');
    }
}
