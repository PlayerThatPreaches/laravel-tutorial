<?php

namespace Tests\Feature;
use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;



class UsersModuleTest extends TestCase
{

       use RefreshDatabase;
    /** @test*/
    function it_shows_the_users_list()
    {
        factory(User::class)->create([
            'name' => 'Joel',
        ]);

        factory(User::class)->create([
            'name' => 'Ellie',
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('Joel')
            ->assertSee('Ellie');
    }
 /** @test */
   function it_shows_a_default_message_if_the_users_list_is_empty()
    {
        $this->get('/usuarios')
             ->assertStatus(200)
             ->assertSee('No hay usuarios registrados.');
    }


    /** @test */
   function it_displays_the_users_details()

    {
        $user = factory(User::class)->create([
            'name' => 'Charlie Mendoza'
        ]);
        $this->get('/usuarios/'.$user->id)
             ->assertStatus(200)
             ->assertSee('Charlie Mendoza');
    }
 /** @test*/
   function it_displays_a_404_error_if_the_user_is_not_found()
     {
     $this->get('/usuarios/999')
          ->assertStatus(404)
          ->assertSee('Pagina no encontrada');
    }

/** @test*/
   function it_loads__the_new_users_page()
 {
     $this->get('/usuarios/nuevo')
          ->assertStatus(200)
          ->assertSee('Crear nuevo usuario');
 }

/** @test*/
   function it_creates_a_new_user()
    {
        $this->withoutExceptionHandling();

        $this->post('/usuarios/',[
            'name' => 'Charlie',
            'email' => 'deulios@gmail.net',
            'password' => '123456'
        ])->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Charlie',
            'email' => 'deulios@gmail.net',
            'password' => '123456',
        ]);
    }
/** @test*/
     function the_name_is_required()
  {
        $this->from('usuarios/nuevo')->post('/usuarios/', [
            'email' => 'deulios@gmail.net',
            'password' => '123456'
        ])->assertRedirect('usuarios/nuevo')
          ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

        $this->assertEquals(0, User::count());
        // $this->assertDataBaseMissing('users', ['email' => 'deulios.net']);

 }
}
