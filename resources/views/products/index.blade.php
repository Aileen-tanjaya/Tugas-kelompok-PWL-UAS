<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Stok') }}
            </h2>
            <a href="{{ route('stok.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm font-semibold transition shadow-sm">
                ➕ Tambah Barang
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Daftar Stok Barang</h3>

                <form action="{{ route('stok.index') }}" method="GET" class="mb-5">
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-full text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Cari kode atau nama barang...">
                    </div>
                </form>

                <div class="flex flex-wrap gap-3 justify-center mb-6">
                    <span class="bg-blue-500 text-white px-5 py-1.5 rounded-full text-sm font-semibold shadow-sm">
                        Total: {{ $totalBarang }}
                    </span>
                    <span class="bg-yellow-500 text-gray-900 px-5 py-1.5 rounded-full text-sm font-semibold shadow-sm">
                        Menipis: {{ $stokMenipis }}
                    </span>
                    <span class="bg-red-500 text-white px-5 py-1.5 rounded-full text-sm font-semibold shadow-sm">
                        Habis: {{ $stokHabis }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200 dark:border-gray-700 text-left text-sm">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-bold">
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-14 text-center">No</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-28">Kode</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3">Nama Barang</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-32 text-center">Satuan</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-24 text-center">Stok</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-32 text-center">Status</th>
                                <th class="border border-gray-200 dark:border-gray-600 p-3 w-36 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-gray-100">
                            @forelse($products as $key => $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                    <td class="border border-gray-200 dark:border-gray-600 p-3 text-center">
                                        {{ method_exists($products, 'firstItem') ? ($products->firstItem() + $key) : ($key + 1) }}
                                    </td>
                                    <td class="border border-gray-200 dark:border-gray-600 p-3 font-mono font-bold text-gray-600 dark:text-gray-400">
                                        {{ $product->kode_barang }}
                                    </td>
                                    <td class="border border-gray-200 dark:border-gray-600 p-3 font-medium">
                                        {{ $product->nama_barang }}
                                    </td>
                                    <td class="border border-gray-200 dark:border-gray-600 p-3 text-center">
                                        @php
                                            $satuan = strtolower($product->satuan ?? 'pcs');
                                            $colorMap = [
                                                'gram'  => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
                                                'pcs'   => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                'ml'    => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                                'pouch' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400'
                                            ];
                                            $badgeColor = $colorMap[$satuan] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <div class="inline-flex items-center gap-1 {{ $badgeColor }} px-3 py-1 rounded-full text-xs font-bold tracking-wide">
                                            <span>{{ $satuan }}</span>
                                            <svg class="w-3 h-3 opacity-60" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </td>
                                    <td class="border border-gray-200 dark:border-gray-600 p-3 text-center font-bold">
                                        {{ $product->stok }}
                                    </td>
                                    <td class="border border-gray-200 dark:border-gray-600 p-3 text-center">
                                        @if($product->stok == 0)
                                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold block text-center shadow-xs">
                                                Habis
                                            </span>
                                        @elseif($product->stok <= 5)
                                            <span class="bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 dark:bg-yellow-500 dark:dark:text-gray-900 px-3 py-1 rounded-full text-xs font-bold block text-center shadow-xs">
                                                Menipis ⚠️
                                            </span>
                                        @else
                                            <span class="bg-emerald-400 text-emerald-950 px-3 py-1 rounded-full text-xs font-bold block text-center shadow-xs">
                                                Aman ✓
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-200 dark:border-gray-600 p-3 text-center">
                                        <div class="flex justify-center items-center gap-1.5">
                                            <a href="{{ route('stok.edit', $product->id) }}" class="bg-amber-400 hover:bg-amber-500 text-amber-950 px-2.5 py-1 rounded-lg text-xs font-bold transition shadow-xs">
                                                Edit
                                            </a>
                                            <form action="{{ route('stok.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-2.5 py-1 rounded-lg text-xs font-bold transition shadow-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="border border-gray-200 dark:border-gray-600 p-6 text-center text-gray-500 italic">
                                        Data barang tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($products, 'links'))
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>