<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Library Manuals</h3>
        <button onclick="showCreateForm('library-manual')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto md:overflow-hidden">
        <table class="w-full divide-y divide-slate-800 md:table-auto">
            <thead class="bg-slate-900">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Judul</th>
                    <th class="w-40 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Departemen</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Tanggal Terbit</th>
                    <th class="w-28 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Status</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Karyawan</th>
                    <th class="w-32 px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($libraryManuals as $manual)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-4 py-3 text-sm text-slate-200 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Judul Manual', '{{ Str::limit($manual->judul_manual, 50) }}', '{{ addslashes($manual->judul_manual ?? 'Tidak ada judul') }}')" title="{{ $manual->judul_manual }}">
                            {{ Str::limit($manual->judul_manual, 40) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Departemen Pemilik', '{{ $manual->departemen_pemilik }}', '{{ $manual->departemen_pemilik }}')" title="{{ $manual->departemen_pemilik }}">
                            {{ Str::limit($manual->departemen_pemilik ?? 'N/A', 20) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors" onclick="showPreview('Tanggal Terbit', '{{ $manual->tanggal_terbit?->format('d M Y') }}', '{{ $manual->tanggal_terbit?->format('d F Y') }}')">{{ $manual->tanggal_terbit?->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $manual->status === 'Active' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-700/50 text-slate-300' }}">
                                {{ $manual->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Karyawan', '{{ $manual->karyawan->nama_karyawan ?? 'N/A' }}', '{{ $manual->karyawan->nama_karyawan ?? 'N/A' }}')" title="{{ $manual->karyawan->nama_karyawan ?? 'N/A' }}">
                            {{ Str::limit($manual->karyawan->nama_karyawan ?? 'N/A', 20) }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('library-manual', {{ $manual->id_manual }})" class="px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('library-manual', {{ $manual->id_manual }})" class="px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
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
        {{ $libraryManuals->links() }}
    </div>
</div>
