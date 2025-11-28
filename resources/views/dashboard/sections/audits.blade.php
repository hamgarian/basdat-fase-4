<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Audits</h3>
        <button onclick="showCreateForm('audit')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto md:overflow-hidden">
        <table class="w-full divide-y divide-slate-800 md:table-auto">
            <thead class="bg-slate-900">
                <tr>
                    <th class="w-24 sm:w-32 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Nomor Audit</th>
                    <th class="min-w-0 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400" style="max-width: 200px;">Judul</th>
                    <th class="w-24 sm:w-32 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Kategori</th>
                    <th class="w-24 sm:w-32 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Tanggal</th>
                    <th class="w-24 sm:w-32 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Karyawan</th>
                    <th class="w-28 sm:w-32 px-2 sm:px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($audits as $audit)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate max-w-0" onclick="showPreview('Nomor Audit', '{{ $audit->nomor_audit }}', '{{ $audit->nomor_audit }}')" title="{{ $audit->nomor_audit }}">
                            {{ Str::limit($audit->nomor_audit, 15) }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-200 cursor-pointer hover:text-blue-400 transition-colors truncate min-w-0" style="max-width: 200px;" onclick="showPreview('Judul Audit', '{{ Str::limit($audit->judul, 50) }}', '{{ addslashes($audit->judul ?? 'Tidak ada judul') }}')" title="{{ $audit->judul }}">
                            {{ Str::limit($audit->judul, 25) }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate max-w-0" onclick="showPreview('Kategori', '{{ $audit->kategori }}', '{{ $audit->kategori }}')" title="{{ $audit->kategori }}">
                            {{ Str::limit($audit->kategori ?? 'N/A', 15) }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors whitespace-nowrap" onclick="showPreview('Tanggal Pelaksanaan', '{{ $audit->tanggal_pelaksanaan?->format('d M Y') }}', '{{ $audit->tanggal_pelaksanaan?->format('d F Y') }}')">{{ $audit->tanggal_pelaksanaan?->format('d M Y') }}</td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate max-w-0" onclick="showPreview('Karyawan', '{{ $audit->karyawan->nama_karyawan ?? 'N/A' }}', '{{ $audit->karyawan->nama_karyawan ?? 'N/A' }}')" title="{{ $audit->karyawan->nama_karyawan ?? 'N/A' }}">
                            {{ Str::limit($audit->karyawan->nama_karyawan ?? 'N/A', 15) }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1 sm:gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('audit', {{ $audit->id_audit }})" class="px-2 sm:px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('audit', {{ $audit->id_audit }})" class="px-2 sm:px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
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
        {{ $audits->links() }}
    </div>
</div>
