<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['category_id', 'title', 'slug', 'description', 'icon', 'difficulty', 'order', 'is_published', 'estimated_hours'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function getTotalLessonsAttribute(): int
    {
        return $this->lessons()->count();
    }

    public function getCompletedLessonsAttribute($userId): int
    {
        return $this->lessons()->whereHas('progress', function($q) use ($userId) {
            $q->where('user_id', $userId)->where('completed', true);
        })->count();
    }
}
