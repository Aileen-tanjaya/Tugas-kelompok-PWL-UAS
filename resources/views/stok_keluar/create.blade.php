<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Stok Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg overflow-hidden p-6 border border-gray-100">
                
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-gray-800">
                        Form Pencatatan Barang Keluar
                    </h3>
                </div>

                @if ($errors->any())
                    <div class="mb-5 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                        <ul class="list-disc list-inside text-sm font-semibold">
                            @foreach ($errors->all() as $error)
                                <li> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('stok_keluar.store') }}" method="POST">
                    @csrf

                    <div class="space-y-5">
                        <div>
                            <label for="product_id" class="block text-gray-700 text-sm font-bold mb-1">Pilih Barang <span class="text-red-500">*</span></label>
                            <select name="product_id" id="product_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50" required>
                                <option value="">-- Silakan Pilih Barang --</option>
                                @if(isset($products) && count($products) > 0)
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            [{{ $product->kode_barang }}] - {{ $product->nama_barang }} (Sisa Stok: {{ $product->stok }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="jumlah" class="block text-gray-700 text-sm font-bold mb-1">Jumlah Keluar <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50" placeholder="Contoh: 10" required>
                            </div>

                            <div>
                                <label for="tanggal" class="block text-gray-700 text-sm font-bold mb-1">Tanggal <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50" required>
                            </div>
                        </div>

                        <div>
                            <label for="tujuan" class="block text-gray-700 text-sm font-bold mb-1">Tujuan / Alasan <span class="text-red-500">*</span></label>
                            <input type="text" name="tujuan" id="tujuan" value="{{ old('tujuan') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50" placeholder="Contoh: Terjual, Rusak, Dipakai Divisi A" required>
                        </div>

                        <div>
                            <label for="keterangan" class="block text-gray-700 text-sm font-bold mb-1">Keterangan (Opsional)</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50" placeholder="Tambahkan catatan jika perlu...">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-3 mt-6 pt-5 border-t border-gray-200">
                        <a href="{{ route('stok_keluar.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-2 rounded-lg text-sm transition shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg text-sm transition shadow-sm">
                            Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>