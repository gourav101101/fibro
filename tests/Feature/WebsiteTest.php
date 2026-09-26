<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    private function enquiry(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Website Review', 'email' => 'review@example.test',
            'company' => 'Test Company', 'type' => 'project', 'material' => 'Fabric to membrane',
            'message' => 'Please discuss a waterproof textile construction.',
            'locale' => 'en', 'consent' => '1', 'website' => '',
        ], $overrides);
    }

    public function test_homepage_contains_content_before_javascript_runs(): void
    {
        $this->get('/')->assertOk()->assertSee('Technical fabrics.')->assertSee('From first idea')
            ->assertSee('csrf-token')->assertSee('/build/assets/')->assertDontSee('/_next/');
    }

    public function test_enquiry_is_persisted_with_material_and_language(): void
    {
        $this->postJson('/enquiries', $this->enquiry(['locale' => 'fr', 'type' => 'sample']))->assertCreated();
        $this->assertDatabaseHas('enquiries', ['email' => 'review@example.test', 'type' => 'sample', 'locale' => 'fr', 'material' => 'Fabric to membrane']);
        $this->assertDatabaseCount('enquiries', 1);
    }

    public function test_invalid_details_and_missing_consent_are_not_saved(): void
    {
        $this->postJson('/enquiries', $this->enquiry(['email' => 'invalid', 'message' => 'short', 'consent' => '0']))
            ->assertUnprocessable()->assertJsonValidationErrors(['email', 'message', 'consent']);
        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_unknown_locale_type_and_oversized_message_are_rejected(): void
    {
        $this->postJson('/enquiries', $this->enquiry(['locale' => 'xx', 'type' => 'admin', 'message' => str_repeat('a', 5001)]))
            ->assertUnprocessable()->assertJsonValidationErrors(['locale', 'type', 'message']);
        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_honeypot_submission_is_not_stored(): void
    {
        $this->postJson('/enquiries', $this->enquiry(['website' => 'spam.example']))->assertUnprocessable();
        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_submission_rate_is_limited(): void
    {
        for ($i = 0; $i < 5; $i++) $this->postJson('/enquiries', $this->enquiry())->assertCreated();
        $this->postJson('/enquiries', $this->enquiry())->assertStatus(429);
        $this->assertDatabaseCount('enquiries', 5);
    }

    public function test_enquiries_are_not_exposed_on_a_public_read_route(): void
    {
        $this->getJson('/enquiries')->assertStatus(405);
    }
}
