<!-- Hazard Report Modal -->
<div id="modal-hazard-report" class="fixed inset-0 z-[9999] flex items-center justify-center" style="display: none;">
    <div class="absolute inset-0 bg-black/75" onclick="closeModal('hazard-report')"></div>
    <div class="relative z-10 w-full max-w-2xl p-4">
        <div class="bg-slate-950 border border-slate-800 rounded-xl shadow-xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-slate-100" id="modal-title-hazard-report">Tambah Hazard Report</h3>
                    <button onclick="closeModal('hazard-report')" class="text-slate-400 hover:text-slate-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form method="POST" action="{{ route('dashboard.reports.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="method-hazard-report">
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Karyawan *</label>
                        <select name="id_karyawan" required class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Karyawan</option>
                            @foreach($karyawan ?? [] as $k)
                                <option value="{{ $k->id_karyawan }}" data-nama="{{ $k->nama_karyawan }}">{{ $k->nama_karyawan }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Pelapor</label>
                        <input type="text" name="nama_pelapor" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Laporan *</label>
                        <input type="date" name="tanggal_laporan" required class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Kategori *</label>
                        <select name="kategori" required class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Kategori</option>
                            <option value="FOD">FOD</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Wildlife">Wildlife</option>
                            <option value="Ground Handling">Ground Handling</option>
                            <option value="Documentation">Documentation</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi *</label>
                        <textarea name="deskripsi" required rows="4" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div id="status-field-hazard-report" class="hidden">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Status *</label>
                        <select name="status" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Open">Open</option>
                            <option value="Investigated">Investigated</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="button" onclick="closeModal('hazard-report')" class="px-4 py-2 text-sm font-semibold text-slate-400 hover:text-slate-200">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.querySelector('#modal-hazard-report select[name="id_karyawan"]');
        const input = document.querySelector('#modal-hazard-report input[name="nama_pelapor"]');
        if (select && input) {
            select.addEventListener('change', () => {
                const option = select.options[select.selectedIndex];
                if (option && option.dataset.nama && !input.value.trim()) {
                    input.value = option.dataset.nama;
                }
            });
        }
    });
</script>
