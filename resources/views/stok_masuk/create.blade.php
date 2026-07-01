<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Stok Masuk
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('stok_masuk.store') }}" method="POST">

                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Barang
                        </label>

                        <select name="product_id"
                            class="w-full border rounded px-3 py-2"
                            required>

                            <option value="">-- Pilih Barang --</option>

                            @foreach($products as $product)

                                <option value="{{ $product->id }}">
                                    {{ $product->kode_barang }} - {{ $product->nama_barang }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Tanggal
                        </label>
                        <input
                            type="date"
                            name="tanggal"
                            value="{{ date('Y-m-d') }}"
                            class="w-full border rounded px-3 py-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Jumlah
                        </label>
                        <input
                            type="number"
                            name="jumlah"
                            min="1"
                            class="w-full border rounded px-3 py-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Supplier
                        </label>
                        <input
                            type="text"
                            name="supplier"
                            class="w-full border rounded px-3 py-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Keterangan
                        </label>
                        <textarea
                            name="keterangan"
                            rows="4"
                            class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                            Simpan
                        </button>

                        <a href="{{ route('stok_masuk.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">
                            Kembali
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>