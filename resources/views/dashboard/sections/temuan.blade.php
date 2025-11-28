<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Temuan</h3>
        <button onclick="showCreateForm('temuan')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto">
        <table class="w-full divide-y divide-slate-800">
            <thead class="bg-slate-900">
                <tr>
                    <th class="w-16 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">ID</th>
                    <th class="w-24 sm:w-32 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Audit</th>
                    <th class="min-w-0 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400" style="max-width: 250px;">Deskripsi</th>
                    <th class="w-24 sm:w-32 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Status</th>
                    <th class="w-28 sm:w-32 px-2 sm:px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($temuan as $item)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300">#{{ $item->id_temuan }}</td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-200 cursor-pointer hover:text-blue-400 transition-colors truncate max-w-0" onclick="showPreview('Audit', '{{ $item->audit ? $item->audit->nomor_audit : 'N/A' }}', '{{ $item->audit ? ('Nomor: ' . $item->audit->nomor_audit . '\nJudul: ' . ($item->audit->judul ?? 'Tidak ada judul')) : 'N/A' }}')" title="{{ $item->audit ? $item->audit->nomor_audit : 'N/A' }}">
                            {{ $item->audit ? Str::limit($item->audit->nomor_audit, 15) : 'N/A' }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate min-w-0" style="max-width: 250px;" onclick="showPreview('Deskripsi Temuan', '{{ Str::limit($item->deskripsi_temuan, 100) }}', '{{ addslashes($item->deskripsi_temuan ?? 'Tidak ada deskripsi') }}')">
                            <div class="truncate" title="{{ $item->deskripsi_temuan }}">
                                {{ Str::limit($item->deskripsi_temuan, 30) }}
                            </div>
                        </td>
                        <td class="px-2 sm:px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full whitespace-nowrap bg-slate-700/50 text-slate-300">
                                {{ $item->status_tindak_lanjut }}
                            </span>
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1 sm:gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('temuan', {{ $item->id_temuan }})" class="px-2 sm:px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('temuan', {{ $item->id_temuan }})" class="px-2 sm:px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
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
        {{ $temuan->links() }}
    </div>
</div>
