<?php

namespace Tests\Unit;

use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    /**
     * Test User Registration Validation.
     *
     * @return void
     */
    public function test_user_registration_validation()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'invalid-email', // Invalid email format
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test User Registration.
     *
     * @return void
     */
    public function test_user_registration()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => "john@gmail.com",
            'password' => '1234',
            'password_confirmation' => '1234',
            'role_id' => 2,
            'status' => 1
        ]);

        $response->assertRedirect('/');

       // $this->assertAuthenticated();
    }
}
