<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Urls;
use App\Models\UrlChecks;
use Illuminate\Support\Facades\Http;

class UrlChecksTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        \Artisan::call('migrate');
    }

    public function testChecks()
    {
        $data = Urls::factory()->create();
        var_dump($data->name);

        Http::fake([
            $data->name => Http::response('Hello World', 200, ['Headers'])
        ]);

        $response = $this->post(route('check', ['id' => $data->id]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', ['url_id' => $data->id]);
    }
}
