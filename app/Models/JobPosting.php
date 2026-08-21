<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name', 'job_title', 'required_field',
        'min_employability_index', 'required_skills'
    ];
    protected $casts = [
        'required_skills' => 'array',
        'min_employability_index' => 'float',
    ];
}
