<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Flight Movements</h3>
        <button onclick="showCreateForm('flight-movement')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto md:overflow-hidden">
        <table class="w-full divide-y divide-slate-800 md:table-auto">
            <thead class="bg-slate-900">
                <tr>
                    <th class="w-20 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">ID</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Penerbangan</th>
                    <th class="w-40 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Pilot</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Rute</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Jam Terbang</th>
                    <th class="w-32 px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($flightMovements as $fm)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-4 py-3 text-sm text-slate-300">#{{ $fm->id_flight_movement }}</td>
                        <td class="px-4 py-3 text-sm text-slate-200 cursor-pointer hover:text-blue-400 transition-colors" onclick="showPreview('Penerbangan', '#{{ $fm->penerbangan->id_penerbangan ?? 'N/A' }}', '{{ $fm->penerbangan ? ('ID: #' . $fm->penerbangan->id_penerbangan . '\nPesawat: ' . ($fm->penerbangan->pesawat->registrasi ?? 'N/A') . '\nTanggal: ' . ($fm->penerbangan->tanggal_penerbangan?->format('d F Y') ?? 'N/A')) : 'N/A' }}')">
                            @if($fm->penerbangan)
                                #{{ $fm->penerbangan->id_penerbangan }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Pilot', '{{ $fm->pilot && $fm->pilot->karyawan ? $fm->pilot->karyawan->nama_karyawan : 'N/A' }}', '{{ $fm->pilot && $fm->pilot->karyawan ? ('Nama: ' . $fm->pilot->karyawan->nama_karyawan . '\nLisensi: ' . $fm->pilot->lisensi_pilot . '\nRating: ' . $fm->pilot->rating_pesawat) : 'N/A' }}')" title="{{ $fm->pilot && $fm->pilot->karyawan ? $fm->pilot->karyawan->nama_karyawan : 'N/A' }}">
                            {{ $fm->pilot && $fm->pilot->karyawan ? Str::limit($fm->pilot->karyawan->nama_karyawan, 20) : 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Rute', '{{ $fm->rute }}', '{{ addslashes($fm->rute ?? 'Tidak ada rute') }}')" title="{{ $fm->rute }}">
                            {{ Str::limit($fm->rute ?? 'N/A', 30) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors" onclick="showPreview('Jam Terbang', '{{ $fm->jam_terbang }} jam', '{{ $fm->jam_terbang }} jam')">{{ $fm->jam_terbang }} jam</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('flight-movement', {{ $fm->id_flight_movement }})" class="px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('flight-movement', {{ $fm->id_flight_movement }})" class="px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
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
        {{ $flightMovements->links() }}
    </div>
</div>
