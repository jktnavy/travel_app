<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::section>
            <x-slot name="heading">
                Laporan Backoffice
            </x-slot>

            <x-slot name="description">
                Halaman ini disiapkan untuk ringkasan bisnis owner dan admin. Implementasi laporan detail bisa dilanjutkan di step berikutnya.
            </x-slot>

            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-gray-200 p-4">
                    <h3 class="text-sm font-semibold text-gray-900">Revenue Summary</h3>
                    <p class="mt-2 text-sm text-gray-600">Placeholder untuk pendapatan harian, mingguan, dan bulanan.</p>
                </div>

                <div class="rounded-xl border border-gray-200 p-4">
                    <h3 class="text-sm font-semibold text-gray-900">Operational Utilization</h3>
                    <p class="mt-2 text-sm text-gray-600">Placeholder untuk utilisasi armada, jadwal aktif, dan tingkat okupansi.</p>
                </div>

                <div class="rounded-xl border border-gray-200 p-4">
                    <h3 class="text-sm font-semibold text-gray-900">Payment Insights</h3>
                    <p class="mt-2 text-sm text-gray-600">Placeholder untuk status pembayaran, settlement, dan exception monitoring.</p>
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
