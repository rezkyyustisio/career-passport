<?php
namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Services\JobMatchingService;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentCareerPortalController extends Controller
{
    public function showPassport($studentId, JobMatchingService $matcher): View
    {
        $profile = StudentProfile::with('student')->where('student_id', $studentId)->firstOrFail();
        $jobMatches = $matcher->matchJobsForStudent($profile);
        return view('student.passport', compact('profile', 'jobMatches'));
    }

    public function downloadPdf($studentId, JobMatchingService $matcher)
    {
        $profile = StudentProfile::with('student')->where('student_id', $studentId)->firstOrFail();
        $jobMatches = $matcher->matchJobsForStudent($profile);

        $pdf = Pdf::loadView('student.passport_pdf', compact('profile', 'jobMatches'));
        $pdf->setPaper('a4', 'portrait');

        $fileName = 'Career_Passport_' . str_replace(' ', '_', $profile->student->name) . '.pdf';

        return $pdf->download($fileName);
    }
}
