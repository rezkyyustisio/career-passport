<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['nim', 'name', 'study_program', 'ipk'];

    public function profile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }
}
