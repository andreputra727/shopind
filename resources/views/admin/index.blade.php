@extends('layouts.app')

@section('content')
<style>
    .admin-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
    .admin-top h1 { font-size:1.25rem; font-weight:700; color:#020035; }
    .btn-tambah {
        background:#ED4B00; color:white; padding:10px 22px;
        border-radius:10px; font-size:.875rem; font-weight:700;
        text-decoration:none; transition:all .15s;
        box-shadow: 0 4px 12px rgba(237,75,0,0.3);
    }
    .btn-tambah:hover { background:#c43d00; transform:translateY(-1px); }

    .search-input {
        width:100%; border:1.5px solid #EBEAED; border-radius:10px;
        padding:10px 12px 10px 38px; font-size:.875rem; color:#020035;
        background:#fff; outline:none; transition:border-color .15s;
        font-family:inherit;
    }
    .search-input:focus { border-color:#02066F; box-shadow: 0 0 0 3px rgba(2,6,111,0.08); }
    .search-input::placeholder { color:#aaa; }

    .btn-cari {
        background:#02066F; color:white; padding:10px 22px;
        border-radius:10px; font-size:.875rem; font-weight:700;
        border:none; cursor:pointer; transition:all .15s; font-family:inherit;
    }
    .btn-cari:hover { background:#020035; }
    .btn-reset {
        background:#fff0eb; color:#ED4B00; padding:10px 18px;
        border-radius:10px; font-size:.875rem; font-weight:600;
        text-decoration:none; transition:background .15s;
    }
    .btn-reset:hover { background:#ffd9c9; }

    .table-wrap {
        background:white; border-radius:16px;
        border:1.5px solid #EBEAED; overflow:hidden;
        box-shadow: 0 2px 12px rgba(2,0,53,0.06);
    }
    .table-wrap table { width:100%; font-size:.875rem; border-collapse:collapse; }
    .table-wrap thead { background: linear-gradient(135deg, #020035 0%, #02066F 100%); }
    .table-wrap th { text-align:left; padding:14px 20px; color:rgba(255,255,255,0.85); font-weight:600; font-size:.8rem; letter-spacing:.04em; text-transform:uppercase; }
    .table-wrap td { padding:14px 20px; border-bottom:1px solid #F2F3F4; color:#020035; vertical-align:middle; }
    .table-wrap tr:last-child td { border-bottom:none; }
    .table-wrap tbody tr { transition:background .15s; }
    .table-wrap tbody tr:hover td { background:#F8F8FA; }

    .stok-badge {
        display:inline-flex; align-items:center; justify-content:center;
        min-width:36px; padding:4px 12px; border-radius:999px;
        font-size:.78rem; font-weight:700;
    }
    .stok-ok  { background:#e0f2fe; color:#02066F; }
    .stok-low { background:#fef3c7; color:#92400e; }
    .stok-empty { background:#fee2e2; color:#991b1b; }

    .product-name { font-weight:600; color:#020035; }
    .product-price { font-weight:700; color:#02066F; }

    .btn-edit {
        background:#EEF2FF; color:#02066F; padding:6px 14px;
        border-radius:8px; font-size:.78rem; font-weight:700;
        text-decoration:none; transition:all .15s; border:1.5px solid #C7D2FE;
    }
    .btn-edit:hover { background:#02066F; color:white; border-color:#02066F; }
    .btn-hapus {
        background:#FFF0EB; color:#ED4B00; padding:6px 14px;
        border-radius:8px; font-size:.78rem; font-weight:700;
        border:1.5px solid #FECDB8; cursor:pointer; font-family:inherit; transition:all .15s;
    }
    .btn-hapus:hover { background:#ED4B00; color:white; border-color:#ED4B00; }
</style>

<div class="admin-top">
    <h1>Daftar Produk</h1>
    <a href="{{ route('admin.create') }}" class="btn-tambah">+ Tambah Produk</a>
</div>

<form action="{{ route('admin.index') }}" method="GET" style="margin-bottom:20px; display:flex; gap:8px;">
    <div style="position:relative; width:100%; max-width:360px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="search-input">
        <svg style="position:absolute; left:11px; top:11px; color:#aaa;" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
        </svg>
    </div>
    <button type="submit" class="btn-cari">Cari</button>
    @if(request('search'))
        <a href="{{ route('admin.index') }}" class="btn-reset">Reset</a>
    @endif
</form>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td><span class="product-name">{{ $product->name }}</span></td>
                <td><span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span></td>
                <td>
                    <span class="stok-badge {{ $product->stock == 0 ? 'stok-empty' : ($product->stock > 5 ? 'stok-ok' : 'stok-low') }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <a href="{{ route('admin.edit', $product->id) }}" class="btn-edit">Edit</a>
                        <form id="delete-form-{{ $product->id }}" action="{{ route('admin.destroy', $product->id) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="openDeleteModal('delete-form-{{ $product->id }}', '{{ addslashes($product->name) }}')" class="btn-hapus">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(2,0,53,0.4); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(3px);">
    <div style="background:white; border-radius:20px; padding:40px; text-align:center; max-width:420px; border:1.5px solid #EBEAED; box-shadow:0 20px 60px rgba(2,0,53,0.2);">
        <div style="width:56px; height:56px; background:#FFF0EB; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
            <svg width="28" height="28" fill="none" stroke="#ED4B00" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
        </div>
        <h2 id="deleteModalText" style="font-size:1.1rem; font-weight:800; color:#020035; margin-bottom:28px; line-height:1.4;">Hapus produk ...?</h2>
        <div style="display:flex; justify-content:center; gap:12px;">
            <button onclick="closeDeleteModal()" style="background:#F2F3F4; color:#020035; font-weight:700; font-size:.9rem; padding:11px 32px; border-radius:10px; border:1.5px solid #EBEAED; cursor:pointer;">Batal</button>
            <button onclick="submitDelete()" style="background:#ED4B00; color:white; font-weight:700; font-size:.9rem; padding:11px 32px; border-radius:10px; border:none; cursor:pointer;">Hapus</button>
        </div>
    </div>
</div>

@if(session('success') && str_contains(session('success'), 'permanen'))
<style> .alert-success { display: none !important; } </style>
<div id="successPopup" style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#020035; color:white; padding:16px 40px; border-radius:20px; font-weight:800; font-size:1.1rem; z-index:9999; box-shadow:0 8px 32px rgba(2,0,53,0.3);">
    ✓ Produk berhasil dihapus
</div>
<script>setTimeout(() => { document.getElementById('successPopup').style.display='none'; }, 2500);</script>
@endif

<script>
    let formToSubmit = null;
    function openDeleteModal(formId, productName) {
        document.getElementById('deleteModalText').innerText = 'Hapus produk "' + productName + '"?';
        document.getElementById('deleteModal').style.display = 'flex';
        formToSubmit = document.getElementById(formId);
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        formToSubmit = null;
    }
    function submitDelete() {
        if(formToSubmit) formToSubmit.submit();
    }
</script>
@endsection