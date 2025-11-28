<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-slate-50">
                Perbarui Laporan Hazard
            </h2>
            <p class="text-sm text-slate-400">Sesuaikan info laporan dan ubah status investigasi.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-slate-950 border border-slate-800 p-6 shadow-2xl">
                <form
                    method="POST"
                    action="{{ route('hazard-reports.update', $hazardReport) }}"
                    class="space-y-6"
                    id="hazard-form"
                >
                    @csrf
                    @method('PUT')

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
                                    @selected(old('id_karyawan', $hazardReport->id_karyawan) == $item->id_karyawan)
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
                            value="{{ old('nama_pelapor', $hazardReport->nama_pelapor) }}"
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
                                value="{{ old('tanggal_laporan', optional($hazardReport->tanggal_laporan)->format('Y-m-d')) }}"
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
                                @foreach (['FOD', 'Maintenance', 'Wildlife', 'Ground Handling', 'Documentation'] as $kategori)
                                    <option value="{{ $kategori }}" @selected(old('kategori', $hazardReport->kategori) === $kategori)>
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
                            required
                        >{{ old('deskripsi', $hazardReport->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-200">Status</label>
                        <select
                            id="status"
                            name="status"
                            class="mt-1 block w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                            @foreach (['Open', 'Investigated', 'Closed'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $hazardReport->status) === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-slate-400">
                            Dibuat {{ $hazardReport->created_at?->diffForHumans() }},
                            terakhir diperbarui {{ $hazardReport->updated_at?->diffForHumans() }}.
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('hazard-reports.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200">
                                Batal
                            </a>
                            <button
                                type="submit"
                                class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                Simpan Perubahan
                            </button>
                        </div>
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

            const initialPelapor = String(@js(old('nama_pelapor', $hazardReport->nama_pelapor))).trim();

            const setName = () => {
                const option = select.options[select.selectedIndex];
                if (option && option.dataset.nama && input.value.trim() === initialPelapor) {
                    input.value = option.dataset.nama;
                }
            };

            select.addEventListener('change', setName);
        });
    </script>
</x-app-layout>

