<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_open_form(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    public function test_form_validations(): void
    {
        $response = $this->post('/admin/login', [
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'O campo email é obrigatório.',
                'password' => 'O campo senha é obrigatório.'
            ]);

        $response = $this->post('/admin/login', [
            'email' => '123',
            'password' => '123'
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'Essas informações não correspondem aos nossos registros. Por favor, verifique e tente novamente.'
            ]);
    }

    public function test_login_successful(): void
    {
        User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('123123')
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@admin.com',
            'password' => '123123'
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/admin/main');
    }
}
