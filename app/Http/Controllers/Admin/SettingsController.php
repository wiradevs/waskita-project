<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    private array $fileKeys = ['hero_image', 'hero_video', 'about_image', 'about_video', 'catalog_image', 'catalog_video', 'contact_image', 'contact_video', 'company_logo'];

    private array $textKeys = [
        'company_name', 'company_tagline', 'company_about',
        'company_address', 'company_phone', 'company_email',
        'company_whatsapp', 'company_instagram', 'company_facebook',
        'hero_title', 'hero_subtitle',
    ];

    public function index()
    {
        $settings = [];
        foreach (array_merge($this->textKeys, $this->fileKeys) as $key) {
            $settings[$key] = CompanySetting::get($key);
        }
        return view('admin.settings.index', compact('settings'));
    }

    // Handles text + image settings (NOT video — video uses uploadMedia)
    public function update(Request $request)
    {
        $imageKeys = ['hero_image', 'about_image', 'catalog_image', 'contact_image', 'company_logo'];

        foreach ($this->textKeys as $key) {
            if ($request->has($key)) {
                CompanySetting::set($key, $request->input($key), 'text');
            }
        }

        foreach ($imageKeys as $key) {
            if ($request->boolean('delete_' . $key)) {
                $old = CompanySetting::get($key);
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
                CompanySetting::set($key, null, 'image');
                continue;
            }
            if ($request->hasFile($key) && $request->file($key)->isValid()) {
                $old = CompanySetting::get($key);
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
                $path = $request->file($key)->store('settings', 'public');
                CompanySetting::set($key, $path, 'image');
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    // AJAX endpoint — uploads a single media file (video or image)
    public function uploadMedia(Request $request)
    {
        $key = $request->input('key');
        $allowed = $this->fileKeys;

        if (!in_array($key, $allowed)) {
            return response()->json(['error' => 'Key tidak valid.'], 422);
        }

        // Detect PHP-level upload failures before validation
        if (isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_OK && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {
            $msg = match ($_FILES['file']['error']) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE =>
                    'File terlalu besar. Batas server: upload_max_filesize=' . ini_get('upload_max_filesize'),
                UPLOAD_ERR_PARTIAL => 'Upload tidak lengkap, coba lagi.',
                UPLOAD_ERR_CANT_WRITE => 'Gagal menyimpan ke server. Periksa permission folder storage.',
                default => 'Gagal upload file (PHP error ' . $_FILES['file']['error'] . ').',
            };
            return response()->json(['error' => $msg], 422);
        }

        $isVideo = str_ends_with($key, '_video');

        $rules = $isVideo
            ? ['file' => ['required', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:153600']]
            : ['file' => ['required', 'image', 'max:8192']];

        $messages = [
            'file.required'  => 'Tidak ada file yang dipilih.',
            'file.mimetypes' => 'Format harus MP4, WebM, atau OGG.',
            'file.image'     => 'File harus berupa gambar.',
            'file.max'       => $isVideo ? 'Ukuran video maksimal 150 MB. Kompres video Anda agar website tetap cepat.' : 'Ukuran gambar maksimal 8 MB.',
        ];

        $request->validate($rules, $messages);

        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return response()->json(['error' => 'File tidak valid atau gagal diupload.'], 422);
        }

        $old = CompanySetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }

        $path = $request->file('file')->store('settings', 'public');
        CompanySetting::set($key, $path, 'image');

        return response()->json([
            'success' => true,
            'url'     => Storage::url($path),
            'name'    => basename($path),
        ]);
    }

    // AJAX endpoint — deletes a single media file
    public function deleteMedia(Request $request)
    {
        $key = $request->input('key');
        $allowed = $this->fileKeys;

        if (!in_array($key, $allowed)) {
            return response()->json(['error' => 'Key tidak valid.'], 422);
        }

        $old = CompanySetting::get($key);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        CompanySetting::set($key, null, 'image');

        return response()->json(['success' => true]);
    }
}
