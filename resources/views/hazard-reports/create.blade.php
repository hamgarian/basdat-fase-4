<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-50">
                Tambah Laporan Hazard
            </h2>
            <p class="text-sm text-slate-400">Catat hazard baru untuk tindak lanjut tim keselamatan.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-slate-950 border border-slate-800 p-6 shadow-2xl">
                <form method="POST" action="{{ route('hazard-reports.store') }}" class="space-y-6" id="hazard-form">
                    @csrf

                    <div>
                        <label for="id_karyawan" class="block text-sm font-medium text-slate-200">Karyawan</label>
                        <select
                            id="id_karyawan"
                            name="id_karyawan"
                            class="mt-1 block w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach ($karyawan as $item)
                                <option
                                    value="{{ $item->id_karyawan }}"
                                    data-nama="{{ $item->nama_karyawan }}"
                                    @selected(old('id_karyawan') == $item->id_karyawan)
                                >
                                    {{ $item->nama_karyawan }} @if($item->jabatan) ({{ $item->jabatan }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('id_karyawan')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_pelapor" class="block text-sm font-medium text-slate-200">
                            Nama Pelapor
                            <span class="text-xs font-normal text-slate-400">(otomatis dari karyawan, tetap bisa disunting)</span>
                        </label>
                        <input
                            id="nama_pelapor"
                            name="nama_pelapor"
                            type="text"
                            value="{{ old('nama_pelapor') }}"
                            class="mt-1 block w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Nama pelapor"
                        />
                            @error('nama_pelapor')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="tanggal_laporan" class="block text-sm font-medium text-slate-200">Tanggal Laporan</label>
                            <input
                                id="tanggal_laporan"
                                name="tanggal_laporan"
                                type="date"
                                value="{{ old('tanggal_laporan') }}"
                                class="mt-1 block w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            />
                            @error('tanggal_laporan')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kategori" class="block text-sm font-medium text-slate-200">Kategori</label>
                            <select
                                id="kategori"
                                name="kategori"
                                class="mt-1 block w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                                <option value="">-- Pilih Kategori --</option>
                                @foreach (['FOD', 'Maintenance', 'Wildlife', 'Ground Handling', 'Documentation'] as $kategori)
                                    <option value="{{ $kategori }}" @selected(old('kategori') === $kategori)>
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-slate-200">Deskripsi</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Detailkan kronologi, lokasi, dan rekomendasi awal..."
                            required
                        >{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-slate-200">Status</span>
                        <div class="mt-1 inline-flex items-center gap-2 rounded-md bg-amber-500/20 border border-amber-500/30 px-3 py-2 text-sm text-amber-300">
                            <span class="font-semibold uppercase">Open</span>
                            <span class="text-xs text-amber-200">Status awal laporan baru.</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('hazard-reports.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200">
                            Batal
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Simpan Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('id_karyawan');
            const input = document.getElementById('nama_pelapor');
            if (!select || !input) {
                return;
            }

            const setName = () => {
                const option = select.options[select.selectedIndex];
                if (option && option.dataset.nama && !input.value.trim()) {
                    input.value = option.dataset.nama;
                }
            };

            select.addEventListener('change', setName);

            if (!input.value.trim()) {
                setName();
            }
        });
    </script>
</x-app-layout>

