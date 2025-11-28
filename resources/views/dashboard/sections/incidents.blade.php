<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Incidents</h3>
        <button onclick="showCreateForm('incident')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto">
        <table class="w-full divide-y divide-slate-800 md:table-auto">
            <thead class="bg-slate-900">
                <tr>
                    <th class="w-16 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">ID</th>
                    <th class="w-28 sm:w-36 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Penerbangan</th>
                    <th class="w-24 sm:w-32 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Kategori</th>
                    <th class="min-w-0 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400" style="max-width: 200px;">Lokasi</th>
                    <th class="w-24 sm:w-28 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Status</th>
                    <th class="w-28 sm:w-32 px-2 sm:px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($incidents as $incident)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300">#{{ $incident->id_incident }}</td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-200 cursor-pointer hover:text-blue-400 transition-colors truncate max-w-0" onclick="showPreview('Penerbangan', '{{ $incident->penerbangan ? ($incident->penerbangan->pesawat->registrasi ?? 'N/A') : 'N/A' }}', '{{ $incident->penerbangan ? ($incident->penerbangan->pesawat->registrasi ?? 'N/A') : 'N/A' }}')" title="{{ $incident->penerbangan ? ($incident->penerbangan->pesawat->registrasi ?? 'N/A') : 'N/A' }}">
                            {{ $incident->penerbangan ? Str::limit($incident->penerbangan->pesawat->registrasi ?? 'N/A', 15) : 'N/A' }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate max-w-0" onclick="showPreview('Kategori Insiden', '{{ $incident->kategori_insiden }}', '{{ $incident->kategori_insiden }}')" title="{{ $incident->kategori_insiden }}">
                            {{ Str::limit($incident->kategori_insiden ?? 'N/A', 15) }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate min-w-0" style="max-width: 200px;" onclick="showPreview('Lokasi Insiden', '{{ $incident->lokasi_insiden }}', '{{ addslashes($incident->lokasi_insiden ?? 'Tidak ada lokasi') }}')" title="{{ $incident->lokasi_insiden }}">
                            {{ Str::limit($incident->lokasi_insiden ?? 'N/A', 25) }}
                        </td>
                        <td class="px-2 sm:px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full whitespace-nowrap bg-slate-700/50 text-slate-300">
                                {{ $incident->status }}
                            </span>
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1 sm:gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('incident', {{ $incident->id_incident }})" class="px-2 sm:px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('incident', {{ $incident->id_incident }})" class="px-2 sm:px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-400">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $incidents->links() }}
    </div>
</div>
