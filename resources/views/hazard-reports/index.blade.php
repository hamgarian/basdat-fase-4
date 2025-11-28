<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-slate-50">
                    Hazard Reporting
                </h2>
                <p class="text-sm text-slate-400">Pantau dan kelola laporan hazard PT ERSA Eastern Aviation.</p>
            </div>
            <a
                href="{{ route('hazard-reports.create') }}"
                class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Tambah Laporan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-lg bg-slate-950 border border-slate-800 shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-800">
                        <thead class="bg-slate-900">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Kategori
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Pelapor
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Status
                                </th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-slate-950">
                            @forelse ($reports as $report)
                                @php
                                    $statusColors = [
                                        'Open' => 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
                                        'Investigated' => 'bg-blue-500/20 text-blue-300 border border-blue-500/30',
                                        'Closed' => 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30',
                                    ];
                                @endphp
                                <tr class="hover:bg-slate-900/50 transition-colors">
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-200">
                                        {{ $report->tanggal_laporan?->format('d M Y') }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-100">
                                        {{ $report->kategori }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-300">
                                        {{ $report->nama_pelapor }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusColors[$report->status] ?? 'bg-slate-700 text-slate-300 border border-slate-600' }}">
                                            {{ $report->status }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ route('hazard-reports.edit', $report) }}"
                                                class="rounded-md border border-blue-500/50 px-3 py-1 text-blue-400 hover:bg-blue-500/10 hover:border-blue-400 transition-colors"
                                            >
                                                Edit
                                            </a>
                                            <form
                                                action="{{ route('hazard-reports.destroy', $report) }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus laporan ini?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-md border border-red-500/50 px-3 py-1 text-red-400 hover:bg-red-500/10 hover:border-red-400 transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-400">
                                        Belum ada laporan hazard.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-800 px-4 py-3">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

