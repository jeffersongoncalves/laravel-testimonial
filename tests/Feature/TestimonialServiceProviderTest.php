<?php

use Illuminate\Support\Facades\Schema;

it('registers the config file', function () {
    expect(config('testimonial.table_names.testimonials'))->toBe('testimonials');
});

it('registers the migrations and creates the tables', function () {
    expect(Schema::hasTable('testimonials'))->toBeTrue();
});
