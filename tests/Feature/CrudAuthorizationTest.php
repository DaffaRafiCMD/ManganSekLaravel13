<?php

namespace Tests\Feature;

use App\Models\{User, Tempat, MealHack, Review};
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CrudAuthorizationTest extends TestCase
{
    private User $user;
    private User $other;
    private User $admin;
    private Tempat $tempat;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'crud_memory',
            'database.connections.crud_memory' => [
                'driver' => 'sqlite', 'database' => ':memory:',
                'prefix' => '', 'foreign_key_constraints' => true,
            ],
            'session.driver' => 'array', 'cache.default' => 'array',
        ]);
        DB::purge('crud_memory');
        $migration = require database_path('migrations/2026_11_24_000000_create_mangansek_tables.php');
        $migration->up();
        $this->user = User::create(['nama'=>'User Demo','email'=>'one@example.test','password'=>'!','role'=>'user']);
        $this->other = User::create(['nama'=>'User Lain','email'=>'two@example.test','password'=>'!','role'=>'user']);
        $this->admin = User::create(['nama'=>'Admin Demo','email'=>'admin@example.test','password'=>'!','role'=>'admin']);
        $this->tempat = Tempat::create(['nama'=>'Warung Uji','kategori'=>'makanan','jenis'=>'Warung']);
    }

    public function test_user_can_post_meal_hack_but_cannot_edit_or_delete_even_own_post(): void
    {
        $data = ['judul'=>'Nasi hemat','deskripsi'=>'Beli lauk saja','hemat'=>2000];
        $this->actingAs($this->user)->post(route('meal.store'), $data)->assertRedirect();
        $hack = MealHack::where('user_id', $this->user->id)->firstOrFail();
        $this->get(route('meal.edit', $hack))->assertForbidden();
        $this->patch(route('meal.update', $hack), $data)->assertForbidden();
        $this->delete(route('meal.destroy', $hack))->assertForbidden();
        $this->assertDatabaseHas('meal_hack', ['id'=>$hack->id, 'judul'=>'Nasi hemat']);
    }

    public function test_admin_can_create_update_and_delete_any_meal_hack(): void
    {
        $hack = $this->user->mealHacks()->create(['judul'=>'Nasi hemat','deskripsi'=>'Beli lauk saja','hemat'=>2000]);
        $this->actingAs($this->admin)->post(route('meal.store'), ['judul'=>'Tips admin','deskripsi'=>'Makan bersama','hemat'=>1000])->assertRedirect();
        $this->get(route('meal.edit', $hack))->assertOk();
        $this->patch(route('meal.update', $hack), ['judul'=>'Tips baru','deskripsi'=>'Beli lauk saja','hemat'=>3000])->assertRedirect();
        $this->assertDatabaseHas('meal_hack', ['id'=>$hack->id, 'judul'=>'Tips baru']);
        $this->delete(route('meal.destroy', $hack))->assertRedirect();
        $this->assertDatabaseMissing('meal_hack', ['id'=>$hack->id]);
    }

    public function test_user_manages_only_own_review(): void
    {
        $otherReview = $this->tempat->reviews()->create(['user_id'=>$this->other->id,'rating'=>4,'komentar'=>'Ulasan lain']);
        $data = ['rating'=>5,'komentar'=>'Ulasan sendiri'];
        $this->actingAs($this->user)->post(route('review.store', $this->tempat), $data)->assertRedirect();
        $own = Review::where('user_id', $this->user->id)->firstOrFail();
        $this->get(route('review.index', [$this->tempat, 'edit'=>$otherReview->id]))->assertForbidden();
        $this->patch(route('review.update', $otherReview), $data)->assertForbidden();
        $this->delete(route('review.destroy', $otherReview))->assertForbidden();
        $this->patch(route('review.update', $own), ['rating'=>3,'komentar'=>'Diperbarui'])->assertRedirect();
        $this->assertDatabaseHas('review', ['id'=>$own->id, 'rating'=>3]);
        $this->delete(route('review.destroy', $own))->assertRedirect();
        $this->assertDatabaseMissing('review', ['id'=>$own->id]);
        $this->assertDatabaseHas('review', ['id'=>$otherReview->id, 'komentar'=>'Ulasan lain']);
    }

    public function test_admin_manages_all_reviews(): void
    {
        $review = $this->tempat->reviews()->create(['user_id'=>$this->other->id,'rating'=>4,'komentar'=>'Ulasan lain']);
        $this->actingAs($this->admin)->post(route('review.store', $this->tempat), ['rating'=>5,'komentar'=>'Ulasan admin'])->assertRedirect();
        $this->get(route('review.index', [$this->tempat, 'edit'=>$review->id]))->assertOk();
        $this->patch(route('review.update', $review), ['rating'=>3,'komentar'=>'Diperbarui admin'])->assertRedirect();
        $this->assertDatabaseHas('review', ['id'=>$review->id, 'user_id'=>$this->other->id, 'rating'=>3]);
        $this->delete(route('review.destroy', $review))->assertRedirect();
        $this->assertDatabaseMissing('review', ['id'=>$review->id]);
    }

    public function test_user_cannot_manage_menu_or_promo(): void
    {
        $promo = \App\Models\Promo::create(['judul'=>'Promo uji','warna'=>'yellow','nama_tempat'=>'Warung uji','kategori'=>'makanan','deskripsi'=>'Diskon demo','syarat'=>'','berlaku_sampai'=>'2027-01-01']);
        $this->actingAs($this->user);
        $this->get(route('menu.create'))->assertForbidden();
        $this->post(route('menu.store'), [])->assertForbidden();
        $this->get(route('menu.edit', $this->tempat))->assertForbidden();
        $this->patch(route('menu.update', $this->tempat), [])->assertForbidden();
        $this->delete(route('menu.destroy', $this->tempat))->assertForbidden();
        $this->get(route('promo.create'))->assertForbidden();
        $this->post(route('promo.store'), [])->assertForbidden();
        $this->get(route('promo.edit', $promo))->assertForbidden();
        $this->patch(route('promo.update', $promo), [])->assertForbidden();
        $this->delete(route('promo.destroy', $promo))->assertForbidden();
    }
}
