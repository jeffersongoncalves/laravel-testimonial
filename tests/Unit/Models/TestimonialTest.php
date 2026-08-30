<?php

use JeffersonGoncalves\Testimonial\Models\Testimonial;

it('stores and retrieves translated content per locale', function () {
    $testimonial = Testimonial::factory()->create([
        'content' => ['en' => 'Great service!', 'pt_BR' => 'Ótimo serviço!'],
    ]);

    expect($testimonial->getTranslation('content', 'en'))->toBe('Great service!')
        ->and($testimonial->getTranslation('content', 'pt_BR'))->toBe('Ótimo serviço!');
});

it('falls back to the fallback locale when a translation is missing', function () {
    config(['app.fallback_locale' => 'en']);

    $testimonial = Testimonial::factory()->create([
        'content' => ['en' => 'Great service!'],
    ]);

    expect($testimonial->getTranslation('content', 'pt_BR'))->toBe('Great service!');
});

it('does not translate name, role, or company', function () {
    $testimonial = Testimonial::factory()->create([
        'name' => 'John Doe',
        'role' => 'CEO',
        'company' => 'Acme Inc.',
    ]);

    expect($testimonial->name)->toBe('John Doe')
        ->and($testimonial->role)->toBe('CEO')
        ->and($testimonial->company)->toBe('Acme Inc.');
});

it('casts rating, order, and is_active correctly', function () {
    $testimonial = Testimonial::factory()->create([
        'rating' => 5,
        'order' => 3,
        'is_active' => true,
    ]);

    expect($testimonial->rating)->toBeInt()->toBe(5)
        ->and($testimonial->order)->toBeInt()->toBe(3)
        ->and($testimonial->is_active)->toBeBool()->toBeTrue();
});

it('allows role, company, avatar, and rating to be nullable', function () {
    $testimonial = Testimonial::factory()->create([
        'role' => null,
        'company' => null,
        'avatar' => null,
        'rating' => null,
    ]);

    expect($testimonial->role)->toBeNull()
        ->and($testimonial->company)->toBeNull()
        ->and($testimonial->avatar)->toBeNull()
        ->and($testimonial->rating)->toBeNull();
});

it('scopes active testimonials', function () {
    Testimonial::factory()->create(['is_active' => true]);
    Testimonial::factory()->inactive()->create();

    expect(Testimonial::active()->count())->toBe(1);
});

it('scopes testimonials ordered by the order column', function () {
    $second = Testimonial::factory()->create(['order' => 2]);
    $first = Testimonial::factory()->create(['order' => 1]);

    expect(Testimonial::ordered()->pluck('id')->all())->toBe([$first->id, $second->id]);
});
