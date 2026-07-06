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

                <form action="{{ route('stok.index') }}" method="GET" class="mb-6 w-full">
                    <div style="display: flex !important; flex-direction: row !important; gap: 12px !important; align-items: center !important; width: 100% !important;">
                        
                        <div class="relative" style="flex: 1 !important;">
                            <div class="absolute pointer-events-none flex items-center justify-center" 
                                 style="top: 50%; transform: translateY(-50%); left: 16px; height: auto; width: auto;">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   class="w-full pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   style="padding-left: 52px !important; height: 42px !important;"
                                   placeholder="Cari kode atau nama barang...">
                        </div>

                        <div style="width: 180px !important; flex-shrink: 0 !important;">
                            <select name="status" 
                                    onchange="this.form.submit()" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm bg-white font-medium text-gray-700"
                                    style="height: 42px !important;">
                                <option value="">-- Semua Status --</option>
                                <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Aman</option>
                                <option value="menipis" {{ request('status') == 'menipis' ? 'selected' : '' }}>Menipis</option>
                                <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>

                        @if(request('status') || request('search'))
                            <a href="{{ route('stok.index') }}" 
                               class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg flex items-center justify-center shadow-sm transition-colors"
                               style="height: 42px !important; white-space: nowrap !important;">
                                Reset
                            </a>
                        @endif

                    </div>
                </form>

                <div style="display: flex !important; flex-direction: row !important; justify-content: center !important; align-items: center !important; gap: 24px !important; margin-top: 24px !important; margin-bottom: 16px !important; width: 100% !important;">
                    <div class="bg-blue-600 text-white px-5 py-1.5 rounded text-sm font-semibold shadow-sm text-center" style="min-width: 120px !important; display: block !important;">
                        Total: {{ $totalBarang }}
                    </div>
                    <div class="text-white px-5 py-1.5 rounded text-sm font-semibold shadow-sm text-center" style="background-color: #22c55e !important; min-width: 120px !important; display: block !important;">
                        Aman: {{ $stokAman }}
                    </div>
                    <div class="text-white px-5 py-1.5 rounded text-sm font-semibold shadow-sm text-center" style="background-color: #eab308 !important; min-width: 120px !important; display: block !important;">
                        Menipis: {{ $stokMenipis }}
                    </div>
                    <div class="bg-red-600 text-white px-5 py-1.5 rounded text-sm font-semibold shadow-sm text-center" style="min-width: 120px !important; display: block !important;">
                        Habis: {{ $stokHabis }}
                    </div>
                </div>

                <div class="overflow-x-auto mt-2">
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
                                @php
                                    $angkaStok = $product->calculated_stok ?? 0;
                                @endphp
                                <tr>
                                    <td class="border px-4 py-2 text-center">
                                        {{ $key + 1 }}
                                    </td>
                                    <td class="border px-4 py-2 font-mono font-bold text-gray-600">{{ $product->kode_barang }}</td>
                                    <td class="border px-4 py-2 font-medium">{{ $product->nama_barang }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <span class="bg-gray-100 border border-gray-200 px-3 py-1 rounded text-xs font-semibold text-gray-700">
                                            {{ strtolower($product->satuan ?? 'pcs') }}
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2 text-center font-bold">
                                        {{ $angkaStok }}
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        @if($angkaStok <= 0)
                                            <span class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold block text-center shadow-sm">
                                                HABIS
                                            </span>
                                        @elseif($angkaStok > 0 && $angkaStok <= 2)
                                            <span class="text-white px-3 py-1 rounded text-xs font-bold block text-center shadow-sm" style="background-color: #eab308 !important;">
                                                MENIPIS
                                            </span>
                                        @else
                                            <span class="text-white px-3 py-1 rounded text-xs font-bold block text-center shadow-sm" style="background-color: #22c55e !important;">
                                                AMAN
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-4 py-2 text-center text-gray-500 italic">
                                        Data barang tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>