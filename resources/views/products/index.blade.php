<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Barang') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Daftar Barang</h3>
                    <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-semibold">
                        Tambah Barang
                    </a>
                </div>

                <div style="margin-bottom: 28px !important;">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="relative w-full flex items-center">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none" style="padding-left: 16px !important;">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="w-full pr-4 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                                   style="padding-left: 46px !important;"
                                   placeholder="Cari kode atau nama barang...">
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                    <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">No</th>
                    <th class="border px-4 py-2 text-left">Kode</th>
                    <th class="border px-4 py-2 text-left">Nama Barang</th>
                    <th class="border px-4 py-2 text-left">Satuan</th>
                    <th class="border px-4 py-2 text-left">Harga</th>
                    <th class="border px-4 py-2 text-left">Dibuat Oleh</th>
                    <th class="border px-4 py-2 text-left">Terakhir Diubah</th>
                    <th class="border px-4 py-2 text-center">Aksi</th>
                </tr>
        </thead>
        <tbody>
            @forelse($products as $key => $product)
                <tr>
                    <td class="border px-4 py-2">{{ $key + 1 }}</td>
                    <td class="border px-4 py-2 font-mono font-bold text-gray-600">{{ $product->kode_barang }}</td>
                    <td class="border px-4 py-2 font-medium">{{ $product->nama_barang }}</td>
                    <td class="border px-4 py-2">
                        @php $satuan = strtolower($product->satuan ?? 'pcs'); @endphp
                        <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                            {{ $satuan }}
                        </div>
                    </td>
            <td class="border px-4 py-2 font-bold">Rp {{ number_format($product->harga ?? 0, 0, ',', '.') }}</td>
            
            <td class="border px-4 py-2 text-xs text-gray-600">{{ $product->pembuat->name ?? 'Admin' }}</td>
            <td class="border px-4 py-2 text-xs text-gray-600">{{ $product->pengubah->name ?? '-' }}</td>
            
            <td class="border px-4 py-2 flex justify-center gap-2">
                <a href="{{ route('products.edit', $product->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-xs font-bold">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-bold">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="border px-4 py-2 text-center text-gray-500 italic">Data barang tidak ditemukan.</td>
        </tr>
    @endforelse
</tbody>
                    </table>
                </div>

                </div>
        </div>
    </div>
</x-app-layout>