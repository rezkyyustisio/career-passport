<?php
namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Models\JobPosting;
use App\Services\EmployabilityEngineService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UpaDashboardController extends Controller
{
    public function index(): View
    {
        $totalEvaluated = StudentProfile::whereNotNull('employability_index')->count();
        $avgScore = StudentProfile::avg('employability_index') ?? 0;
        $highReadinessCount = StudentProfile::where('employability_index', '>=', 80)->count();
        $totalJobs = JobPosting::count();
        $profiles = StudentProfile::with('student')->latest()->paginate(10);

        return view('dashboard.upa', compact('totalEvaluated', 'avgScore', 'highReadinessCount', 'totalJobs', 'profiles'));
    }

    public function processScoring($id, EmployabilityEngineService $engine): RedirectResponse
    {
        $profile = StudentProfile::with('student')->findOrFail($id);
        $result = $engine->calculateScore($profile);
        $profile->update([
            'employability_index' => $result['score'],
            'readiness_status' => $result['status']
        ]);
        return redirect()->back()->with('success', "Employability Index diperbarui: {$result['score']}");
    }
}
