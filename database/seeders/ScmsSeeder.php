<?php

namespace Database\Seeders;

use App\Models\JobPosting;
use App\Models\Student;
use App\Models\StudentProfile;
use App\Services\EmployabilityEngineService;
use Illuminate\Database\Seeder;

class ScmsSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'student' => [
                    'nim' => '22110001',
                    'name' => 'Andi Pratama',
                    'study_program' => 'Teknik Informatika',
                    'ipk' => 3.75,
                ],
                'profile' => [
                    'certifications_count' => 4,
                    'organization_score' => 80,
                    'portfolio_score' => 85,
                    'soft_skills_score' => 88,
                    'skills' => ['php', 'laravel', 'mysql', 'javascript', 'git'],
                ],
            ],
            [
                'student' => [
                    'nim' => '22110002',
                    'name' => 'Siti Nurhaliza',
                    'study_program' => 'Sistem Informasi',
                    'ipk' => 3.60,
                ],
                'profile' => [
                    'certifications_count' => 3,
                    'organization_score' => 70,
                    'portfolio_score' => 75,
                    'soft_skills_score' => 80,
                    'skills' => ['analisis sistem', 'sql', 'mysql', 'excel'],
                ],
            ],
            [
                'student' => [
                    'nim' => '22110003',
                    'name' => 'Budi Santoso',
                    'study_program' => 'Manajemen',
                    'ipk' => 3.20,
                ],
                'profile' => [
                    'certifications_count' => 1,
                    'organization_score' => 55,
                    'portfolio_score' => 60,
                    'soft_skills_score' => 65,
                    'skills' => ['manajemen', 'komunikasi', 'excel'],
                ],
            ],
            [
                'student' => [
                    'nim' => '22110004',
                    'name' => 'Dewi Lestari',
                    'study_program' => 'Teknik Informatika',
                    'ipk' => 3.85,
                ],
                'profile' => [
                    'certifications_count' => 5,
                    'organization_score' => 90,
                    'portfolio_score' => 92,
                    'soft_skills_score' => 90,
                    'skills' => ['php', 'laravel', 'mysql', 'javascript', 'git', 'docker', 'react'],
                ],
            ],
            [
                'student' => [
                    'nim' => '22110005',
                    'name' => 'Rizky Ramadhan',
                    'study_program' => 'Akuntansi',
                    'ipk' => 2.95,
                ],
                'profile' => [
                    'certifications_count' => 0,
                    'organization_score' => 40,
                    'portfolio_score' => 45,
                    'soft_skills_score' => 50,
                    'skills' => ['akuntansi', 'excel', 'laporan keuangan'],
                ],
            ],
        ];

        $jobs = [
            [
                'company_name' => 'PT Teknologi Nusantara',
                'job_title' => 'Backend Developer',
                'required_field' => 'Teknik Informatika',
                'min_employability_index' => 65.00,
                'required_skills' => ['php', 'laravel', 'mysql', 'git'],
            ],
            [
                'company_name' => 'PT Solusi Digital',
                'job_title' => 'Full Stack Developer',
                'required_field' => 'Teknik Informatika',
                'min_employability_index' => 70.00,
                'required_skills' => ['php', 'javascript', 'react', 'mysql'],
            ],
            [
                'company_name' => 'PT Data Prima',
                'job_title' => 'Data Analyst',
                'required_field' => 'Sistem Informasi',
                'min_employability_index' => 60.00,
                'required_skills' => ['sql', 'excel', 'analisis sistem'],
            ],
            [
                'company_name' => 'PT Konsultan Bisnis',
                'job_title' => 'Business Analyst',
                'required_field' => 'Manajemen',
                'min_employability_index' => 55.00,
                'required_skills' => ['manajemen', 'komunikasi', 'excel'],
            ],
            [
                'company_name' => 'PT Akuntansi Jaya',
                'job_title' => 'Junior Accountant',
                'required_field' => 'Akuntansi',
                'min_employability_index' => 50.00,
                'required_skills' => ['akuntansi', 'excel', 'laporan keuangan'],
            ],
        ];

        $engine = new EmployabilityEngineService();

        foreach ($students as $data) {
            $student = Student::create($data['student']);

            $profile = StudentProfile::create([
                'student_id' => $student->id,
                ...$data['profile'],
            ]);

            $score = $engine->calculateScore($profile);
            $profile->update([
                'employability_index' => $score['score'],
                'readiness_status' => $score['status'],
            ]);
        }

        foreach ($jobs as $jobData) {
            JobPosting::create($jobData);
        }
    }
}
