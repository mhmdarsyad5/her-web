<?php

use App\Models\Lead;

test('a user can submit a lead form successfully', function () {
    $payload = [
        'name' => 'John Doe',
        'company_name' => 'Acme Corp',
        'email' => 'john@acme.com',
        'whatsapp_number' => '081234567890',
        'industri' => 'logistics',
        'kota' => 'Jakarta',
        'berat' => 2000,
        'tinggi' => 4.5,
        'recommended_products' => [
            ['name' => 'Forklift Diesel 3 Ton', 'slug' => 'forklift-diesel-3-ton'],
        ],
    ];

    $response = $this->postJson(route('dss.submit-lead'), $payload);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Data prospek berhasil disimpan.',
        ]);

    $this->assertDatabaseHas('leads', [
        'name' => 'John Doe',
        'company_name' => 'Acme Corp',
        'email' => 'john@acme.com',
        'whatsapp_number' => '081234567890',
        'industry' => 'logistics',
        'location' => 'Jakarta',
        'requested_load_capacity' => 2000,
        'requested_lift_height' => 4.5,
    ]);

    $lead = Lead::first();
    expect($lead->recommended_products)->toBeArray()
        ->and($lead->recommended_products[0]['name'])->toBe('Forklift Diesel 3 Ton');
});

test('lead submission requires name, email, whatsapp, industri, and kota', function () {
    $response = $this->postJson(route('dss.submit-lead'), []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'email', 'whatsapp_number', 'industri', 'kota']);
});
