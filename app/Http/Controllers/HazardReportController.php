<?php

namespace App\Http\Controllers;

use App\Models\HazardReport;
use App\Models\Karyawan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HazardReportController extends Controller
{
    public function index(): View
    {
        $reports = HazardReport::with('karyawan')
            ->orderByDesc('tanggal_laporan')
            ->paginate(10);

        return view('hazard-reports.index', compact('reports'));
    }

    public function create(): View
    {
        $karyawan = Karyawan::orderBy('nama_karyawan')->get();

        return view('hazard-reports.create', compact('karyawan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_karyawan' => ['required', 'integer', 'exists:karyawan,id_karyawan'],
            'nama_pelapor' => ['nullable', 'string', 'max:255'],
            'tanggal_laporan' => ['required', 'date'],
            'kategori' => ['required', 'in:FOD,Maintenance,Wildlife,Ground Handling,Documentation'],
            'deskripsi' => ['required', 'string'],
        ]);

        $karyawan = Karyawan::findOrFail((int) $validated['id_karyawan']);
        $validated['nama_pelapor'] = $validated['nama_pelapor'] ?: $karyawan->nama_karyawan;
        $validated['status'] = 'Open';
        $validated['id_karyawan'] = (int) $validated['id_karyawan'];

        HazardReport::create($validated);

        return redirect()
            ->route('hazard-reports.index')
            ->with('success', 'Hazard report created successfully.');
    }

    public function edit(HazardReport $hazardReport): View
    {
        $karyawan = Karyawan::orderBy('nama_karyawan')->get();

        return view('hazard-reports.edit', [
            'hazardReport' => $hazardReport,
            'karyawan' => $karyawan,
        ]);
    }

    public function update(Request $request, HazardReport $hazardReport): RedirectResponse
    {
        $validated = $request->validate([
            'id_karyawan' => ['required', 'integer', 'exists:karyawan,id_karyawan'],
            'nama_pelapor' => ['nullable', 'string', 'max:255'],
            'tanggal_laporan' => ['required', 'date'],
            'kategori' => ['required', 'in:FOD,Maintenance,Wildlife,Ground Handling,Documentation'],
            'deskripsi' => ['required', 'string'],
            'status' => ['required', 'in:Open,Investigated,Closed'],
        ]);

        $karyawan = Karyawan::findOrFail((int) $validated['id_karyawan']);
        $validated['nama_pelapor'] = $validated['nama_pelapor'] ?: $karyawan->nama_karyawan;
        $validated['id_karyawan'] = (int) $validated['id_karyawan'];

        $hazardReport->update($validated);

        return redirect()
            ->route('hazard-reports.index')
            ->with('success', 'Hazard report updated successfully.');
    }

    public function destroy(HazardReport $hazardReport): RedirectResponse
    {
        $hazardReport->delete();

        return redirect()
            ->route('hazard-reports.index')
            ->with('success', 'Hazard report deleted successfully.');
    }
}
