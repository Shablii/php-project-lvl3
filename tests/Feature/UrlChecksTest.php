<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UrlChecksTest extends TestCase
{
    public int $id;
    public function setUp(): void
    {
        parent::setUp();
        $data = ['name' => 'https://google.com.ua'];
        $this->id = DB::table('urls')->insertGetId($data);
    }

    public function testChecks(): void
    {
        $fakeHtml = file_get_contents(__DIR__ . "/../fixtures/fake.html");

        if ($fakeHtml === false) {
            throw new \Exception('Не получилось прочитать файл');
        }

        $name = DB::table('urls')->where('id', '=', $this->id)->value('name');

        Http::fake([$name => Http::response($fakeHtml, 200)]);

        $response = $this->post(route('urls.checks.store', $this->id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', [
            'url_id' => $this->id,
            'status_code' => '200',
            'h1' => 'This is H1',
            'keywords' => 'There are Keywords',
            'description' => 'This is Description'
        ]);
    }
}
