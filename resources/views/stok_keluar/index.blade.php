<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Stok Keluar') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Bagian alert sukses/flash message sudah dihapus dari sini --}}

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Daftar Pengeluaran Barang</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('stok.index') }}" 
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Manajemen Stok
                        </a>
                        <a href="{{ route('stok_keluar.create') }}" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Tambah Stok Keluar
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-left">No</th>
                                <th class="border px-4 py-2 text-left">Tanggal</th>
                                <th class="border px-4 py-2 text-left">Kode</th>
                                <th class="border px-4 py-2 text-left">Nama Barang</th>
                                <th class="border px-4 py-2 text-left">Jumlah</th>
                                <th class="border px-4 py-2 text-left">Satuan</th>
                                <th class="border px-4 py-2 text-left">Tujuan / Keperluan</th>
                                <th class="border px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stokKeluars as $key => $sk)
                                <tr>
                                    <td class="border px-4 py-2">{{ $stokKeluars->firstItem() + $key }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($sk->tanggal)->format('d-m-Y') }}</td>
                                    <td class="border px-4 py-2">{{ $sk->product->kode_barang ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $sk->product->nama_barang ?? 'Produk Dihapus' }}</td>
                                    <td class="border px-4 py-2 text-red-600 font-bold">-{{ $sk->jumlah }}</td>
                                    <td class="border px-4 py-2">{{ strtolower($sk->product->satuan ?? '-') }}</td>
                                    
                                    <td class="border px-4 py-2">{{ $sk->tujuan ?? '-' }}</td>
                                    
                                    <td class="border px-4 py-2">
                                        <form action="{{ route('stok_keluar.destroy', $sk->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus riwayat ini? Stok barang akan dikembangkan otomatis.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: #dc2626 !important; color: white !important; padding: 5px 10px; border-radius: 3px; border: none; font-size: 14px; font-weight: bold; cursor: pointer;">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="border px-4 py-2 text-center">
                                        Belum ada data riwayat pengeluaran stok.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $stokKeluars->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>