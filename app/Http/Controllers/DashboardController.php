<?php

namespace App\Http\Controllers;

use App\Models\HazardReport;
use App\Models\Karyawan;
use App\Models\Client;
use App\Models\Pesawat;
use App\Models\Penerbangan;
use App\Models\Pilot;
use App\Models\Incident;
use App\Models\Investigation;
use App\Models\Audit;
use App\Models\Temuan;
use App\Models\LibraryManual;
use App\Models\FlightMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $action = $request->get('action', 'overview'); // overview, create, edit, safety-reports
        $hazardReport = null;
        $section = $request->get('section', 'hazard-reports'); // untuk safety-reports section
        
        // Jika action adalah safety-reports, load semua data
        if ($action === 'safety-reports') {
            return $this->safetyReports($request, $section);
        }
        
        // Optimize: Get all counts in fewer queries using raw SQL
        $hazardReportStats = HazardReport::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = \'Open\' THEN 1 ELSE 0 END) as open,
            SUM(CASE WHEN status = \'Investigated\' THEN 1 ELSE 0 END) as investigated,
            SUM(CASE WHEN status = \'Closed\' THEN 1 ELSE 0 END) as closed
        ')->first();
        
        $totalReports = $hazardReportStats->total;
        $openReports = $hazardReportStats->open;
        $investigatedReports = $hazardReportStats->investigated;
        $closedReports = $hazardReportStats->closed;
        
        // Optimize: Get pesawat and pilot counts in single queries
        $pesawatStats = Pesawat::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = \'Aktif\' THEN 1 ELSE 0 END) as active
        ')->first();
        
        $pilotStats = Pilot::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = \'Aktif\' THEN 1 ELSE 0 END) as active
        ')->first();
        
        // System-wide statistics - Cache for 5 minutes (300 seconds)
        $totalKaryawan = Cache::remember('stats:karyawan:total', 300, fn() => Karyawan::count());
        $totalClients = Cache::remember('stats:clients:total', 300, fn() => Client::count());
        $totalPesawat = $pesawatStats->total;
        $activePesawat = $pesawatStats->active;
        $totalPilots = $pilotStats->total;
        $activePilots = $pilotStats->active;
        
        // Statistics for other entities - Cache for 5 minutes
        $totalIncidents = Cache::remember('stats:incidents:total', 300, fn() => Incident::count());
        $totalInvestigations = Cache::remember('stats:investigations:total', 300, fn() => Investigation::count());
        $totalAudits = Cache::remember('stats:audits:total', 300, fn() => Audit::count());
        $totalTemuan = Cache::remember('stats:temuan:total', 300, fn() => Temuan::count());
        $totalLibraryManuals = Cache::remember('stats:library_manuals:total', 300, fn() => LibraryManual::count());
        $totalPenerbangan = Cache::remember('stats:penerbangan:total', 300, fn() => Penerbangan::count());
        $totalFlightMovements = Cache::remember('stats:flight_movements:total', 300, fn() => FlightMovement::count());
        
        // Recent activity (last 5 entries from each entity)
        $recentIncidents = Incident::with('penerbangan.pesawat')->orderByDesc('id_incident')->limit(5)->get();
        $recentInvestigations = Investigation::with('hazardReport')->orderByDesc('tanggal_mulai')->limit(5)->get();
        $recentAudits = Audit::with('karyawan')->orderByDesc('tanggal_pelaksanaan')->limit(5)->get();
        $recentPenerbangan = Penerbangan::with('pesawat.client')->orderByDesc('tanggal_penerbangan')->limit(5)->get();
        
        // Performance metrics
        $mostActiveReporter = HazardReport::select('id_karyawan', DB::raw('COUNT(*) as count'))
            ->groupBy('id_karyawan')
            ->orderByDesc('count')
            ->with('karyawan')
            ->first();
        
        $recentHazardReports = HazardReport::where('tanggal_laporan', '>=', now()->subDays(7))->count();
        $recentIncidentsCount = Incident::orderByDesc('id_incident')->limit(10)->count();

        // Data untuk chart - trend bulanan (6 bulan terakhir)
        $monthlyTrend = HazardReport::select(
            DB::raw("DATE_TRUNC('month', tanggal_laporan) as month"),
            DB::raw('COUNT(*) as count')
        )
            ->where('tanggal_laporan', '>=', now()->subMonths(6))
            ->groupBy(DB::raw("DATE_TRUNC('month', tanggal_laporan)"))
            ->orderBy('month')
            ->get();

        // Data untuk chart - distribusi status
        $statusDistribution = [
            'Open' => $openReports,
            'Investigated' => $investigatedReports,
            'Closed' => $closedReports,
        ];

        // Data untuk chart - distribusi kategori
        $categoryDistribution = HazardReport::select('kategori', DB::raw('COUNT(*) as count'))
            ->groupBy('kategori')
            ->get()
            ->pluck('count', 'kategori')
            ->toArray();

        // Data untuk chart - reports per hari (7 hari terakhir)
        $dailyReports = HazardReport::select(
            DB::raw("DATE(tanggal_laporan) as date"),
            DB::raw('COUNT(*) as count')
        )
            ->where('tanggal_laporan', '>=', now()->subDays(7))
            ->groupBy(DB::raw("DATE(tanggal_laporan)"))
            ->orderBy('date')
            ->get();

        // Recent reports (untuk tabel di dashboard)
        $recentReports = HazardReport::with('karyawan')
            ->orderByDesc('tanggal_laporan')
            ->paginate(10);

        // Reports by kategori untuk table
        $reportsByCategory = HazardReport::select('kategori', DB::raw('COUNT(*) as count'))
            ->groupBy('kategori')
            ->orderByDesc('count')
            ->get();

        // Data untuk modals dropdowns - NOT needed for overview, only set empty arrays
        $karyawan = collect();
        $allClients = collect();
        $allPesawat = collect();
        $allPenerbangan = collect();
        $allPilots = collect();
        $allAudits = collect();
        $allHazardReports = collect();

        return view('dashboard', compact(
            'action',
            'section',
            'totalReports',
            'openReports',
            'investigatedReports',
            'closedReports',
            'totalKaryawan',
            'totalClients',
            'totalPesawat',
            'activePesawat',
            'totalPilots',
            'activePilots',
            'totalIncidents',
            'totalInvestigations',
            'totalAudits',
            'totalTemuan',
            'totalLibraryManuals',
            'totalPenerbangan',
            'totalFlightMovements',
            'recentIncidents',
            'recentInvestigations',
            'recentAudits',
            'recentPenerbangan',
            'mostActiveReporter',
            'recentHazardReports',
            'recentIncidentsCount',
            'monthlyTrend',
            'statusDistribution',
            'categoryDistribution',
            'dailyReports',
            'recentReports',
            'reportsByCategory',
            'karyawan',
            'allClients',
            'allPesawat',
            'allPenerbangan',
            'allPilots',
            'allAudits',
            'allHazardReports'
        ));
    }

    public function storeReport(Request $request): RedirectResponse
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
        
        // Clear cache when hazard report is created
        $this->clearHazardReportCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'hazard-reports'])
            ->with('success', 'Hazard report created successfully.');
    }

    public function editReport(HazardReport $hazardReport): RedirectResponse
    {
        return redirect()->route('dashboard', ['action' => 'edit', 'id' => $hazardReport->id_hazard]);
    }

    public function updateReport(Request $request, HazardReport $hazardReport): RedirectResponse
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
        
        // Clear cache when hazard report is updated
        $this->clearHazardReportCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'hazard-reports'])
            ->with('success', 'Hazard report updated successfully.');
    }

    public function destroyReport(HazardReport $hazardReport): RedirectResponse
    {
        $hazardReport->delete();
        
        // Clear cache when hazard report is deleted
        $this->clearHazardReportCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'hazard-reports'])
            ->with('success', 'Hazard report deleted successfully.');
    }

    private function safetyReports(Request $request, string $section): View
    {
        $action = 'safety-reports'; // Set action untuk safety-reports section
        
        // Optimize: Only load data for the active section
        $hazardReports = $section === 'hazard-reports' 
            ? HazardReport::with('karyawan', 'investigation')->orderByDesc('tanggal_laporan')->paginate(10, ['*'], 'hazard_page')
            : collect();
            
        $incidents = $section === 'incidents' 
            ? Incident::with('penerbangan.pesawat')->orderByDesc('id_incident')->paginate(10, ['*'], 'incident_page')
            : collect();
            
        $investigations = $section === 'investigations' 
            ? Investigation::with('hazardReport.karyawan')->orderByDesc('tanggal_mulai')->paginate(10, ['*'], 'investigation_page')
            : collect();
            
        $audits = $section === 'audits' 
            ? Audit::with('karyawan', 'temuan')->orderByDesc('tanggal_pelaksanaan')->paginate(10, ['*'], 'audit_page')
            : collect();
            
        $temuan = $section === 'temuan' 
            ? Temuan::with('audit')->orderByDesc('id_temuan')->paginate(10, ['*'], 'temuan_page')
            : collect();
            
        $libraryManuals = $section === 'library-manuals' 
            ? LibraryManual::with('karyawan')->orderByDesc('tanggal_terbit')->paginate(10, ['*'], 'manual_page')
            : collect();
            
        $penerbangan = $section === 'penerbangan' 
            ? Penerbangan::with('pesawat.client', 'incidents', 'flightMovements.pilot.karyawan')->orderByDesc('tanggal_penerbangan')->paginate(10, ['*'], 'penerbangan_page')
            : collect();
            
        $flightMovements = $section === 'flight-movements' 
            ? FlightMovement::with('penerbangan.pesawat', 'pilot.karyawan')->orderByDesc('tanggal_penerbangan')->paginate(10, ['*'], 'flight_page')
            : collect();
            
        $pesawat = $section === 'pesawat' 
            ? Pesawat::with('client', 'helicopter', 'privateJet')->orderBy('registrasi')->paginate(10, ['*'], 'pesawat_page')
            : collect();
            
        $pilots = $section === 'pilots' 
            ? Pilot::with('karyawan')->orderBy('lisensi_pilot')->paginate(10, ['*'], 'pilot_page')
            : collect();
            
        $clients = $section === 'clients' 
            ? Client::with('pesawat')->orderBy('nama_perusahaan')->paginate(10, ['*'], 'client_page')
            : collect();
        
        // Optimize: Load dropdown data with only necessary fields
        $karyawan = Karyawan::select('id_karyawan', 'nama_karyawan')->orderBy('nama_karyawan')->get();
        $allClients = Client::select('id_client', 'nama_perusahaan')->orderBy('nama_perusahaan')->get();
        $allPesawat = Pesawat::select('id_pesawat', 'id_client', 'registrasi', 'merk_model')
            ->with('client:id_client,nama_perusahaan')
            ->orderBy('registrasi')
            ->get();
        $allPenerbangan = Penerbangan::select('id_penerbangan', 'id_pesawat', 'tanggal_penerbangan', 'jenis_penerbangan')
            ->with('pesawat:id_pesawat,registrasi,merk_model')
            ->orderByDesc('tanggal_penerbangan')
            ->get();
        $allPilots = Pilot::select('id_pilot', 'id_karyawan', 'lisensi_pilot')
            ->with('karyawan:id_karyawan,nama_karyawan')
            ->orderBy('lisensi_pilot')
            ->get();
        $allAudits = Audit::select('id_audit', 'id_karyawan', 'nomor_audit', 'judul', 'tanggal_pelaksanaan')
            ->with('karyawan:id_karyawan,nama_karyawan')
            ->orderByDesc('tanggal_pelaksanaan')
            ->get();
        $allHazardReports = HazardReport::select('id_hazard', 'tanggal_laporan', 'kategori', 'deskripsi')
            ->orderByDesc('tanggal_laporan')
            ->get();

        return view('dashboard', compact(
            'action',
            'section',
            'hazardReports',
            'incidents',
            'investigations',
            'audits',
            'temuan',
            'libraryManuals',
            'penerbangan',
            'flightMovements',
            'pesawat',
            'pilots',
            'clients',
            'karyawan',
            'allClients',
            'allPesawat',
            'allPenerbangan',
            'allPilots',
            'allAudits',
            'allHazardReports'
        ));
    }

    // ========== INCIDENTS CRUD ==========
    public function storeIncident(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_penerbangan' => ['required', 'integer', 'exists:penerbangan,id_penerbangan'],
            'kategori_insiden' => ['required', 'string', 'max:100'],
            'lokasi_insiden' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        Incident::create($validated);
        $this->clearIncidentCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'incidents'])
            ->with('success', 'Incident created successfully.');
    }

    public function updateIncident(Request $request, Incident $incident): RedirectResponse
    {
        $validated = $request->validate([
            'id_penerbangan' => ['required', 'integer', 'exists:penerbangan,id_penerbangan'],
            'kategori_insiden' => ['required', 'string', 'max:100'],
            'lokasi_insiden' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $incident->update($validated);
        $this->clearIncidentCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'incidents'])
            ->with('success', 'Incident updated successfully.');
    }

    public function destroyIncident(Incident $incident): RedirectResponse
    {
        $incident->delete();
        $this->clearIncidentCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'incidents'])
            ->with('success', 'Incident deleted successfully.');
    }

    // ========== INVESTIGATIONS CRUD ==========
    public function storeInvestigation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_hazard' => ['required', 'integer', 'exists:hazard_report,id_hazard'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'teknologi' => ['nullable', 'string', 'max:255'],
            'hasil_wawancara' => ['nullable', 'text'],
        ]);

        Investigation::create($validated);
        $this->clearInvestigationCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'investigations'])
            ->with('success', 'Investigation created successfully.');
    }

    public function updateInvestigation(Request $request, Investigation $investigation): RedirectResponse
    {
        $validated = $request->validate([
            'id_hazard' => ['required', 'integer', 'exists:hazard_report,id_hazard'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'teknologi' => ['nullable', 'string', 'max:255'],
            'hasil_wawancara' => ['nullable', 'text'],
        ]);

        $investigation->update($validated);
        $this->clearInvestigationCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'investigations'])
            ->with('success', 'Investigation updated successfully.');
    }

    public function destroyInvestigation(Investigation $investigation): RedirectResponse
    {
        $investigation->delete();
        $this->clearInvestigationCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'investigations'])
            ->with('success', 'Investigation deleted successfully.');
    }

    // ========== AUDITS CRUD ==========
    public function storeAudit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_karyawan' => ['required', 'integer', 'exists:karyawan,id_karyawan'],
            'nomor_audit' => ['required', 'string', 'max:50'],
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'tanggal_pelaksanaan' => ['required', 'date'],
            'keterangan' => ['nullable', 'text'],
        ]);

        Audit::create($validated);
        $this->clearAuditCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'audits'])
            ->with('success', 'Audit created successfully.');
    }

    public function updateAudit(Request $request, Audit $audit): RedirectResponse
    {
        $validated = $request->validate([
            'id_karyawan' => ['required', 'integer', 'exists:karyawan,id_karyawan'],
            'nomor_audit' => ['required', 'string', 'max:50'],
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'tanggal_pelaksanaan' => ['required', 'date'],
            'keterangan' => ['nullable', 'text'],
        ]);

        $audit->update($validated);
        $this->clearAuditCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'audits'])
            ->with('success', 'Audit updated successfully.');
    }

    public function destroyAudit(Audit $audit): RedirectResponse
    {
        $audit->delete();
        $this->clearAuditCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'audits'])
            ->with('success', 'Audit deleted successfully.');
    }

    // ========== TEMUAN CRUD ==========
    public function storeTemuan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_audit' => ['required', 'integer', 'exists:audit,id_audit'],
            'deskripsi_temuan' => ['required', 'string'],
            'rekomendasi' => ['nullable', 'string'],
            'status_tindak_lanjut' => ['required', 'string', 'max:50'],
        ]);

        Temuan::create($validated);
        $this->clearTemuanCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'temuan'])
            ->with('success', 'Temuan created successfully.');
    }

    public function updateTemuan(Request $request, Temuan $temuan): RedirectResponse
    {
        $validated = $request->validate([
            'id_audit' => ['required', 'integer', 'exists:audit,id_audit'],
            'deskripsi_temuan' => ['required', 'text'],
            'rekomendasi' => ['nullable', 'text'],
            'status_tindak_lanjut' => ['required', 'string', 'max:50'],
        ]);

        $temuan->update($validated);
        $this->clearTemuanCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'temuan'])
            ->with('success', 'Temuan updated successfully.');
    }

    public function destroyTemuan(Temuan $temuan): RedirectResponse
    {
        $temuan->delete();
        $this->clearTemuanCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'temuan'])
            ->with('success', 'Temuan deleted successfully.');
    }

    // ========== LIBRARY MANUALS CRUD ==========
    public function storeLibraryManual(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_karyawan' => ['required', 'integer', 'exists:karyawan,id_karyawan'],
            'judul_manual' => ['required', 'string', 'max:255'],
            'tanggal_terbit' => ['required', 'date'],
            'departemen_pemilik' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        LibraryManual::create($validated);
        $this->clearLibraryManualCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'library-manuals'])
            ->with('success', 'Library manual created successfully.');
    }

    public function updateLibraryManual(Request $request, LibraryManual $libraryManual): RedirectResponse
    {
        $validated = $request->validate([
            'id_karyawan' => ['required', 'integer', 'exists:karyawan,id_karyawan'],
            'judul_manual' => ['required', 'string', 'max:255'],
            'tanggal_terbit' => ['required', 'date'],
            'departemen_pemilik' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $libraryManual->update($validated);
        $this->clearLibraryManualCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'library-manuals'])
            ->with('success', 'Library manual updated successfully.');
    }

    public function destroyLibraryManual(LibraryManual $libraryManual): RedirectResponse
    {
        $libraryManual->delete();
        $this->clearLibraryManualCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'library-manuals'])
            ->with('success', 'Library manual deleted successfully.');
    }

    // ========== PENERBANGAN CRUD ==========
    public function storePenerbangan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_pesawat' => ['required', 'integer', 'exists:pesawat,id_pesawat'],
            'tanggal_penerbangan' => ['required', 'date'],
            'jenis_penerbangan' => ['required', 'string', 'max:100'],
            'status_penerbangan' => ['required', 'string', 'max:50'],
            'catatan' => ['nullable', 'text'],
        ]);

        Penerbangan::create($validated);
        $this->clearPenerbanganCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'penerbangan'])
            ->with('success', 'Penerbangan created successfully.');
    }

    public function updatePenerbangan(Request $request, Penerbangan $penerbangan): RedirectResponse
    {
        $validated = $request->validate([
            'id_pesawat' => ['required', 'integer', 'exists:pesawat,id_pesawat'],
            'tanggal_penerbangan' => ['required', 'date'],
            'jenis_penerbangan' => ['required', 'string', 'max:100'],
            'status_penerbangan' => ['required', 'string', 'max:50'],
            'catatan' => ['nullable', 'text'],
        ]);

        $penerbangan->update($validated);
        $this->clearPenerbanganCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'penerbangan'])
            ->with('success', 'Penerbangan updated successfully.');
    }

    public function destroyPenerbangan(Penerbangan $penerbangan): RedirectResponse
    {
        $penerbangan->delete();
        $this->clearPenerbanganCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'penerbangan'])
            ->with('success', 'Penerbangan deleted successfully.');
    }

    // ========== FLIGHT MOVEMENTS CRUD ==========
    public function storeFlightMovement(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_penerbangan' => ['required', 'integer', 'exists:penerbangan,id_penerbangan'],
            'id_pilot' => ['required', 'integer', 'exists:pilot,id_pilot'],
            'tanggal_penerbangan' => ['required', 'date'],
            'rute' => ['required', 'string', 'max:255'],
            'jam_terbang' => ['required', 'numeric', 'min:0'],
        ]);

        FlightMovement::create($validated);
        $this->clearFlightMovementCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'flight-movements'])
            ->with('success', 'Flight movement created successfully.');
    }

    public function updateFlightMovement(Request $request, FlightMovement $flightMovement): RedirectResponse
    {
        $validated = $request->validate([
            'id_penerbangan' => ['required', 'integer', 'exists:penerbangan,id_penerbangan'],
            'id_pilot' => ['required', 'integer', 'exists:pilot,id_pilot'],
            'tanggal_penerbangan' => ['required', 'date'],
            'rute' => ['required', 'string', 'max:255'],
            'jam_terbang' => ['required', 'numeric', 'min:0'],
        ]);

        $flightMovement->update($validated);
        $this->clearFlightMovementCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'flight-movements'])
            ->with('success', 'Flight movement updated successfully.');
    }

    public function destroyFlightMovement(FlightMovement $flightMovement): RedirectResponse
    {
        $flightMovement->delete();
        $this->clearFlightMovementCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'flight-movements'])
            ->with('success', 'Flight movement deleted successfully.');
    }

    // ========== PESAWAT CRUD ==========
    public function storePesawat(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_client' => ['required', 'integer', 'exists:client,id_client'],
            'registrasi' => ['required', 'string', 'max:50', 'unique:pesawat,registrasi'],
            'merk_model' => ['required', 'string', 'max:255'],
            'tahun_pembuatan' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'jam_terbang' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $pesawat = Pesawat::create($validated);

        // Handle helicopter/private jet if needed
        if ($request->has('tipe_mesin')) {
            $pesawat->helicopter()->create(['tipe_mesin' => $request->tipe_mesin]);
        } elseif ($request->has('kapasitas_penumpang') || $request->has('jangkauan_terbang')) {
            $pesawat->privateJet()->create([
                'kapasitas_penumpang' => $request->kapasitas_penumpang,
                'jangkauan_terbang' => $request->jangkauan_terbang,
            ]);
        }
        
        $this->clearPesawatCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'pesawat'])
            ->with('success', 'Pesawat created successfully.');
    }

    public function updatePesawat(Request $request, Pesawat $pesawat): RedirectResponse
    {
        $validated = $request->validate([
            'id_client' => ['required', 'integer', 'exists:client,id_client'],
            'registrasi' => ['required', 'string', 'max:50', 'unique:pesawat,registrasi,' . $pesawat->id_pesawat . ',id_pesawat'],
            'merk_model' => ['required', 'string', 'max:255'],
            'tahun_pembuatan' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'jam_terbang' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $pesawat->update($validated);
        $this->clearPesawatCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'pesawat'])
            ->with('success', 'Pesawat updated successfully.');
    }

    public function destroyPesawat(Pesawat $pesawat): RedirectResponse
    {
        $pesawat->delete();
        $this->clearPesawatCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'pesawat'])
            ->with('success', 'Pesawat deleted successfully.');
    }

    // ========== PILOTS CRUD ==========
    public function storePilot(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_karyawan' => ['required', 'integer', 'exists:karyawan,id_karyawan', 'unique:pilot,id_karyawan'],
            'lisensi_pilot' => ['required', 'string', 'max:50'],
            'jam_terbang_total' => ['required', 'numeric', 'min:0'],
            'rating_pesawat' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        Pilot::create($validated);
        $this->clearPilotCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'pilots'])
            ->with('success', 'Pilot created successfully.');
    }

    public function updatePilot(Request $request, Pilot $pilot): RedirectResponse
    {
        $validated = $request->validate([
            'id_karyawan' => ['required', 'integer', 'exists:karyawan,id_karyawan', 'unique:pilot,id_karyawan,' . $pilot->id_pilot . ',id_pilot'],
            'lisensi_pilot' => ['required', 'string', 'max:50'],
            'jam_terbang_total' => ['required', 'numeric', 'min:0'],
            'rating_pesawat' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $pilot->update($validated);
        $this->clearPilotCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'pilots'])
            ->with('success', 'Pilot updated successfully.');
    }

    public function destroyPilot(Pilot $pilot): RedirectResponse
    {
        $pilot->delete();
        $this->clearPilotCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'pilots'])
            ->with('success', 'Pilot deleted successfully.');
    }

    // ========== CLIENTS CRUD ==========
    public function storeClient(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:100'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'text'],
        ]);

        Client::create($validated);
        $this->clearClientCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'clients'])
            ->with('success', 'Client created successfully.');
    }

    public function updateClient(Request $request, Client $client): RedirectResponse
    {
        $validated = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:100'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'text'],
        ]);

        $client->update($validated);
        $this->clearClientCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'clients'])
            ->with('success', 'Client updated successfully.');
    }

    public function destroyClient(Client $client): RedirectResponse
    {
        $client->delete();
        $this->clearClientCache();

        return redirect()
            ->route('dashboard', ['action' => 'safety-reports', 'section' => 'clients'])
            ->with('success', 'Client deleted successfully.');
    }

    // ========== JSON DATA FOR EDIT FORMS ==========
    public function getEditData(Request $request, string $type, int $id)
    {
        try {
            $data = null;
            switch ($type) {
                case 'hazard-reports':
                    $data = HazardReport::findOrFail($id);
                    break;
                case 'incidents':
                    $data = Incident::findOrFail($id);
                    break;
                case 'investigations':
                    $data = Investigation::findOrFail($id);
                    break;
                case 'audits':
                    $data = Audit::findOrFail($id);
                    break;
                case 'temuan':
                    $data = Temuan::findOrFail($id);
                    break;
                case 'library-manuals':
                    $data = LibraryManual::findOrFail($id);
                    break;
                case 'penerbangan':
                    $data = Penerbangan::findOrFail($id);
                    break;
                case 'flight-movements':
                    $data = FlightMovement::findOrFail($id);
                    break;
                case 'pesawat':
                    $data = Pesawat::findOrFail($id);
                    break;
                case 'pilots':
                    $data = Pilot::findOrFail($id);
                    break;
                case 'clients':
                    $data = Client::findOrFail($id);
                    break;
                default:
                    return response()->json(['error' => 'Invalid type'], 400);
            }
            
            return response()->json($data->toArray());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data not found'], 404);
        }
    }

    // ========== CACHE MANAGEMENT HELPERS ==========
    private function clearHazardReportCache(): void
    {
        // No specific cache keys for hazard reports as they are always fetched fresh
        // This method exists for consistency and future cache implementation
    }

    private function clearIncidentCache(): void
    {
        Cache::forget('stats:incidents:total');
    }

    private function clearInvestigationCache(): void
    {
        Cache::forget('stats:investigations:total');
    }

    private function clearAuditCache(): void
    {
        Cache::forget('stats:audits:total');
    }

    private function clearTemuanCache(): void
    {
        Cache::forget('stats:temuan:total');
    }

    private function clearLibraryManualCache(): void
    {
        Cache::forget('stats:library_manuals:total');
    }

    private function clearPenerbanganCache(): void
    {
        Cache::forget('stats:penerbangan:total');
    }

    private function clearFlightMovementCache(): void
    {
        Cache::forget('stats:flight_movements:total');
    }

    private function clearPesawatCache(): void
    {
        // No specific cache keys as pesawat stats are always fetched fresh
    }

    private function clearPilotCache(): void
    {
        // No specific cache keys as pilot stats are always fetched fresh
    }

    private function clearClientCache(): void
    {
        Cache::forget('stats:clients:total');
    }
}
