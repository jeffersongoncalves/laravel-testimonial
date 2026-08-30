<?php

namespace JeffersonGoncalves\Testimonial\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Testimonial\Database\Factories\TestimonialFactory;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $name
 * @property string|null $role
 * @property string|null $company
 * @property string|null $avatar
 * @property array<string, string> $content
 * @property int|null $rating
 * @property int $order
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Testimonial extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'content',
    ];

    protected $fillable = [
        'name',
        'role',
        'company',
        'avatar',
        'content',
        'rating',
        'order',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'integer',
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getTable(): string
    {
        return config('testimonial.table_names.testimonials', parent::getTable());
    }

    protected static function newFactory(): TestimonialFactory
    {
        return TestimonialFactory::new();
    }

    /** @param Builder<static> $query */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /** @param Builder<static> $query */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }
}
