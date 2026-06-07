<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'payment_plan_id', 'status', 'billing_type', 'starts_at', 'ends_at', 'trial_ends_at', 'stripe_subscription_id', 'stripe_customer_id'];

    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime', 'trial_ends_at' => 'datetime'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(PaymentPlan::class, 'payment_plan_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
