<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Pilots</h3>
        <button onclick="showCreateForm('pilot')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto md:overflow-hidden">
        <table class="w-full divide-y divide-slate-800 md:table-auto">
            <thead class="bg-slate-900">
                <tr>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Lisensi</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Nama</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Rating</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Jam Terbang</th>
                    <th class="w-28 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Status</th>
                    <th class="w-32 px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($pilots as $pilot)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Lisensi Pilot', '{{ $pilot->lisensi_pilot }}', '{{ $pilot->lisensi_pilot }}')" title="{{ $pilot->lisensi_pilot }}">
                            {{ Str::limit($pilot->lisensi_pilot, 20) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-slate-200 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Nama Pilot', '{{ $pilot->karyawan->nama_karyawan ?? 'N/A' }}', '{{ $pilot->karyawan ? ('Nama: ' . $pilot->karyawan->nama_karyawan . '\nNIK: ' . ($pilot->karyawan->nik ?? 'N/A') . '\nTelepon: ' . ($pilot->karyawan->nomor_telepon ?? 'N/A')) : 'N/A' }}')" title="{{ $pilot->karyawan->nama_karyawan ?? 'N/A' }}">
                            {{ Str::limit($pilot->karyawan->nama_karyawan ?? 'N/A', 30) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Rating Pesawat', '{{ $pilot->rating_pesawat }}', '{{ $pilot->rating_pesawat }}')" title="{{ $pilot->rating_pesawat }}">
                            {{ Str::limit($pilot->rating_pesawat ?? 'N/A', 20) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors" onclick="showPreview('Jam Terbang Total', '{{ number_format($pilot->jam_terbang_total) }} jam', '{{ number_format($pilot->jam_terbang_total) }} jam')">{{ number_format($pilot->jam_terbang_total) }} jam</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $pilot->status === 'Aktif' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-700/50 text-slate-300' }}">
                                {{ $pilot->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('pilot', {{ $pilot->id_pilot }})" class="px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('pilot', {{ $pilot->id_pilot }})" class="px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
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
        {{ $pilots->links() }}
    </div>
</div>
