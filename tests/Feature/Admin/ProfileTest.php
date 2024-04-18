<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    public function test_open_form(): void
    {
        $response = $this->get('/admin/profile');

        $response->assertStatus(200);
    }

    public function test_form_profile_validations(): void
    {
        $response = $this->post('/admin/profile/save');

        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'user.name' => 'O campo nome é obrigatório.',
                'user.email' => 'O campo e-mail é obrigatório.'
            ]);

        $otherUser = User::factory()->create();
        $response = $this->post('/admin/profile/save', [
            'user' => [
                'name' => $otherUser->name,
                'email' => $otherUser->email,
            ]
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'user.email' => 'O campo e-mail já está sendo utilizado.'
            ]);
    }

    public function test_form_profile_save(): void
    {
        $response = $this->post('/admin/profile/save', [
            'user' => [
                'name' => 'Foo bar',
                'email' => $this->admin->email
            ]
        ]);

        $response->assertStatus(302)
            ->assertSessionHas([
                'toast_notification.message' => 'Perfil atualizado.',
                'toast_notification.level' => 'info'
            ]);
    }

    public function test_form_password_validations(): void
    {
        $response = $this->post('admin/profile/changePassword');

        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'old_password' => 'O campo senha atual é obrigatório.',
                'password' => 'O campo senha é obrigatório.'
            ]);

        $response = $this->post('admin/profile/changePassword', [
            'old_password' => 'password',
            'password' => 'password',
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'password' => 'O campo senha de confirmação não confere.',
                'password' => 'Os campos senha e senha atual devem ser diferentes.',
            ]);
    }

    public function test_form_password_save(): void
    {
        $response = $this->post('admin/profile/changePassword', [
            'old_password' => 'password',
            'password' => 'password1',
            'password_confirmation' => 'password1',
        ]);

        $response->assertStatus(302)
            ->assertSessionHas([
                'toast_notification.message' => 'Senha alterada.',
                'toast_notification.level' => 'info'
            ]);
    }
}
