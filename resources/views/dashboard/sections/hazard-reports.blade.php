<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Hazard Reports</h3>
        <button onclick="showCreateForm('hazard-report')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto">
        <table class="w-full divide-y divide-slate-800 md:table-auto">
            <thead class="bg-slate-900">
                <tr>
                    <th class="w-16 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">ID</th>
                    <th class="w-24 sm:w-28 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Tanggal</th>
                    <th class="w-24 sm:w-32 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Pelapor</th>
                    <th class="w-24 sm:w-32 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Kategori</th>
                    <th class="min-w-0 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400" style="max-width: 200px;">Deskripsi</th>
                    <th class="w-24 sm:w-28 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Status</th>
                    <th class="w-28 sm:w-32 px-2 sm:px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($hazardReports as $report)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300">#{{ $report->id_hazard }}</td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors whitespace-nowrap" onclick="showPreview('Tanggal Laporan', '{{ $report->tanggal_laporan?->format('d M Y') }}', '{{ $report->tanggal_laporan?->format('d F Y') }}')">{{ $report->tanggal_laporan?->format('d M Y') }}</td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-200 cursor-pointer hover:text-blue-400 transition-colors truncate max-w-0" onclick="showPreview('Pelapor', '{{ $report->karyawan->nama_karyawan ?? $report->nama_pelapor ?? 'N/A' }}', '{{ $report->karyawan->nama_karyawan ?? $report->nama_pelapor ?? 'N/A' }}')" title="{{ $report->karyawan->nama_karyawan ?? $report->nama_pelapor ?? 'N/A' }}">
                            {{ Str::limit($report->karyawan->nama_karyawan ?? $report->nama_pelapor ?? 'N/A', 15) }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate max-w-0" onclick="showPreview('Kategori', '{{ $report->kategori }}', '{{ $report->kategori }}')" title="{{ $report->kategori }}">
                            {{ Str::limit($report->kategori ?? 'N/A', 15) }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors min-w-0" style="max-width: 200px;" onclick="showPreview('Deskripsi', '{{ Str::limit($report->deskripsi, 100) }}', '{{ addslashes($report->deskripsi ?? 'Tidak ada deskripsi') }}')">
                            <div class="truncate" title="{{ $report->deskripsi }}">
                                {{ Str::limit($report->deskripsi, 30) }}
                            </div>
                        </td>
                        <td class="px-2 sm:px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full whitespace-nowrap {{ $report->status === 'Open' ? 'bg-amber-500/20 text-amber-300' : ($report->status === 'Investigated' ? 'bg-blue-500/20 text-blue-300' : 'bg-emerald-500/20 text-emerald-300') }}">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1 sm:gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('hazard-report', {{ $report->id_hazard }})" class="px-2 sm:px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('hazard-report', {{ $report->id_hazard }})" class="px-2 sm:px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-400">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $hazardReports->links() }}
    </div>
</div>

