<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Urls;

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
        $factoryData = Urls::factory()->make();
        $factoryData->save();
        $response = $this->get(route('urls.show', ['url' => $factoryData->id]));
        $response->assertOk();
    }

    public function testStore()
    {
        $factoryData = Urls::factory()->make()->toArray();
        $name = \Arr::only($factoryData, ['name']);
        $data = ['url' => $name];
        $response = $this->post(route('urls.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('urls', $data['url']);
    }
}
