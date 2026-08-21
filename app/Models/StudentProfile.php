<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'certifications_count', 'organization_score',
        'portfolio_score', 'soft_skills_score', 'skills',
        'employability_index', 'readiness_status'
    ];
    protected $casts = [
        'skills' => 'array',
        'employability_index' => 'float',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
