<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
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
        $name = ['name' => 'http://i.ua'];
        $response = $this->post(route('urls.store'), ['url' => $name]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('urls', $name);
    }

    public function testHome(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();
    }
}
