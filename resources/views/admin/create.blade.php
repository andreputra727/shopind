@extends('layouts.app')

@section('content')
<style>
    .admin-container { display:flex; gap:32px; max-width:1100px; margin:0 auto; }
    .admin-sidebar { width:200px; padding-top:10px; }
    .admin-sidebar-nav {
        background: linear-gradient(135deg, #020035 0%, #02066F 100%);
        border-radius:16px; padding:20px;
        box-shadow: 0 4px 16px rgba(2,0,53,0.15);
    }
    .admin-sidebar-nav a {
        display:block; font-weight:700; font-size:0.95rem;
        margin-bottom:10px; text-decoration:none; padding:10px 14px;
        border-radius:10px; transition:all .15s;
    }
    .admin-sidebar-nav a:last-child { margin-bottom:0; }
    .nav-tambah { color:#ffffff; background:rgba(255,255,255,0.15); }
    .nav-tambah:hover { background:rgba(255,255,255,0.25); }
    .nav-hapus { color:#ED4B00; background:rgba(237,75,0,0.15); }
    .nav-hapus:hover { background:rgba(237,75,0,0.25); }

    .admin-content { flex:1; }

    .form-wrapper {
        background: #EBEAED;
        border-radius:20px; padding:32px; position:relative;
        border:1.5px solid #d0cfd4;
        box-shadow: 0 8px 32px rgba(2,0,53,0.10);
        margin-top:60px;
    }
    .form-title-badge {
        background: linear-gradient(135deg, #020035 0%, #02066F 100%);
        color:white; font-size:1.1rem; font-weight:800;
        padding:14px 40px; border-radius:14px 14px 0 0;
        display:inline-block; position:absolute; top:-52px; left:50%; transform:translateX(-50%);
        box-shadow: 0 4px 20px rgba(2,0,53,0.25);
        white-space: nowrap; letter-spacing:.01em;
        border:2px solid #02066F;
    }
    .form-inner-grid {
        display:flex; border-radius:16px; overflow:hidden;
        box-shadow: 0 4px 20px rgba(2,0,53,0.15);
        margin-top:16px;
        border: 2px solid #02066F;
    }
    .form-left {
        width:35%; padding:32px; display:flex; flex-direction:column;
        align-items:center; justify-content:center; background:white;
    }
    .image-preview-box {
        width:100%; aspect-ratio:4/3; background:#F2F3F4;
        border-radius:12px; object-fit:cover; margin-bottom:16px; cursor:pointer;
        border:2px dashed #EBEAED;
    }
    .btn-tambah-gambar {
        color:#02066F; font-weight:700; font-size:1rem;
        background:#EEF2FF; border:1.5px solid #C7D2FE;
        border-radius:8px; cursor:pointer; padding:8px 20px;
        transition:all .15s;
    }
    .btn-tambah-gambar:hover { background:#02066F; color:white; border-color:#02066F; }

    .form-right {
        width:65%;
        background: linear-gradient(135deg, #020035 0%, #02066F 100%);
        padding:32px; color:white;
    }
    .form-row { display:flex; align-items:flex-start; margin-bottom:24px; }
    .form-label { width:140px; font-weight:700; font-size:0.9rem; margin-top:8px; color:rgba(255,255,255,0.75); }
    .form-input-wrapper { flex:1; }
    .form-input {
        width:100%; background:rgba(255,255,255,0.08); border:none;
        border-bottom:1.5px solid rgba(255,255,255,0.25); color:white;
        padding:10px 0; font-size:0.95rem; outline:none; font-family:inherit;
        transition:border-color .15s;
    }
    .form-input:focus { border-bottom-color:rgba(255,255,255,0.8); }
    .form-input::placeholder { color:rgba(255,255,255,0.35); }
    .form-textarea { resize:none; height:60px; }
    .textarea-lines { border-bottom:1.5px solid rgba(255,255,255,0.1); margin-top:12px; }

    .form-actions { display:flex; justify-content:flex-end; margin-top:24px; gap:12px; }
    .btn-batal {
        background:transparent; color:#020035; font-weight:700; font-size:0.95rem;
        padding:12px 32px; border-radius:999px; border:1.5px solid #EBEAED;
        cursor:pointer; transition:all .2s; text-decoration:none; display:inline-flex; align-items:center;
    }
    .btn-batal:hover { background:#EBEAED; }
    .btn-simpan {
        background:#ED4B00; color:white; font-weight:700; font-size:0.95rem;
        padding:12px 64px; border-radius:999px; border:none; cursor:pointer;
        transition:all .2s; box-shadow: 0 4px 12px rgba(237,75,0,0.3);
    }
    .btn-simpan:hover { background:#c43d00; transform:translateY(-1px); }
</style>

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="admin-sidebar-nav">
            <a href="{{ route('admin.index') }}" class="nav-hapus">← Daftar Produk</a>
        </div>
    </div>
    <div class="admin-content">
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-wrapper">
                <div class="form-title-badge">Silahkan Isi Form Produk</div>
                <div class="form-inner-grid">
                    <div class="form-left">
                        <img src="" id="preview" class="image-preview-box" alt="Preview" style="display:none;">
                        <div id="placeholder-box" class="image-preview-box" style="display:flex; align-items:center; justify-content:center; color:#2000B1; font-weight:600; font-size:0.9rem;">
                            <div style="text-align:center;">
                                <svg width="32" height="32" fill="none" stroke="#EBEAED" stroke-width="1.5" viewBox="0 0 24 24" style="display:block; margin:0 auto 8px;">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                                </svg>
                                Pilih Gambar
                            </div>
                        </div>
                        <input type="file" name="image" id="imageInput" style="display:none;" accept="image/*" onchange="previewImage(event)">
                        <button type="button" class="btn-tambah-gambar" onclick="document.getElementById('imageInput').click()">+ Tambah Gambar</button>
                        @error('image') <p style="color:#ED4B00; font-size:0.8rem; margin-top:8px;">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-right">
                        <div class="form-row">
                            <label class="form-label">Nama Produk :</label>
                            <div class="form-input-wrapper">
                                <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Kamera Sony" required>
                                @error('name') <p style="color:#ED4B00; font-size:0.8rem; margin-top:4px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="form-label">Stok Produk :</label>
                            <div class="form-input-wrapper">
                                <input type="number" name="stock" class="form-input" value="{{ old('stock') }}" placeholder="5" required>
                                @error('stock') <p style="color:#ED4B00; font-size:0.8rem; margin-top:4px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="form-label">Harga Produk :</label>
                            <div class="form-input-wrapper">
                                <input type="number" name="price" class="form-input" value="{{ old('price') }}" placeholder="8000000" required>
                                @error('price') <p style="color:#ED4B00; font-size:0.8rem; margin-top:4px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="form-label">Deskripsi :</label>
                            <div class="form-input-wrapper">
                                <textarea name="description" class="form-input form-textarea" placeholder="Kamera sony a6v7 yang..." required>{{ old('description') }}</textarea>
                                <div class="textarea-lines"></div>
                                <div class="textarea-lines"></div>
                                @error('description') <p style="color:#ED4B00; font-size:0.8rem; margin-top:4px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="form-label">Kategori :</label>
                            <div class="form-input-wrapper">
                                <select name="kategori" class="form-input" style="cursor:pointer;" required>
                                    <option value="" disabled selected style="background:#020035;">Pilih kategori</option>
                                    @foreach(['Laptop','Audio','Smartphone','Wearable','Kamera','Aksesoris'] as $kat)
                                        <option value="{{ $kat }}" style="background:#020035;" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                    @endforeach
                                </select>
                                @error('kategori') <p style="color:#ED4B00; font-size:0.8rem; margin-top:4px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.index') }}" class="btn-batal">Batal</a>
                    <button type="submit" class="btn-simpan">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder-box');
            preview.src = reader.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection