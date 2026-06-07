<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AdSetting extends Model
{
    protected $fillable = [
        'adsense_publisher_id', 'ads_enabled', 'show_in_header', 'show_in_sidebar',
        'show_in_lesson', 'show_in_quiz', 'hide_for_premium',
        'ad_slot_header', 'ad_slot_sidebar', 'ad_slot_lesson'
    ];

    protected $casts = [
        'ads_enabled' => 'boolean',
        'show_in_header' => 'boolean',
        'show_in_sidebar' => 'boolean',
        'show_in_lesson' => 'boolean',
        'show_in_quiz' => 'boolean',
        'hide_for_premium' => 'boolean',
    ];
}
