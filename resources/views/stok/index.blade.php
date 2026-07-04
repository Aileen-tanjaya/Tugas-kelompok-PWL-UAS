<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Stok') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4">Daftar Stok Barang</h3>

                <form action="{{ route('stok.index') }}" method="GET" class="mb-5">
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Cari kode atau nama barang...">
                    </div>
                </form>

                <div class="flex flex-wrap gap-3 justify-center mb-6">
                    <span class="bg-blue-600 text-white px-5 py-1.5 rounded text-sm font-semibold shadow-sm">
                        Total: {{ $totalBarang }}
                    </span>
                    <span class="bg-yellow-500 text-white px-5 py-1.5 rounded text-sm font-semibold shadow-sm">
                        Menipis: {{ $stokMenipis }}
                    </span>
                    <span class="bg-red-600 text-white px-5 py-1.5 rounded text-sm font-semibold shadow-sm">
                        Habis: {{ $stokHabis }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-center w-14">No</th>
                                <th class="border px-4 py-2 text-left w-28">Kode</th>
                                <th class="border px-4 py-2 text-left">Nama Barang</th>
                                <th class="border px-4 py-2 text-center w-32">Satuan</th>
                                <th class="border px-4 py-2 text-center w-24">Stok</th>
                                <th class="border px-4 py-2 text-center w-32">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $key => $product)
                                <tr>
                                    <td class="border px-4 py-2 text-center">
                                        {{ method_exists($products, 'firstItem') ? ($products->firstItem() + $key) : ($key + 1) }}
                                    </td>
                                    <td class="border px-4 py-2">{{ $product->kode_barang }}</td>
                                    <td class="border px-4 py-2">{{ $product->nama_barang }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        @php
                                            $satuan = strtolower($product->satuan ?? 'pcs');
                                        @endphp
                                        <span class="bg-gray-100 border border-gray-200 px-3 py-1 rounded text-xs font-semibold text-gray-700">
                                            {{ $satuan }}
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2 text-center font-bold">
                                        {{ $product->stok }}
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        @if($product->stok == 0)
                                            <span class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold block text-center">
                                                HABIS
                                            </span>
                                        @elseif($product->stok <= 5)
                                            <span class="bg-yellow-500 text-white px-3 py-1 rounded text-xs font-bold block text-center">
                                                MENIPIS
                                            </span>
                                        @else
                                            <span class="bg-green-500 text-white px-3 py-1 rounded text-xs font-bold block text-center">
                                                Aman
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
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