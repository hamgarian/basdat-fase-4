<!-- Temuan Modal -->
<div id="modal-temuan" class="modal-container fixed inset-0 z-50" style="display: none;" onclick="if(event.target === this) closeModal('temuan')">
    <div class="modal-overlay fixed inset-0 bg-black/75"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-slate-950 border border-slate-800 rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-slate-100">Tambah Temuan</h3>
                    <button onclick="closeModal('temuan')" class="text-slate-400 hover:text-slate-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form method="POST" action="{{ route('dashboard.temuan.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Audit *</label>
                        <select name="id_audit" required class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Audit</option>
                            @foreach($allAudits ?? [] as $a)
                                <option value="{{ $a->id_audit }}">{{ $a->nomor_audit }} - {{ $a->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi Temuan *</label>
                        <textarea name="deskripsi_temuan" required rows="4" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Rekomendasi</label>
                        <textarea name="rekomendasi" rows="4" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Status Tindak Lanjut *</label>
                        <input type="text" name="status_tindak_lanjut" required maxlength="50" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="button" onclick="closeModal('temuan')" class="px-4 py-2 text-sm font-semibold text-slate-400 hover:text-slate-200">
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

