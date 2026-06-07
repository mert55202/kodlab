<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodeExercise extends Model
{
    protected $fillable = ['lesson_id', 'title', 'description', 'initial_code', 'solution_code', 'language', 'order'];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
