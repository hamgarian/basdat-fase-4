<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Investigations</h3>
        <button onclick="showCreateForm('investigation')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto md:overflow-hidden">
        <table class="w-full divide-y divide-slate-800 md:table-auto">
            <thead class="bg-slate-900">
                <tr>
                    <th class="w-20 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Hazard Report</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Tanggal Mulai</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Tanggal Selesai</th>
                    <th class="w-32 px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($investigations as $investigation)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-4 py-3 text-sm text-slate-300">#{{ $investigation->id_investigasi }}</td>
                        <td class="px-4 py-3 text-sm text-slate-200 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Hazard Report', '{{ $investigation->hazardReport ? ('#' . $investigation->hazardReport->id_hazard . ' - ' . $investigation->hazardReport->kategori) : 'N/A' }}', '{{ $investigation->hazardReport ? ('ID: #' . $investigation->hazardReport->id_hazard . '\nKategori: ' . $investigation->hazardReport->kategori . '\nDeskripsi: ' . ($investigation->hazardReport->deskripsi ?? 'Tidak ada deskripsi')) : 'N/A' }}')" title="{{ $investigation->hazardReport ? ('#' . $investigation->hazardReport->id_hazard . ' - ' . $investigation->hazardReport->kategori) : 'N/A' }}">
                            @if($investigation->hazardReport)
                                {{ Str::limit('#' . $investigation->hazardReport->id_hazard . ' - ' . $investigation->hazardReport->kategori, 30) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors" onclick="showPreview('Tanggal Mulai', '{{ $investigation->tanggal_mulai?->format('d M Y') }}', '{{ $investigation->tanggal_mulai?->format('d F Y') }}')">{{ $investigation->tanggal_mulai?->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors" onclick="showPreview('Tanggal Selesai', '{{ $investigation->tanggal_selesai?->format('d M Y') }}', '{{ $investigation->tanggal_selesai?->format('d F Y') }}')">{{ $investigation->tanggal_selesai?->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('investigation', {{ $investigation->id_investigasi }})" class="px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('investigation', {{ $investigation->id_investigasi }})" class="px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-400">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $investigations->links() }}
    </div>
</div>
