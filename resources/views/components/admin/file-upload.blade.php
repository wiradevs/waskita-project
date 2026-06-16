@props(['name', 'label', 'accept' => '*', 'current' => null, 'type' => 'image'])

@php
    $isVideo = $type === 'video';
    $maxMb   = $isVideo ? 150 : 8;
    $hint    = $isVideo ? 'MP4 / WebM — maks 150 MB (kompres dulu agar website tetap ringan)' : 'JPG, PNG, WebP — maks ' . $maxMb . ' MB (otomatis dikompres)';
    $uploadUrl    = route('panel.settings.upload-media');
    $deleteUrl    = route('panel.settings.delete-media');
    $csrfToken    = csrf_token();
@endphp

<div class="media-upload-widget" data-key="{{ $name }}" data-type="{{ $type }}"
     data-upload-url="{{ $uploadUrl }}" data-delete-url="{{ $deleteUrl }}"
     data-csrf="{{ $csrfToken }}" data-max-mb="{{ $maxMb }}"
     style="display:flex;flex-direction:column;gap:8px">

    <label style="font-size:13px;font-weight:600;color:#475569">{{ $label }}</label>

    {{-- Current file preview --}}
    <div class="current-preview" style="{{ $current ? '' : 'display:none' }}">
        @if($isVideo)
            <video src="{{ $current ? Storage::url($current) : '' }}"
                   style="height:96px;width:160px;border-radius:10px;border:1px solid #e2e8f0;background:#f8fafc;object-fit:cover"
                   controls muted></video>
        @else
            <img src="{{ $current ? Storage::url($current) : '' }}" alt=""
                 style="height:96px;width:160px;border-radius:10px;border:1px solid #e2e8f0;object-fit:cover">
        @endif
        <div style="margin-top:6px;display:flex;align-items:center;gap:6px">
            <button type="button" class="btn-delete-media"
                    style="font-size:12px;color:#ef4444;background:none;border:none;cursor:pointer;padding:0;display:flex;align-items:center;gap:4px">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus file
            </button>
        </div>
    </div>

    {{-- Upload zone --}}
    <div class="upload-zone"
         style="display:inline-flex;align-items:center;gap:10px;cursor:pointer;width:fit-content">
        <label style="display:inline-flex;align-items:center;gap:8px;padding:9px 16px;border-radius:10px;
                      border:2px dashed #cbd5e1;background:#f8fafc;cursor:pointer;transition:all .15s;user-select:none"
               onmouseover="this.style.borderColor='#f59e0b';this.style.background='#fffbeb'"
               onmouseout="this.style.borderColor='#cbd5e1';this.style.background='#f8fafc'">
            <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            <span style="font-size:13px;color:#64748b;font-weight:500">
                {{ $current ? 'Ganti file' : 'Pilih file' }}
            </span>
            <input type="file" accept="{{ $accept }}" style="display:none" class="file-input">
        </label>
        <span class="file-hint" style="font-size:11px;color:#94a3b8">{{ $hint }}</span>
    </div>

    {{-- Progress bar (hidden by default) --}}
    <div class="upload-progress" style="display:none;flex-direction:column;gap:4px">
        <div style="display:flex;justify-content:space-between;align-items:center">
            <span class="progress-filename" style="font-size:12px;color:#475569;font-weight:500"></span>
            <span class="progress-pct" style="font-size:12px;color:#f59e0b;font-weight:700">0%</span>
        </div>
        <div style="height:6px;background:#e2e8f0;border-radius:99px;overflow:hidden">
            <div class="progress-bar"
                 style="height:100%;background:linear-gradient(90deg,#f59e0b,#d97706);border-radius:99px;width:0%;transition:width .2s"></div>
        </div>
        <span class="progress-status" style="font-size:11px;color:#64748b">Mengupload...</span>
    </div>

    {{-- Inline notification --}}
    <div class="upload-notif" style="display:none;font-size:12px;border-radius:8px;padding:8px 12px"></div>

    @error($name)
        <p style="font-size:12px;color:#ef4444">{{ $message }}</p>
    @enderror
</div>

<script>
(function() {
    // Wait for DOM ready, then init all widgets on page
    function initWidget(widget) {
        if (widget._initialized) return;
        widget._initialized = true;

        const key        = widget.dataset.key;
        const uploadUrl  = widget.dataset.uploadUrl;
        const deleteUrl  = widget.dataset.deleteUrl;
        const csrf       = widget.dataset.csrf;
        const maxMb      = parseFloat(widget.dataset.maxMb);
        const fileInput  = widget.querySelector('.file-input');
        const preview    = widget.querySelector('.current-preview');
        const progressEl = widget.querySelector('.upload-progress');
        const bar        = widget.querySelector('.progress-bar');
        const pct        = widget.querySelector('.progress-pct');
        const fname      = widget.querySelector('.progress-filename');
        const status     = widget.querySelector('.progress-status');
        const notif      = widget.querySelector('.upload-notif');
        const delBtn     = widget.querySelector('.btn-delete-media');

        function showNotif(msg, ok) {
            notif.textContent = msg;
            notif.style.display = 'block';
            notif.style.background = ok ? '#f0fdf4' : '#fef2f2';
            notif.style.border     = ok ? '1px solid #bbf7d0' : '1px solid #fecaca';
            notif.style.color      = ok ? '#15803d' : '#dc2626';
            clearTimeout(notif._timer);
            notif._timer = setTimeout(() => { notif.style.display = 'none'; }, 5000);
        }

        function resetProgress() {
            progressEl.style.display = 'none';
            bar.style.width = '0%';
            pct.textContent = '0%';
        }

        // Downscale + re-encode large images client-side (no server GD/Imagick available).
        // Skips animated GIFs (canvas would flatten them) and files already small enough.
        function compressImage(file) {
            const MAX_DIM = 1920, QUALITY = 0.82;
            if (file.type === 'image/gif' || file.size < 400 * 1024) {
                return Promise.resolve(file);
            }
            return new Promise((resolve) => {
                const img = new Image();
                const objectUrl = URL.createObjectURL(file);
                img.onload = () => {
                    URL.revokeObjectURL(objectUrl);
                    let { width, height } = img;
                    if (width <= MAX_DIM && height <= MAX_DIM) {
                        resolve(file);
                        return;
                    }
                    const scale = MAX_DIM / Math.max(width, height);
                    width = Math.round(width * scale);
                    height = Math.round(height * scale);
                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    canvas.getContext('2d').drawImage(img, 0, 0, width, height);
                    canvas.toBlob((blob) => {
                        if (!blob || blob.size >= file.size) { resolve(file); return; }
                        resolve(new File([blob], file.name, { type: 'image/jpeg' }));
                    }, 'image/jpeg', QUALITY);
                };
                img.onerror = () => { URL.revokeObjectURL(objectUrl); resolve(file); };
                img.src = objectUrl;
            });
        }

        fileInput.addEventListener('change', function() {
            const rawFile = this.files[0];
            if (!rawFile) return;

            const isImage = widget.dataset.type === 'image';
            const prep = isImage ? compressImage(rawFile) : Promise.resolve(rawFile);

            prep.then((file) => {

            // Client-side size check
            if (file.size > maxMb * 1024 * 1024) {
                showNotif('File terlalu besar! Maksimal ' + maxMb + ' MB.', false);
                fileInput.value = '';
                return;
            }

            // Show progress
            notif.style.display = 'none';
            progressEl.style.display = 'flex';
            fname.textContent = file.name;
            bar.style.width = '0%';
            pct.textContent = '0%';
            status.textContent = 'Mengupload...';

            const fd = new FormData();
            fd.append('_token', csrf);
            fd.append('key', key);
            fd.append('file', file);

            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const p = Math.round(e.loaded / e.total * 100);
                    bar.style.width = p + '%';
                    pct.textContent = p + '%';
                }
            });

            xhr.addEventListener('load', function() {
                resetProgress();
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    showNotif('✓ ' + (data.name || file.name) + ' berhasil diupload!', true);
                    // Update preview
                    const type = widget.dataset.type;
                    if (type === 'video') {
                        const vid = preview.querySelector('video');
                        if (vid) { vid.src = data.url; vid.load(); }
                    } else {
                        const img = preview.querySelector('img');
                        if (img) img.src = data.url;
                    }
                    preview.style.display = '';
                } else {
                    let msg = 'Gagal mengupload file.';
                    try { msg = JSON.parse(xhr.responseText).error || msg; } catch(e) {}
                    showNotif('✗ ' + msg, false);
                }
                fileInput.value = '';
            });

            xhr.addEventListener('error', function() {
                resetProgress();
                showNotif('✗ Koneksi terputus saat upload. Coba lagi.', false);
                fileInput.value = '';
            });

            xhr.addEventListener('abort', function() {
                resetProgress();
                showNotif('Upload dibatalkan.', false);
                fileInput.value = '';
            });

            xhr.open('POST', uploadUrl);
            xhr.send(fd);

            status.textContent = 'Mengupload ' + file.name + '...';
            });
        });

        if (delBtn) {
            delBtn.addEventListener('click', function() {
                if (!confirm('Hapus file ini?')) return;
                notif.style.display = 'none';

                const fd = new FormData();
                fd.append('_token', csrf);
                fd.append('key', key);

                fetch(deleteUrl, { method: 'POST', body: fd })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            preview.style.display = 'none';
                            const vid = preview.querySelector('video');
                            const img = preview.querySelector('img');
                            if (vid) vid.src = '';
                            if (img) img.src = '';
                            showNotif('File berhasil dihapus.', true);
                        } else {
                            showNotif('Gagal menghapus file.', false);
                        }
                    })
                    .catch(() => showNotif('Koneksi error saat menghapus.', false));
            });
        }
    }

    function initAll() {
        document.querySelectorAll('.media-upload-widget').forEach(initWidget);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
})();
</script>
