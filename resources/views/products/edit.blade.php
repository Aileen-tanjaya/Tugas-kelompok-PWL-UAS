<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200">
                
                {{-- Pastikan action mengarah ke products.update --}}
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- 1. KODE BARANG --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ $product->kode_barang }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500" required>
                    </div>

                    {{-- 2. NAMA BARANG --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ $product->nama_barang }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500" required>
                    </div>

                    {{-- 3. SATUAN (SUDAH DIPERBAIKI MENGGUNAKAN VARIABLE $PRODUCT) --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Satuan</label>
                        <select name="satuan" class="w-full border rounded px-3 py-2 focus:ring-blue-500" required>
                            <option value="kg" {{ $product->satuan == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="pcs" {{ $product->satuan == 'pcs' ? 'selected' : '' }}>pcs</option>
                            <option value="liter" {{ $product->satuan == 'liter' ? 'selected' : '' }}>liter</option>
                            <option value="bungkus" {{ $product->satuan == 'bungkus' ? 'selected' : '' }}>bungkus</option>
                        </select>
                    </div>

                    {{-- 4. HARGA --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Harga</label>
                        <input type="number" name="harga" value="{{ $product->harga }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500" required>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('products.index') }}" style="background: #6b7280 !important; color: white !important; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px;">
                            Batal
                        </a>
                        <button type="submit" style="background: #f59e0b !important; color: white !important; padding: 10px 20px; border-radius: 6px; font-weight: bold; border: none; cursor: pointer; font-size: 14px;">
                            Update Barang
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>