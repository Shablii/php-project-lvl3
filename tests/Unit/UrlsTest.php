<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Urls;
use App\Models\UrlChecks;

class UrlsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        \Artisan::call('migrate');
    }

    public function testIndex(): void
    {
        $response = $this->get(route('urls.create'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->get(route('urls.create'));
        $response->assertOk();
    }

    public function testShow()
    {
        $factoryData = Urls::factory()->create();
        $factoryData->save();

        $response = $this->get(route('urls.show', ['url' => $factoryData->id]));
        $response->assertOk();
    }

    public function testStore()
    {
        $factoryData = Urls::factory()->make()->toArray();
        $name = \Arr::only($factoryData, ['name']);

        $response = $this->post(route('urls.store'), ['url' => $name]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('urls', $name);
    }

    public function testHome()
    {
        $response = $this->get(route('home'));
        $response->assertOk();
    }
}
