<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Stok Masuk
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('stok-masuk.update', $stokMasuk->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Barang
                        </label>

                        <select name="product_id"
                            class="w-full border rounded px-3 py-2"
                            required>

                            @foreach($products as $product)

                                <option value="{{ $product->id }}"
                                    {{ $stokMasuk->product_id == $product->id ? 'selected' : '' }}>

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
                            value="{{ $stokMasuk->tanggal }}"
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
                            value="{{ $stokMasuk->jumlah }}"
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
                            value="{{ $stokMasuk->supplier }}"
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
                            class="w-full border rounded px-3 py-2">{{ $stokMasuk->keterangan }}</textarea>

                    </div>

                    <div class="flex gap-3">

                        <button
                            type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded">

                            Update

                        </button>

                        <a href="{{ route('stok-masuk.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>