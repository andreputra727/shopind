@extends('layouts.app')

@section('content')
<style>
    .admin-container { display:flex; gap:32px; max-width:1100px; margin:0 auto; }
    .admin-sidebar { width:180px; padding-top:10px; }
    .admin-sidebar-nav { background:#EBEAED; border-radius:16px; padding:16px; }
    .admin-sidebar-nav a { display:block; font-weight:800; font-size:1.05rem; margin-bottom:8px; text-decoration:none; }
    .nav-tambah { color:#02066F; }
    .nav-hapus  { color:#2000B1; }
    .admin-content { flex:1; }
    .header-title { text-align:center; margin-bottom:24px; margin-top:-10px; }
    .header-title h1 { font-size:1.7rem; font-weight:800; color:#020035; }
    .header-title p { font-size:0.85rem; color:#2000B1; }
    .form-wrapper { background:#EBEAED; border-radius:20px; padding:32px; position:relative; }
    .form-title-badge {
        background:white; color:#02066F; font-size:1.25rem; font-weight:800;
        padding:12px 36px; border-radius:26px 26px 0 0;
        display:inline-block; position:absolute; top:-46px; left:50%; transform:translateX(-50%);
    }
    .form-inner-grid { display:flex; background:white; border-radius:20px; overflow:hidden; margin-top:16px; }
    .form-left { width:35%; padding:32px; display:flex; flex-direction:column; align-items:center; justify-content:center; }
    .image-preview-box {
        width:100%; aspect-ratio:4/3; background:#F2F3F4;
        border-radius:12px; object-fit:cover; margin-bottom:16px; cursor:pointer;
    }
    .btn-tambah-gambar { color:#02066F; font-weight:700; font-size:1.1rem; background:none; border:none; cursor:pointer; }
    .form-right { width:65%; background:#020035; padding:32px; color:white; }
    .form-row { display:flex; align-items:flex-start; margin-bottom:24px; }
    .form-label { width:130px; font-weight:700; font-size:0.95rem; margin-top:8px; flex-shrink:0; }
    .form-input-wrapper { flex:1; }
    .form-input {
        width:100%; background:transparent; border:none;
        border-bottom:1.5px solid #2000B1; color:white;
        padding:8px 0; font-size:0.95rem; outline:none; font-family:inherit;
    }
    .form-input::placeholder { color:#EBEAED; }
    .form-textarea { resize:none; height:60px; }

    /* TAG KATEGORI */
    .tag-section { margin-top:8px; }
    .tag-label-title { font-size:0.85rem; color:#EBEAED; margin-bottom:12px; font-weight:500; }
    .tag-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .tag-option { display:none; }
    .tag-option + label {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1.5px solid #2000B1;
        color: #EBEAED;
        cursor: pointer;
        transition: all .15s;
        user-select: none;
    }
    .tag-option + label:hover {
        border-color: #EBEAED;
        color: white;
    }
    .tag-option:checked + label {
        background: #02066F;
        border-color: #02066F;
        color: white;
    }

    .form-actions { display:flex; justify-content:flex-end; margin-top:24px; gap:12px; }
    .btn-simpan {
        background:#02066F; color:white; font-weight:700; font-size:1rem;
        padding:12px 64px; border-radius:999px; border:none; cursor:pointer; transition:background .2s;
    }
    .btn-simpan:hover { background:#ED4B00; }
    .btn-batal {
        background:#EBEAED; color:#020035; font-weight:700; font-size:1rem;
        padding:12px 32px; border-radius:999px; border:none; cursor:pointer;
        text-decoration:none; display:inline-block; line-height:normal; transition:background .2s;
    }
    .btn-batal:hover { background:#d4d3d6; }
</style>

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="admin-sidebar-nav">
            <a href="{{ route('admin.create') }}" class="nav-tambah">Tambah Produk</a>
            <a href="{{ route('admin.index') }}" class="nav-hapus">Hapus Produk</a>
        </div>
    </div>

    <div class="admin-content">
        <div class="header-title">
            <h1>Edit Produk</h1>
            <p>Ubah data atau foto produk</p>
        </div>

        <form action="{{ route('admin.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-top:60px;">
                <div class="form-wrapper">
                    <div class="form-title-badge">Edit Data Produk</div>

                    <div class="form-inner-grid">
                        <div class="form-left">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" id="preview" class="image-preview-box" alt="Foto Produk">
                            @else
                                <img src="" id="preview" class="image-preview-box" alt="Preview" style="display:none;">
                            @endif

                            <div id="placeholder-box" class="image-preview-box" style="{{ $product->image ? 'display:none;' : 'display:flex;' }} align-items:center; justify-content:center; color:#2000B1; font-weight:600;">
                                Pilih Gambar
                            </div>

                            <input type="file" name="image" id="imageInput" style="display:none;" accept="image/*" onchange="previewImage(event)">
                            <button type="button" class="btn-tambah-gambar" onclick="document.getElementById('imageInput').click()">
                                {{ $product->image ? 'Ganti Gambar' : 'Tambah Gambar' }}
                            </button>
                            @error('image') <p style="color:#ED4B00; font-size:0.8rem; margin-top:8px;">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-right">
                            <div class="form-row">
                                <label class="form-label">Nama Produk :</label>
                                <div class="form-input-wrapper">
                                    <input type="text" name="name" class="form-input" value="{{ old('name', $product->name) }}" required>
                                    @error('name') <p style="color:#ED4B00; font-size:0.8rem; margin-top:4px;">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="form-label">Stok Produk :</label>
                                <div class="form-input-wrapper">
                                    <input type="number" name="stock" class="form-input" value="{{ old('stock', $product->stock) }}" required>
                                    @error('stock') <p style="color:#ED4B00; font-size:0.8rem; margin-top:4px;">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="form-label">Harga Produk :</label>
                                <div class="form-input-wrapper">
                                    <input type="number" name="price" class="form-input" value="{{ old('price', $product->price) }}" required>
                                    @error('price') <p style="color:#ED4B00; font-size:0.8rem; margin-top:4px;">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="form-label">Deskripsi :</label>
                                <div class="form-input-wrapper">
                                    <textarea name="description" class="form-input form-textarea">{{ old('description', $product->description) }}</textarea>
                                    @error('description') <p style="color:#ED4B00; font-size:0.8rem; margin-top:4px;">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- KATEGORI TAG --}}
                            <div class="form-row">
                                <label class="form-label">Kategori :</label>
                                <div class="form-input-wrapper">
                                    <div class="tag-section">
                                        <div class="tag-grid">
                                            @php
                                                $kategoriList = ['Laptop', 'Audio', 'Smartphone', 'Wearable', 'Kamera', 'Aksesoris'];
                                                $aktif = old('kategori', $product->kategori);
                                            @endphp
                                            @foreach($kategoriList as $kat)
                                                <input type="radio" name="kategori" id="tag_{{ $kat }}" value="{{ $kat }}" class="tag-option"
                                                    {{ $aktif === $kat ? 'checked' : '' }}>
                                                <label for="tag_{{ $kat }}">{{ $kat }}</label>
                                            @endforeach
                                        </div>
                                        <p style="font-size:0.75rem; color:#EBEAED; margin-top:8px; opacity:0.7;">Pilih satu kategori untuk produk ini</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.index') }}" class="btn-batal">Batal</a>
                        <button type="submit" class="btn-simpan">Simpan</button>
                    </div>
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