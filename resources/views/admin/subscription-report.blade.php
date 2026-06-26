<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Subscription
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <h3 class="text-xl font-bold">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Transaksi Paid</p>
                    <h3 class="text-xl font-bold">{{ $totalPaid }}</h3>
                </div>

                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Transaksi Pending</p>
                    <h3 class="text-xl font-bold">{{ $totalPending }}</h3>
                </div>

                <div class="bg-white p-4 rounded shadow">
                    <p class="text-sm text-gray-500">Total User</p>
                    <h3 class="text-xl font-bold">{{ $totalUsers }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold mb-4">Daftar Transaksi</h3>

                <table class="w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2">Invoice</th>
                            <th class="border p-2">User</th>
                            <th class="border p-2">Paket</th>
                            <th class="border p-2">Amount</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Metode</th>
                            <th class="border p-2">Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                            <tr>
                                <td class="border p-2">{{ $subscription->invoice_number }}</td>
                                <td class="border p-2">{{ $subscription->user->name }}</td>
                                <td class="border p-2">{{ $subscription->plan->name }}</td>
                                <td class="border p-2">
                                    Rp {{ number_format($subscription->amount, 0, ',', '.') }}
                                </td>
                                <td class="border p-2">{{ $subscription->status }}</td>
                                <td class="border p-2">{{ $subscription->payment_method }}</td>
                                <td class="border p-2">
                                    {{ $subscription->paid_at ? $subscription->paid_at->format('d-m-Y H:i') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border p-2 text-center">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $subscriptions->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>