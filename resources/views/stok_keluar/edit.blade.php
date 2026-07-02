<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Stok Keluar') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 dark:bg-red-900/30 dark:border-red-600 dark:text-red-400 text-red-700 rounded shadow-sm">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800/40 rounded-2xl p-6 text-gray-900 dark:text-gray-100 shadow-sm backdrop-blur-xs">

                <form action="{{ route('stok_keluar.update', $stokKeluar->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm mb-1.5 text-gray-600 dark:text-gray-400">
                            Barang
                        </label>
                        <select name="product_id"
                                class="w-full border-b border-gray-200 dark:border-gray-700 bg-transparent py-2.5 px-1 text-sm focus:outline-hidden focus:border-blue-500 text-gray-900 dark:text-gray-100 transition"
                                required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ $stokKeluar->product_id == $product->id ? 'selected' : '' }}
                                    class="text-gray-900 dark:text-gray-100 dark:bg-gray-900">
                                    {{ $product->kode_barang }} - {{ $product->nama_barang }} (Tersedia: {{ $product->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm mb-1.5 text-gray-600 dark:text-gray-400">Tanggal</label>
                        <input type="date"
                               name="tanggal"
                               value="{{ $stokKeluar->tanggal }}"
                               class="w-full border-b border-gray-200 dark:border-gray-700 bg-transparent py-2.5 px-1 text-sm focus:outline-hidden focus:border-blue-500 text-gray-900 dark:text-gray-100 transition"
                               required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm mb-1.5 text-gray-600 dark:text-gray-400">Jumlah Keluar</label>
                        <input type="number"
                               name="jumlah"
                               value="{{ abs($stokKeluar->jumlah) }}"
                               min="1"
                               class="w-full border-b border-gray-200 dark:border-gray-700 bg-transparent py-2.5 px-1 text-sm focus:outline-hidden focus:border-blue-500 text-gray-900 dark:text-gray-100 transition font-bold text-red-500 dark:text-red-400"
                               required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm mb-1.5 text-gray-600 dark:text-gray-400">Tujuan</label>
                        <input type="text"
                               name="tujuan"
                               value="{{ $stokKeluar->tujuan }}"
                               class="w-full border-b border-gray-200 dark:border-gray-700 bg-transparent py-2.5 px-1 text-sm focus:outline-hidden focus:border-blue-500 text-gray-900 dark:text-gray-100 transition"
                               required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm mb-1.5 text-gray-600 dark:text-gray-400">Keterangan (Opsional)</label>
                        <textarea name="keterangan"
                                  rows="3"
                                  class="w-full border-b border-gray-200 dark:border-gray-700 bg-transparent py-2.5 px-1 text-sm focus:outline-hidden focus:border-blue-500 text-gray-900 dark:text-gray-100 transition resize-none">{{ $stokKeluar->keterangan }}</textarea>
                    </div>

                    <div class="flex items-center gap-2 pt-4">
                        <button type="submit"
                                class="bg-amber-400 hover:bg-amber-500 text-amber-950 px-5 py-2 rounded-full text-sm font-bold shadow-xs transition">
                            Update Data
                        </button>

                        <a href="{{ route('stok_keluar.index') }}"
                           class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-full text-sm font-bold shadow-xs transition">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>