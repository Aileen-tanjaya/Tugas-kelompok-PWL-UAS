<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200">
                
                {{-- Action mengarah ke products.store untuk menyimpan --}}
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    
                    {{-- 1. KODE BARANG --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500 @error('kode_barang') border-red-500 @enderror" placeholder="Contoh: BRG001" required>
                        @error('kode_barang')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 2. NAMA BARANG --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500 @error('nama_barang') border-red-500 @enderror" placeholder="Masukkan nama barang" required>
                        @error('nama_barang')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 3. SATUAN --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Satuan</label>
                        <select name="satuan" class="w-full border rounded px-3 py-2 @error('satuan') border-red-500 @enderror" required>
                            <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>pcs</option>
                            <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>liter</option>
                            <option value="bungkus" {{ old('satuan') == 'bungkus' ? 'selected' : '' }}>bungkus</option>
                            {{-- PERBAIKAN: Menambahkan pilihan satuan sisir agar muncul di form --}}
                            <option value="sisir" {{ old('satuan') == 'sisir' ? 'selected' : '' }}>sisir</option>
                        </select>
                        @error('satuan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 4. HARGA --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-bold">Harga</label>
                        <input type="number" name="harga" value="{{ old('harga') }}" class="w-full border rounded px-3 py-2 focus:ring-blue-500 @error('harga') border-red-500 @enderror" placeholder="Contoh: 15000" required>
                        @error('harga')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex justify-end gap-2 mt-6">
                        <a href="{{ route('products.index') }}" style="background: #6b7280 !important; color: white !important; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px;">
                            Batal
                        </a>
                        <button type="submit" style="background: #2563eb !important; color: white !important; padding: 10px 20px; border-radius: 6px; font-weight: bold; border: none; cursor: pointer; font-size: 14px;">
                            Simpan Barang
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>