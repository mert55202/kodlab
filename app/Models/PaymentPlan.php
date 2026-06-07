<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentPlan extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'price_monthly', 'price_yearly', 'currency', 'features', 'is_popular', 'is_active', 'order'];

    protected $casts = ['features' => 'array', 'is_popular' => 'boolean', 'is_active' => 'boolean'];

    public function getPriceAttribute()
    {
        return $this->price_monthly;
    }

    public function getIntervalAttribute()
    {
        return 'monthly';
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'payment_plan_id');
    }
}
