<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Pesawat</h3>
        <button onclick="showCreateForm('pesawat')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto md:overflow-hidden">
        <table class="w-full divide-y divide-slate-800 md:table-auto">
            <thead class="bg-slate-900">
                <tr>
                    <th class="w-32 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Registrasi</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Merk/Model</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Client</th>
                    <th class="w-24 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Tahun</th>
                    <th class="w-28 px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Status</th>
                    <th class="w-32 px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($pesawat as $p)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-4 py-3 text-sm font-medium text-slate-200 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Registrasi Pesawat', '{{ $p->registrasi }}', '{{ $p->registrasi }}')" title="{{ $p->registrasi }}">
                            {{ Str::limit($p->registrasi, 20) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Merk/Model', '{{ $p->merk_model }}', '{{ addslashes($p->merk_model ?? 'Tidak ada informasi') }}')" title="{{ $p->merk_model }}">
                            {{ Str::limit($p->merk_model, 30) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Client', '{{ $p->client->nama_perusahaan ?? 'N/A' }}', '{{ $p->client ? ('Nama: ' . $p->client->nama_perusahaan . '\nContact: ' . ($p->client->contact_person ?? 'N/A') . '\nTelepon: ' . ($p->client->nomor_telepon ?? 'N/A')) : 'N/A' }}')" title="{{ $p->client->nama_perusahaan ?? 'N/A' }}">
                            {{ Str::limit($p->client->nama_perusahaan ?? 'N/A', 30) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors" onclick="showPreview('Tahun Pembuatan', '{{ $p->tahun_pembuatan }}', '{{ $p->tahun_pembuatan }}')">{{ $p->tahun_pembuatan }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $p->status === 'Aktif' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-700/50 text-slate-300' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('pesawat', {{ $p->id_pesawat }})" class="px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('pesawat', {{ $p->id_pesawat }})" class="px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
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
        {{ $pesawat->links() }}
    </div>
</div>
