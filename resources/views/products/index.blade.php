<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Bagian Header Tabel & Tombol Tambah --}}
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Daftar Barang</h3>
                        {{-- Menyamakan style tombol Tambah dengan Manajemen Pengguna --}}
                        <a href="{{ route('products.create') }}" style="background: blue !important; color: white !important; padding: 10px; display: block; width: 130px; text-align: center; border-radius: 5px; text-decoration: none;">
                            Tambah Barang
                        </a>
                    </div>         

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="border border-gray-200 px-4 py-2 text-left" style="width: 70px;">No</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Kode Barang</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Nama Barang</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Satuan</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">Harga</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">User</th> {{-- HEADER BARU --}}
                                    <th class="border border-gray-200 px-4 py-2 text-center" style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key => $product)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2 text-center">{{ $products->firstItem() + $key }}</td>
                                    <td class="border border-gray-200 px-4 py-2 font-semibold text-gray-700">{{ $product->kode_barang }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $product->nama_barang }}</td>
                                    <td class="border border-gray-200 px-4 py-2 text-gray-600">{{ $product->satuan }}</td>
                                    <td class="border border-gray-200 px-4 py-2">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                    
                                    {{-- DATA USER/ADMIN BARU --}}
                                    <td class="border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600">
                                        {{ $product->user->name ?? 'Sistem' }}
                                    </td>

                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            {{-- Tombol Edit Kuning --}}
                                            <a href="{{ route('products.edit', $product->id) }}" 
                                               style="background: orange !important; color: white !important; padding: 5px 10px; border-radius: 3px; text-decoration: none; display: inline-block; font-size: 14px; font-weight: bold;">
                                                Edit
                                            </a>
                                            {{-- Tombol Hapus Merah --}}
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: #dc2626 !important; color: white !important; padding: 5px 10px; border-radius: 3px; border: none; font-size: 14px; font-weight: bold; cursor: pointer;">
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

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>