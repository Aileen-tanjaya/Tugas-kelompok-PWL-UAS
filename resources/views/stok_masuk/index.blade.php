<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Stok Masuk') }}
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 dark:bg-green-900/30 dark:border-green-600 dark:text-green-400 text-green-700 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 border border-gray-100 dark:border-gray-700">

                <div class="flex justify-between items-center mb-4">

                    <h3 class="text-lg font-bold text-gray-700 dark:text-white">
                        Data Stok Masuk
                    </h3>

                    <div class="flex space-x-2">
                        <a href="{{ route('stok.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-full text-sm font-semibold transition shadow-sm flex items-center gap-1">
                            Manajemen Stok
                        </a>
                        <a href="{{ route('stok_masuk.create') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-sm transition">
                            Tambah Stok Masuk
                        </a>
                    </div>

                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200 dark:border-gray-700 text-left text-sm">

                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-bold">
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-14 text-center">No</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-28 text-center">Tanggal</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-28">Kode Barang</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3">Nama Barang</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-24 text-center">Jumlah</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3">Supplier</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3">Keterangan</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-36 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-gray-100">

                            @forelse($stokMasuks as $index => $stok)

                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition">

                                <td class="border border-gray-200 dark:border-gray-600 p-3 text-center">
                                    {{ $stokMasuks->firstItem() + $index }}
                                </td>

                                <td class="border border-gray-200 dark:border-gray-600 p-3 text-center text-gray-600 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($stok->tanggal)->format('d-m-Y') }}
                                </td>

                                <td class="border border-gray-200 dark:border-gray-600 p-3 font-mono font-bold text-gray-600 dark:text-gray-400">
                                    {{ $stok->product->kode_barang ?? '-' }}
                                </td>

                                <td class="border border-gray-200 dark:border-gray-600 p-3 font-medium">
                                    {{ $stok->product->nama_barang ?? 'Produk Terhapus' }}
                                </td>

                                <td class="border border-gray-200 dark:border-gray-600 p-3 text-center font-bold text-emerald-600 dark:text-emerald-400">
                                    + {{ $stok->jumlah }}
                                </td>

                                <td class="border border-gray-200 dark:border-gray-600 p-3 text-gray-600 dark:text-gray-400">
                                    {{ $stok->supplier ?? '-' }}
                                </td>

                                <td class="border border-gray-200 dark:border-gray-600 p-3 text-gray-500 dark:text-gray-400 italic">
                                    {{ $stok->keterangan ?? '-' }}
                                </td>

                                <td class="border border-gray-200 dark:border-gray-600 p-3 text-center">
                                    <div class="flex justify-center items-center gap-1.5">
                                        <a href="{{ route('stok_masuk.edit', $stok->id) }}"
                                           class="bg-amber-400 hover:bg-amber-500 text-amber-950 px-2.5 py-1 rounded-lg text-xs font-bold transition shadow-xs">
                                            Edit
                                        </a>

                                        <form action="{{ route('stok_masuk.destroy', $stok->id) }}"
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus data ini? Stok barang akan otomatis berkurang kembali.')"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-2.5 py-1 rounded-lg text-xs font-bold transition shadow-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="8" class="border border-gray-200 dark:border-gray-600 p-6 text-center text-gray-500 italic">
                                    Belum ada data stok masuk.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

                <div class="mt-5">
                    {{ $stokMasuks->links() }}
                </div>

            </div>

        </div>

    </div>

</x-app-layout>