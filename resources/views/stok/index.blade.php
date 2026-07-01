<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Stok Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300 dark:border-gray-700 text-left text-gray-900 dark:text-gray-100">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="border p-2 w-16 text-center">No</th>
                                <th class="border p-2">Kode Barang</th>
                                <th class="border p-2">Nama Barang</th>
                                <th class="border p-2 w-32 text-center">Stok Saat Ini</th>
                                <th class="border p-2 text-center w-64">Log Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $key => $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                    <td class="border p-2 text-center">{{ $products->firstItem() + $key }}</td>
                                    <td class="border p-2 font-mono font-bold text-blue-600 dark:text-blue-400">{{ $product->kode_barang }}</td>
                                    <td class="border p-2">{{ $product->nama_barang }}</td>
                                    <td class="border p-2 text-center">
                                        <span class="px-2 py-1 rounded font-bold {{ $product->stok < 5 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $product->stok }}
                                        </span>
                                    </td>
                                    <td class="border p-2 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('stok_masuk.index') }}"
                                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition duration-150">
                                                📥 Riwayat Masuk
                                            </a>
                                            <a href="{{ route('stok_keluar.index') }}"
                                               class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs transition duration-150">
                                                📤 Riwayat Keluar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border p-4 text-center text-gray-500">
                                        Belum ada data barang. Silakan tambahkan lewat menu Stok Masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>