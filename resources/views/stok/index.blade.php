<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Stok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    
                    {{-- Header Tabel & Tombol Tambah --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Daftar Stok Barang</h3>
                        <a href="{{ route('stok.create') }}" style="background: blue !important; color: white !important; padding: 10px; display: block; width: 130px; text-align: center; border-radius: 5px; text-decoration: none;">
                            Tambah Barang
                        </a>
                    </div>
                    
                    {{-- INPUT PENCARIAN --}}
                    <div class="mb-6" style="position: relative !important; width: 100% !important;">
                        <form action="{{ route('stok.index') }}" method="GET" style="position: relative !important; display: flex !important; align-items: center !important;">
                            
                            <div style="position: absolute !important; left: 15px !important; top: 50% !important; transform: translateY(-50%) !important; display: flex !important; align-items: center !important; justify-content: center !important; pointer-events: none !important; z-index: 10 !important;">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px !important; height: 20px !important;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama barang atau kode barang..."
                                style="width: 100% !important; padding-left: 45px !important; padding-right: 20px !important; padding-top: 10px !important; padding-bottom: 10px !important; border-radius: 9999px !important; border: 1px solid #d1d5db !important; line-height: 1.5 !important; font-size: 14px !important; outline: none !important;"
                                class="focus:ring-2 focus:ring-blue-500">
                            
                            {{-- Dropdown Filter Status --}}
                            <select name="status" onchange="this.form.submit()" 
                                style="height: 45px; border-radius: 9999px; border: 1px solid #d1d5db; padding: 0 20px; background-color: white; outline: none; min-width: 150px;">
                                <option value="">Status</option>
                                <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Aman ✅</option>
                                <option value="menipis" {{ request('status') == 'menipis' ? 'selected' : '' }}>Menipis ⚠️</option>
                                <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis ❌</option>
                            </select>
                            
                            {{-- Tombol Reset --}}
                            @if(request('search') || request('status'))
                               <a href="{{ route('stok.index') }}" 
                                  style="height: 45px; display: flex; align-items: center; justify-content: center; padding: 0 20px; border-radius: 9999px; background: #6b7280; color: white; text-decoration: none; font-size: 14px;">
                                  Reset
                               </a>
                            @endif
                        </form>
                    </div>

                    {{-- STATISTIK RINGKASAN --}}
                    <div class="flex flex-wrap justify-center items-center gap-4 mb-6">
                        <div style="background-color: #2563eb !important;" class="flex items-center text-white px-6 py-2 rounded-full shadow-sm">
                            <span class="font-bold">Total Barang:</span>
                            <span class="ml-2 font-black text-xl">{{ number_format($totalSeluruhStok, 0, ',', '.') }}</span>
                        </div>
                        <div style="background-color: #16a34a !important;" class="flex items-center text-white px-6 py-2 rounded-full shadow-sm">
                            <span class="font-bold">Aman:</span>
                            <span class="ml-2 font-black text-xl">{{ $stokAman }}</span>
                        </div>
                        <div style="background-color: #f59e0b !important;" class="flex items-center text-white px-6 py-2 rounded-full shadow-sm">
                            <span class="font-bold">Menipis:</span>
                            <span class="ml-2 font-black text-xl">{{ $stokMenipis }}</span>
                        </div>
                        <div style="background-color: #dc2626 !important;" class="flex items-center text-white px-6 py-2 rounded-full shadow-sm">
                            <span class="font-bold">Habis:</span>
                            <span class="ml-2 font-black text-xl">{{ $stokHabis }}</span>
                        </div>
                    </div>

                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full border-collapse bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-200 px-4 py-2 text-center" style="width: 70px;">No</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Kode Barang</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Nama Barang</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center">Stok Masuk</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center">Stok Keluar</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center">Stok Tersedia</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center">Status</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center" style="width: 150px;">Tanggal Update</th>
                                    <th class="border border-gray-200 px-4 py-2 text-center">User</th> {{-- HEADER BARU --}}
                                    <th class="border border-gray-200 px-4 py-2 text-center" style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stoks as $key => $stok)
                                <tr class="hover:bg-gray-50 border-b border-gray-100 transition-colors">
                                    {{-- 1. No --}}
                                    <td class="border border-gray-200 px-4 py-4 text-center text-sm text-gray-600">
                                        {{ $stoks->firstItem() + $key }}
                                    </td>
                                    {{-- 2. Kode Barang --}}
                                    <td class="border border-gray-200 px-4 py-4 font-bold text-blue-600 text-sm">
                                        {{ $stok->kode_barang }}
                                    </td>
                                    {{-- 3. Nama Barang --}}
                                    <td class="border border-gray-200 px-4 py-4 text-sm text-gray-800">
                                        {{ $stok->nama_barang }}
                                    </td>
                                    {{-- 4. Stok Masuk --}}
                                    <td class="border border-gray-200 px-4 py-4 text-center font-semibold text-blue-600 text-sm">
                                        {{ $stok->stok_masuk ?? 0 }}
                                    </td>
                                    {{-- 5. Stok Keluar --}}
                                    <td class="border border-gray-200 px-4 py-4 text-center font-semibold text-red-600 text-sm">
                                        {{ $stok->stok_keluar ?? 0 }}
                                    </td>
                                    {{-- 6. Stok Tersedia --}}
                                    <td class="border border-gray-200 px-4 py-4 text-center font-black text-gray-900 text-sm">
                                        {{ $stok->stok ?? 0 }}
                                    </td>
                                    {{-- 7. Status --}}
                                    <td class="border border-gray-200 px-4 py-4 text-center">
                                        @if($stok->stok <= 0)
                                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-red-100 text-red-700 inline-flex items-center">Habis ❌</span>
                                        @elseif($stok->stok <= 2)
                                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-orange-100 text-orange-700 inline-flex items-center">Menipis ⚠️</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-green-100 text-green-700 inline-flex items-center">Aman ✅</span>
                                        @endif
                                    </td>
                                    {{-- 8. Terakhir Diupdate --}}
                                    <td class="border border-gray-200 px-4 py-4 text-center text-xs text-gray-600">
                                        @if($stok->tanggal_update)
                                            {{ \Carbon\Carbon::parse($stok->tanggal_update)->translatedFormat('d M Y H:i') }} WIB
                                        @else
                                            -
                                        @endif
                                    </td>
                                    
                                    {{-- 9. DATA USER/ADMIN BARU --}}
                                    <td class="border border-gray-200 px-4 py-4 text-center text-sm font-semibold text-gray-700">
                                        {{ $stok->user->name ?? 'Sistem' }}
                                    </td>

                                    {{-- 10. Aksi --}}
                                    <td class="border border-gray-200 px-4 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('stok.edit', $stok->id) }}"
                                               style="background: orange !important; color: white !important; padding: 6px 12px !important; border-radius: 4px !important; text-decoration: none !important; font-size: 12px !important; font-weight: bold !important;">
                                                Edit
                                            </a>
                                            <form action="{{ route('stok.destroy', $stok->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')" style="margin: 0 !important;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: #dc2626 !important; color: white !important; padding: 6px 12px !important; border-radius: 4px !important; border: none !important; font-size: 12px !important; font-weight: bold !important; cursor: pointer !important;">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $stoks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>