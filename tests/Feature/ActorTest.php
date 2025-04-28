<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Actor;
use App\Models\Image;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Follow;

class ActorTest extends TestCase
{
   use RefreshDatabase;

   protected function authenticate(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        return $user;
    }

  /** @test */
  public function test_actor_index_returns_successful_response()
  {
      Actor::factory()->count(3)->create();

      $response = $this->getJson('/api/actors');

      $response->assertStatus(200)
               ->assertJsonStructure([
                   '*' => [
                       'id',
                       'name',
                       'created_at',
                       'updated_at'
                   ]
               ]);
  }
  /** @test */
  public function test_guest_cannot_create_actor()
  {
      $data = ['name' => 'John Doe'];

      $response = $this->postJson('/api/actors', $data);

      $response->assertStatus(401);
  }

  /** @test */
  public function test_authenticated_user_can_create_actor()
  {
    $this->authenticate();

    $data = ['name' => 'Jane Doe'];

    $response = $this->postJson('/api/actors', $data);

    $response->assertStatus(201)
             ->assertJsonFragment(['name' => 'Jane Doe']);

    $this->assertDatabaseHas('actors', ['name' => 'Jane Doe']);
  }

  /** @test */
  public function test_authenticated_user_can_update_actor()
  {
    $this->authenticate();
        $actor = Actor::factory()->create();

        $updateData = ['name' => 'Updated Name'];

        $response = $this->putJson("/api/actors/{$actor->slug}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('actors', ['name' => 'Updated Name']);
  }

  /** @test */
  public function test_authenticated_user_can_delete_actor()
  {
    $this->authenticate();
    $actor = Actor::factory()->create();

    $response = $this->deleteJson("/api/actors/{$actor->slug}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('actors', ['id' => $actor->id]);
  }

  /** @test */
  public function test_actor_has_morph_one_image()
  {
    $actor = Actor::factory()->create();

    $image = Image::factory()->create([
        'imageable_id' => $actor->id,
        'imageable_type' => Actor::class,
        'path' => 'https://example.com/image.jpg'
    ]);

    $this->assertInstanceOf(Image::class, $actor->image);
    $this->assertEquals('https://example.com/image.jpg', $actor->image->path);
    $this->assertTrue($actor->is($image->imageable));
  }

  /** @test */
  public function test_authenticated_user_can_favorite_actor()
  {
    $this->authenticate();
    $actor = Actor::factory()->create();

    $response = $this->postJson("/api/favorites", [
        'favoritable_id' => $actor->id,
        'favoritable_type' => Actor::class
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('favorites', [
        'favoritable_id' => $actor->id,
        'favoritable_type' => Actor::class
    ]);
  }

  /** @test */
  public function test_authenticated_user_can_follow_actor()
  {
    $this->authenticate();
    $actor = Actor::factory()->create();

    $response = $this->postJson("/api/follows", [
        'followable_id' => $actor->id,
        'followable_type' => Actor::class
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('follows', [
        'followable_id' => $actor->id,
        'followable_type' => Actor::class
    ]);
  }
}
