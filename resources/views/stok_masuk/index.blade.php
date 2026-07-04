<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Transaksi Stok Masuk') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Daftar Penerimaan Barang</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('stok.index') }}" 
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Manajemen Stok
                        </a>
                        <a href="{{ route('stok_masuk.create') }}" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Tambah Stok Masuk
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
                                <th class="border px-4 py-2 text-left">Keterangan</th>
                                <th class="border px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stokMasuks as $index => $stok)
                                <tr>
                                    <td class="border px-4 py-2">{{ $stokMasuks->firstItem() + $index }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($stok->tanggal)->format('d-m-Y') }}</td>
                                    <td class="border px-4 py-2">{{ $stok->product->kode_barang ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $stok->product->nama_barang ?? 'Produk Terhapus' }}</td>
                                    <td class="border px-4 py-2 text-green-600 font-bold">+{{ $stok->jumlah }}</td>
                                    <td class="border px-4 py-2">{{ strtolower($stok->product->satuan ?? '-') }}</td>
                                    <td class="border px-4 py-2">{{ $stok->keterangan ?? '-' }}</td>
                                    <td class="border px-4 py-2">
                                        <form action="{{ route('stok_masuk.destroy', $stok->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini? Stok barang akan otomatis dikurangi kembali.')">
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
                                        Belum ada data stok masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $stokMasuks->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>