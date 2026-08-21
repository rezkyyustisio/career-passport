<?php
namespace App\Services;

use App\Models\StudentProfile;

class EmployabilityEngineService
{
    public function calculateScore(StudentProfile $profile): array
    {
        $student = $profile->student;

        // Distribusi Bobot
        $wIpk = 0.25; $wCert = 0.20; $wOrg = 0.15; $wPorto = 0.20; $wSoft = 0.20;

        $normalizedIpk = ($student->ipk / 4.0) * 100;
        $normalizedCert = min(($profile->certifications_count / 5) * 100, 100);

        $index = (
            ($normalizedIpk * $wIpk) + ($normalizedCert * $wCert) +
            ($profile->organization_score * $wOrg) + ($profile->portfolio_score * $wPorto) +
            ($profile->soft_skills_score * $wSoft)
        );

        $index = round($index, 2);
        $status = match (true) {
            $index >= 80 => 'High Employability',
            $index >= 65 => 'Moderate Employability',
            default => 'Needs Training / Development',
        };

        return ['score' => $index, 'status' => $status];
    }
}
