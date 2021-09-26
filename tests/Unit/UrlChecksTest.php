<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Urls;
use App\Models\UrlChecks;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UrlChecksTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testChecks(): void
    {
        $data = Urls::factory()->create();
        $fakeHtml = file_get_contents(__DIR__ . "/../fixtures/fake.html");

        $name = DB::table('urls')->where('id', '=', $data->id)->value('name');

        Http::fake([
            $name => Http::response($fakeHtml, 200)
        ]);

        $response = $this->post(route('check', ['id' => $data->id]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', [
            'url_id' => $data->id,
            'status_code' => '200',
            'h1' => 'This is H1',
            'keywords' => 'There are Keywords',
            'description' => 'This is Description'
        ]);
    }
}
