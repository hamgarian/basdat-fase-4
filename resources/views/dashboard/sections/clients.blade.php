<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-100">Clients</h3>
        <button onclick="showCreateForm('client')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
            + Tambah Baru
        </button>
    </div>
    
    <div class="w-full overflow-x-auto md:overflow-hidden">
        <table class="w-full divide-y divide-slate-800 md:table-auto">
            <thead class="bg-slate-900">
                <tr>
                    <th class="w-32 sm:w-auto px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Nama Perusahaan</th>
                    <th class="w-28 sm:w-40 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Contact Person</th>
                    <th class="w-24 sm:w-32 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400">Telepon</th>
                    <th class="min-w-0 px-2 sm:px-4 py-3 text-left text-xs font-semibold uppercase text-slate-400" style="max-width: 200px;">Alamat</th>
                    <th class="w-28 sm:w-32 px-2 sm:px-4 py-3 text-right text-xs font-semibold uppercase text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($clients as $client)
                    <tr class="hover:bg-slate-900/50">
                        <td class="px-2 sm:px-4 py-3 text-sm font-medium text-slate-200 cursor-pointer hover:text-blue-400 transition-colors truncate max-w-0" onclick="showPreview('Nama Perusahaan', '{{ $client->nama_perusahaan }}', '{{ addslashes($client->nama_perusahaan ?? 'Tidak ada nama') }}')" title="{{ $client->nama_perusahaan }}">
                            {{ Str::limit($client->nama_perusahaan, 20) }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate max-w-0" onclick="showPreview('Contact Person', '{{ $client->contact_person }}', '{{ addslashes($client->contact_person ?? 'Tidak ada contact person') }}')" title="{{ $client->contact_person }}">
                            {{ Str::limit($client->contact_person ?? 'N/A', 15) }}
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors whitespace-nowrap" onclick="showPreview('Nomor Telepon', '{{ $client->nomor_telepon }}', '{{ $client->nomor_telepon }}')">{{ $client->nomor_telepon }}</td>
                        <td class="px-2 sm:px-4 py-3 text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate min-w-0" style="max-width: 200px;" onclick="showPreview('Alamat', '{{ Str::limit($client->alamat, 100) }}', '{{ addslashes($client->alamat ?? 'Tidak ada alamat') }}')">
                            <div class="truncate" title="{{ $client->alamat }}">
                                {{ Str::limit($client->alamat, 25) }}
                            </div>
                        </td>
                        <td class="px-2 sm:px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1 sm:gap-2">
                                <button onclick="event.stopPropagation(); showEditForm('client', {{ $client->id_client }})" class="px-2 sm:px-3 py-1 text-xs bg-blue-600/20 text-blue-300 rounded hover:bg-blue-600/30">Edit</button>
                                <button onclick="event.stopPropagation(); showDeleteConfirm('client', {{ $client->id_client }})" class="px-2 sm:px-3 py-1 text-xs bg-red-600/20 text-red-300 rounded hover:bg-red-600/30">Hapus</button>
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
        {{ $clients->links() }}
    </div>
</div>
