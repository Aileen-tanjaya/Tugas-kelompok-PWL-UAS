<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Stok Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('stok.store') }}" method="POST">
                    @csrf
                    
                    {{-- Input Kode Barang --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Kode Barang</label>
                        <input type="text" name="kode_barang" class="w-full border rounded px-3 py-2" required placeholder="Contoh: BRG-001">
                    </div>

                    {{-- Input Nama Barang --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" class="w-full border rounded px-3 py-2" required placeholder="Contoh: Jaket Mercedes">
                    </div>

                    {{-- 1. INPUT BARU: Stok Masuk --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold text-blue-600">Stok Masuk</label>
                        <input type="number" name="stok_masuk" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" required value="0" min="0">
                    </div>

                    {{-- 2. INPUT BARU: Stok Keluar --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold text-red-600">Stok Keluar</label>
                        <input type="number" name="stok_keluar" class="w-full border rounded px-3 py-2 focus:ring focus:ring-red-200" required value="0" min="0">
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('stok.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded" style="text-decoration: none;">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-bold">
                            Simpan Stok
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>