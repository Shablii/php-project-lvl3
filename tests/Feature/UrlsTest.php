<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Urls;
use App\Models\UrlChecks;
use Illuminate\Support\Facades\DB;

class UrlsTest extends TestCase
{
    public int $id;
    public function setUp(): void
    {
        parent::setUp();
        $data = ['name' => 'https://google.com.ua'];
        $this->id = DB::table('urls')->insertGetId($data);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('urls.create'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('urls.create'));
        $response->assertOk();
    }

    public function testShow(): void
    {
        $response = $this->get(route('urls.show', $this->id));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $factoryData = Urls::factory()->make()->toArray();
        $name = \Arr::only($factoryData, ['name']);

        $response = $this->post(route('urls.store'), ['url' => $name]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $url = parse_url($name['name']);
        $this->assertDatabaseHas('urls', ['name' => $url['scheme'] . "://" . $url['host']]);
    }

    public function testHome(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();
    }
}
