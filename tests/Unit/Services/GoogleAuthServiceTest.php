<?php

namespace Tests\Unit\Services;

use App\Services\GoogleAuthService;
use Tests\TestCase;
use Mockery;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;

class GoogleAuthServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('pruebasUnitarias')]
    public function it_gets_user_data_from_google()
    {
        // Crear un mock del usuario que devuelve Socialite
        $socialiteUser = Mockery::mock(SocialiteUser::class);
        $socialiteUser->shouldReceive('getEmail')->andReturn('test@example.com');
        $socialiteUser->shouldReceive('getName')->andReturn('Test User');
        $socialiteUser->shouldReceive('getAvatar')->andReturn('https://avatar.test/url.jpg');

        // Crear un mock del driver de Google
        $googleDriver = Mockery::mock(\Laravel\Socialite\Contracts\Provider::class);
        $googleDriver->shouldReceive('stateless')->andReturnSelf();
        $googleDriver->shouldReceive('userFromToken')->with('fake-token')->andReturn($socialiteUser);

        // Mockear la llamada a Socialite::driver('google')
        Socialite::shouldReceive('driver')->with('google')->andReturn($googleDriver);

        // Instanciar el servicio y llamar al método a testear
        $service = new GoogleAuthService();
        $user = $service->getUserData('fake-token');

        // Comprobar que devuelve los datos esperados
        $this->assertEquals('test@example.com', $user['email']);
        $this->assertEquals('Test User', $user['nombre']);
        $this->assertEquals('https://avatar.test/url.jpg', $user['foto_url']);
    }
}
