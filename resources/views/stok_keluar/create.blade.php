<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Stok Keluar</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen py-10 px-4">

    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden p-6">
        
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                Tambah Stok Keluar
            </h2>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('stok_keluar.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="product_id" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Pilih Barang Keluar *</label>
                <select name="product_id" id="product_id" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Pilih Barang --</option>
                    @if(isset($products) && count($products) > 0)
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                [{{ $product->kode_barang }}] - {{ $product->nama_barang }} (Stok: {{ $product->stok }})
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Jumlah Keluar *</label>
                <input type="number" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan jumlah barang" required>
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Tanggal Keluar *</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="tujuan" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Tujuan Keluar *</label>
                <input type="text" name="tujuan" id="tujuan" value="{{ old('tujuan') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Toko Cabang, Rusak, Kadaluarsa" required>
            </div>

            <div class="mb-6">
                <label for="keterangan" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Keterangan / Keperluan</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Catatan opsional">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded text-sm transition shadow">
                    Simpan Data
                </button>
                <a href="{{ route('stok_keluar.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded text-sm transition text-center shadow">
                    Kembali
                </a>
            </div>
        </form>

    </div>

</body>
</html>