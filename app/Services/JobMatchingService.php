<?php
namespace App\Services;

use App\Models\StudentProfile;
use App\Models\JobPosting;

class JobMatchingService
{
    public function matchJobsForStudent(StudentProfile $profile): array
    {
        $studentSkills = $profile->skills ?? [];
        $studentScore = $profile->employability_index ?? 0;
        $jobs = JobPosting::all();
        $recommendations = [];

        foreach ($jobs as $job) {
            $requiredSkills = $job->required_skills ?? [];
            $skillSimilarity = $this->calculateCosineSimilarity($studentSkills, $requiredSkills);
            $indexEligibility = ($studentScore >= $job->min_employability_index) ? 1.0 : ($studentScore / max($job->min_employability_index, 1));

            $finalMatchPercentage = round((($skillSimilarity * 0.7) + ($indexEligibility * 0.3)) * 100, 2);

            if ($finalMatchPercentage >= 40.0) {
                $recommendations[] = [
                    'job_id' => $job->id,
                    'company_name' => $job->company_name,
                    'job_title' => $job->job_title,
                    'required_field' => $job->required_field,
                    'match_percentage' => min($finalMatchPercentage, 100.0),
                    'matched_skills' => array_values(array_intersect(
                        array_map('strtolower', $studentSkills), array_map('strtolower', $requiredSkills)
                    ))
                ];
            }
        }
        usort($recommendations, fn($a, $b) => $b['match_percentage'] <=> $a['match_percentage']);
        return $recommendations;
    }

    private function calculateCosineSimilarity(array $vecA, array $vecB): float
    {
        $vecA = array_map('strtolower', $vecA);
        $vecB = array_map('strtolower', $vecB);
        $allTerms = array_unique(array_merge($vecA, $vecB));

        if (empty($allTerms)) return 0.0;

        $v1 = []; $v2 = [];
        foreach ($allTerms as $term) {
            $v1[] = in_array($term, $vecA) ? 1 : 0;
            $v2[] = in_array($term, $vecB) ? 1 : 0;
        }

        $dotProduct = 0.0; $normA = 0.0; $normB = 0.0;
        for ($i = 0; $i < count($allTerms); $i++) {
            $dotProduct += $v1[$i] * $v2[$i];
            $normA += $v1[$i] ** 2;
            $normB += $v2[$i] ** 2;
        }

        if ($normA == 0.0 || $normB == 0.0) return 0.0;
        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }
}
