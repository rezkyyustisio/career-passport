<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Data Akademik Mahasiswa
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('name');
            $table->string('study_program');
            $table->decimal('ipk', 3, 2);
            $table->timestamps();
        });

        // Profil Portofolio & Indeks Kesiapan Kerja
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->integer('certifications_count')->default(0);
            $table->integer('organization_score')->default(0);
            $table->integer('portfolio_score')->default(0);
            $table->integer('soft_skills_score')->default(0);
            $table->json('skills')->nullable();
            $table->decimal('employability_index', 5, 2)->nullable();
            $table->string('readiness_status')->nullable();
            $table->timestamps();
        });

        // Data Kemitraan Industri & Lowongan Kerja
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('job_title');
            $table->string('required_field');
            $table->decimal('min_employability_index', 5, 2)->default(60.00);
            $table->json('required_skills')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_postings');
        Schema::dropIfExists('student_profiles');
        Schema::dropIfExists('students');
    }
};
