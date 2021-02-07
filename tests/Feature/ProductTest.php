<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;
    use DatabaseMigrations;

    public function testCreate()
    {
        $productData = Product::factory()->make();
        /** @var User $user */
        $user = User::factory(['adminAccess' =>false])->create();
        $this->be($user);
        $response = $this->postJson('/api/product', $productData->getAttributes());
        $response->assertStatus(403);
        $user->adminAccess = true;
        $user->save();
        $user = User::findOrFail($user->id);
        $this->be($user);
        $response = $this->postJson('/api/product', $productData->getAttributes());
        $response->assertStatus(201);

    }

    public function testIndex()
    {
        Product::factory()->count(50)->create();
        $response = $this->getJson('/api/product');
        $response->assertStatus(200);
        $respData = $response->json();
        $this->assertEquals($respData['meta']['last_page'], 4);
    }


    public function testDestroy()
    {
        $product = Product::factory()->create();
        $user = User::factory(['adminAccess' =>true])->create();
        $this->be($user);
        $response = $this->delete('/api/product/' . $product->id);

        $response->assertStatus(200);
        $productForCheck = Product::first($product->id);
        $this->assertNull($productForCheck);
    }

    public function testEdit()
    {
        $product = Product::factory()->create();
        $user = User::factory(['adminAccess' =>true])->create();
        $this->be($user);
        $response = $this->put('/api/product/' . $product->id, ['name'=>'new name']);

        $response->assertStatus(200);
        $productForCheck = Product::findOrFail($product->id);
        $this->assertEquals('new name', $productForCheck->name);
    }

    public function testShow()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/product/' . $product->id);

        $response->assertStatus(200);
        $respData = $response->json();
        $this->assertEquals($product->id, $respData['data']['id']);
        $this->assertEquals('product', $respData['data']['type']);
        $this->assertEquals($product->name, $respData['data']['attributes']['name']);
    }
}
