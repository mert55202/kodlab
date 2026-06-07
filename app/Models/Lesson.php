<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'slug', 'content', 'video_url', 'source_ref', 'source_note', 'code_example', 'order', 'is_free', 'is_published', 'estimated_minutes'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(LessonTranslation::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function codeExercises(): HasMany
    {
        return $this->hasMany(CodeExercise::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
