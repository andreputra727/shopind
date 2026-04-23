@extends('layouts.app')

@section('content')
<style>
    .admin-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
    .admin-top h1 { font-size:1.25rem; font-weight:700; color:#020035; }
    .btn-tambah {
        background:#02066F; color:white; padding:8px 18px;
        border-radius:8px; font-size:.875rem; font-weight:600;
        text-decoration:none; transition:background .15s;
    }
    .btn-tambah:hover { background:#020035; }

    .search-input {
        width:100%; border:1.5px solid #EBEAED; border-radius:8px;
        padding:8px 12px 8px 36px; font-size:.875rem; color:#020035;
        background:#F2F3F4; outline:none; transition:border-color .15s;
        font-family:inherit;
    }
    .search-input:focus { border-color:#02066F; background:white; }
    .search-input::placeholder { color:#2000B1; }

    .btn-cari {
        background:#020035; color:white; padding:8px 18px;
        border-radius:8px; font-size:.875rem; font-weight:600;
        border:none; cursor:pointer; transition:background .15s; font-family:inherit;
    }
    .btn-cari:hover { background:#02066F; }
    .btn-reset {
        background:#fff0eb; color:#ED4B00; padding:8px 18px;
        border-radius:8px; font-size:.875rem; font-weight:600;
        text-decoration:none; transition:background .15s;
    }
    .btn-reset:hover { background:#ffd9c9; }

    .table-wrap {
        background:white; border-radius:12px;
        border:1.5px solid #EBEAED; overflow:hidden;
    }
    .table-wrap table { width:100%; font-size:.875rem; border-collapse:collapse; }
    .table-wrap thead { background:#F2F3F4; border-bottom:1.5px solid #EBEAED; }
    .table-wrap th { text-align:left; padding:12px 16px; color:#2000B1; font-weight:600; }
    .table-wrap td { padding:12px 16px; border-bottom:1px solid #EBEAED; color:#020035; }
    .table-wrap tr:last-child td { border-bottom:none; }
    .table-wrap tr:hover td { background:#F2F3F4; }

    .stok-badge {
        display:inline-block; padding:2px 10px; border-radius:999px;
        font-size:.75rem; font-weight:600;
    }
    .stok-ok  { background:#e0f2fe; color:#02066F; }
    .stok-low { background:#fef3c7; color:#92400e; }

    .btn-edit {
        background:#EBEAED; color:#02066F; padding:4px 12px;
        border-radius:6px; font-size:.75rem; font-weight:600;
        text-decoration:none; transition:background .15s;
    }
    .btn-edit:hover { background:#02066F; color:white; }
    .btn-hapus {
        background:#fff0eb; color:#ED4B00; padding:4px 12px;
        border-radius:6px; font-size:.75rem; font-weight:600;
        border:none; cursor:pointer; font-family:inherit; transition:background .15s;
    }
    .btn-hapus:hover { background:#ED4B00; color:white; }
</style>

<div class="admin-top">
    <h1>Daftar Produk</h1>
    <a href="{{ route('admin.create') }}" class="btn-tambah">+ Tambah Produk</a>
</div>

<form action="{{ route('admin.index') }}" method="GET" style="margin-bottom:20px; display:flex; gap:8px;">
    <div style="position:relative; width:100%; max-width:360px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="search-input">
        <svg style="position:absolute; left:10px; top:10px; color:#2000B1;" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
                <td>{{ $product->name }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    <span class="stok-badge {{ $product->stock > 5 ? 'stok-ok' : 'stok-low' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td style="display:flex; gap:8px; align-items:center;">
                    <a href="{{ route('admin.edit', $product->id) }}" class="btn-edit">Edit</a>
                    <form id="delete-form-{{ $product->id }}" action="{{ route('admin.destroy', $product->id) }}" method="POST" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="openDeleteModal('delete-form-{{ $product->id }}', '{{ addslashes($product->name) }}')" class="btn-hapus">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(2,0,53,0.4); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(3px);">
    <div style="background:white; border-radius:20px; padding:40px; text-align:center; max-width:420px; border:1.5px solid #EBEAED;">
        <h2 id="deleteModalText" style="font-size:1.3rem; font-weight:800; color:#020035; margin-bottom:32px; line-height:1.4;">Hapus produk ...?</h2>
        <div style="display:flex; justify-content:center; gap:16px;">
            <button onclick="closeDeleteModal()" style="background:#ED4B00; color:white; font-weight:700; font-size:1rem; padding:12px 36px; border-radius:12px; border:none; cursor:pointer;">TIDAK</button>
            <button onclick="submitDelete()" style="background:#02066F; color:white; font-weight:700; font-size:1rem; padding:12px 36px; border-radius:12px; border:none; cursor:pointer;">YA</button>
        </div>
    </div>
</div>

@if(session('success') && str_contains(session('success'), 'permanen'))
<style> .alert-success { display: none !important; } </style>
<div id="successPopup" style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#EBEAED; color:#020035; padding:16px 40px; border-radius:20px; font-weight:800; font-size:1.3rem; z-index:9999;">
    Produk Terhapus ✓
</div>
<script>setTimeout(() => { document.getElementById('successPopup').style.display='none'; }, 2500);</script>
@endif

<script>
    let formToSubmit = null;
    function openDeleteModal(formId, productName) {
        document.getElementById('deleteModalText').innerText = 'Hapus produk\n' + productName + '?';
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