<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Stok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('stok.update', $stok->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Input Kode Barang --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ $stok->kode_barang }}" class="w-full border rounded px-3 py-2 bg-gray-50" required>
                    </div>

                    {{-- Input Nama Barang --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ $stok->nama_barang }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    {{-- 1. INPUT BARU: Stok Masuk --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold text-blue-600">Stok Masuk</label>
                        <input type="number" name="stok_masuk" value="{{ $stok->stok_masuk ?? 0 }}" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required min="0">
                    </div>

                    {{-- 2. INPUT BARU: Stok Keluar --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold text-red-600">Stok Keluar</label>
                        <input type="number" name="stok_keluar" value="{{ $stok->stok_keluar ?? 0 }}" class="w-full border rounded px-3 py-2 focus:ring focus:ring-red-200" required min="0">
                    </div>

                    <div class="flex justify-end gap-2">
                        {{-- Tombol Batal --}}
                        <a href="{{ route('stok.index') }}" style="background: gray !important; color: white !important; padding: 8px 15px; border-radius: 5px; text-decoration: none;">
                            Batal
                        </a>
                        {{-- Tombol Update --}}
                        <button type="submit" style="background: orange !important; color: white !important; padding: 8px 20px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer;">
                            Update Stok
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>