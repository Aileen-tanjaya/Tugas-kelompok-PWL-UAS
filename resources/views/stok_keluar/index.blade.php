<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Riwayat Transaksi Stok Keluar') }}
            </h2>
            <a href="{{ route('stok_keluar.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                ➕ Catat Stok Keluar
            </a>
        </div>
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
                                <th class="border p-3 w-16 text-center">No</th>
                                <th class="border p-3">Tanggal</th>
                                <th class="border p-3">Kode Barang</th>
                                <th class="border p-3">Nama Barang</th>
                                <th class="border p-3 text-center">Jumlah</th>
                                <th class="border p-3">Tujuan</th>
                                <th class="border p-3">Keterangan</th>
                                <th class="border p-3 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stokKeluars as $key => $sk)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                    <td class="border p-3 text-center">{{ $stokKeluars->firstItem() + $key }}</td>
                                    <td class="border p-3">{{ $sk->tanggal }}</td>
                                    <td class="border p-3 font-mono font-bold text-red-600 dark:text-red-400">
                                        {{ $sk->product->kode_barang ?? '-' }}
                                    </td>
                                    <td class="border p-3">{{ $sk->product->nama_barang ?? 'Produk Dihapus' }}</td>
                                    <td class="border p-3 text-center font-bold text-red-600">-{{ $sk->jumlah }}</td>
                                    <td class="border p-3"><span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-sm">{{ $sk->tujuan }}</span></td>
                                    <td class="border p-3 text-gray-500 text-sm">{{ $sk->keterangan ?? '-' }}</td>
                                    <td class="border p-3 text-center">
                                        <form action="{{ route('stok_keluar.destroy', $sk->id) }}" method="POST" onsubmit="return confirm('Hapus log transaksi ini? Stok barang akan dikembalikan otomatis.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="border p-4 text-center text-gray-500 italic">
                                        Belum ada riwayat pengeluaran stok.
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