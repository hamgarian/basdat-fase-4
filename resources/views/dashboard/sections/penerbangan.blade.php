<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Penerbangan</h3>
        <button onclick="showCreateForm('penerbangan')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto md:overflow-hidden">
        <table class="w-full divide-y divide-slate-800 md:table-auto">
            <thead class="bg-slate-900">
                <tr>
                    <th class="w-20 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Pesawat</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Tanggal</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Jenis</th>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Status</th>
                    <th class="w-32 px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($penerbangan as $p)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-4 py-3 text-sm text-slate-300">#{{ $p->id_penerbangan }}</td>
                        <td class="px-4 py-3 text-sm text-slate-200 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Pesawat', '{{ $p->pesawat ? ($p->pesawat->registrasi . ' (' . $p->pesawat->merk_model . ')') : 'N/A' }}', '{{ $p->pesawat ? ('Registrasi: ' . $p->pesawat->registrasi . '\nMerk/Model: ' . $p->pesawat->merk_model . '\nClient: ' . ($p->pesawat->client->nama_perusahaan ?? 'N/A')) : 'N/A' }}')" title="{{ $p->pesawat ? ($p->pesawat->registrasi . ' (' . $p->pesawat->merk_model . ')') : 'N/A' }}">
                            @if($p->pesawat)
                                {{ Str::limit($p->pesawat->registrasi . ' (' . $p->pesawat->merk_model . ')', 40) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors" onclick="showPreview('Tanggal Penerbangan', '{{ $p->tanggal_penerbangan?->format('d M Y') }}', '{{ $p->tanggal_penerbangan?->format('d F Y') }}')">{{ $p->tanggal_penerbangan?->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Jenis Penerbangan', '{{ $p->jenis_penerbangan }}', '{{ $p->jenis_penerbangan }}')" title="{{ $p->jenis_penerbangan }}">
                            {{ Str::limit($p->jenis_penerbangan ?? 'N/A', 20) }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-slate-700/50 text-slate-300">
                                {{ $p->status_penerbangan }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('penerbangan', {{ $p->id_penerbangan }})" class="px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('penerbangan', {{ $p->id_penerbangan }})" class="px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
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
        {{ $penerbangan->links() }}
    </div>
</div>
