<?php

namespace Tests\Feature;

use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UtilitySEOViewTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $user = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'superuser');
        })->first();
        Auth::loginUsingId($user->id);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_utility_seo_view()
    {
        $response = $this->get('utilities/seo-items');

        $response->assertStatus(200)->assertViewIs('utility-seo::seo_item.index');
    }

    public function test_utility_seo_create()
    {
        $response = $this->get('utilities/seo-items/create');

        $response->assertViewIs('utility-seo::seo_item.create_edit')->assertStatus(200);
    }
}
