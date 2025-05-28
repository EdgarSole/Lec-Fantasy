<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('pruebasUnitarias')]
    public function it_creates_a_user()
    {
        $user = User::factory()->create([
            'nombre' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678')
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    #[Test]
    public function it_has_required_fields()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        User::create([]); // Fallará porque faltan campos requeridos
    }
}
