<?php

namespace Tests\Feature;

use Corals\Modules\Utility\SEO\Facades\SEOItems;
use Corals\Modules\Utility\SEO\Models\SEOItem;
use Corals\Settings\Facades\Modules;
use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UtilitySEOTest extends TestCase
{
    use DatabaseTransactions;

    protected $seo;
    protected $seoRequest;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $user = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'superuser');
        })->first();
        Auth::loginUsingId($user->id);
    }

    public function test_utility_seo_store()
    {
        $seo_items = ['seo1', 'seo2', 'seo3', 'seo4'];
        $seo_item = array_rand($seo_items);
        $routes =SEOItems::getRouteManager();
        $this->seoRequest = [
            'slug' => $seo_items[$seo_item],
            'route' => array_rand($routes),
            'title'=> $seo_items[$seo_item]
        ];
        $response = $this->post('utilities/seo-items', $this->seoRequest);
        
        $this->seo = SEOItem::query()->where([
            ['slug', $this->seoRequest['slug']],
            ['route', $this->seoRequest['route']],
            ['title', $this->seoRequest['title']],
        ])->first();
        
        $response->assertDontSee('The given data was invalid')
            ->assertRedirect('utilities/seo-items');

        $this->assertDatabaseHas('utilities_seo_items', [
            'slug' => $this->seo->slug,
            'route' => $this->seo->route,
            'title'=> $this->seo->title
        ]);
    }

    public function test_utility_seo_edit()
    {
        $this->test_utility_seo_store();

        if ($this->seo) {
            $response = $this->get('utilities/seo-items/' . $this->seo->hashed_id . '/edit');

            $response->assertViewIs('utility-seo::seo_item.create_edit')->assertStatus(200);
        }
        $this->assertTrue(true);
    }

    public function test_utility_seo_update()
    {
        $this->test_utility_seo_store();

        if ($this->seo) {
            $routes =SEOItems::getRouteManager();
            $route = array_rand($routes);
            $response = $this->put('utilities/seo-items/' . $this->seo->hashed_id, [
                'slug' => $this->seo->slug,
                'route' => $route,
                'title'=> $this->seo->title,
            ]);

            $response->assertRedirect('utilities/seo-items');
            $this->assertDatabaseHas('utilities_seo_items', [
                'slug' => $this->seo->slug,
                'route' => $route,
                'title'=> $this->seo->title,
            ]);
        }
        $this->assertTrue(true);
    }

    public function test_utility_seo_delete()
    {
        $this->test_utility_seo_store();

        if ($this->seo) {
            $response = $this->delete('utilities/seo-items/' . $this->seo->hashed_id);

            $response->assertStatus(200)->assertSeeText($this->seo->getIdentifier().' has been deleted successfully.');

            $this->isSoftDeletableModel(SEOItem::class);
            $this->assertDatabaseMissing('utilities_seo_items', [
                'slug' => $this->seo->slug,
                'route' => $this->seo->route,
                'title'=> $this->seo->title ]);
        }
        $this->assertTrue(true);
    }
}
