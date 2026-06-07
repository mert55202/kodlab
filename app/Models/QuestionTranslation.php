<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionTranslation extends Model
{
    protected $fillable = ['question_id', 'locale', 'question_text', 'options', 'explanation'];

    protected $casts = ['options' => 'array'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
