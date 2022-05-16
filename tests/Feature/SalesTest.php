<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ShipmentCost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_sales_page_without_login()
    {
        $response = $this->get(route('coffee.sales'));

        $response->assertStatus(302);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_sales_page_with_login()
    {
        $user = User::factory(['email'=>'sales@coffee.shop'],1)->create();
        $this->actingAs($user);
        $response = $this->get(route('coffee.sales'));
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_shipment_page_without_login()
    {
        $response = $this->get(route('shipping.partners'));
        $response->assertStatus(302);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_shipment_page_with_login()
    {
        $user = User::factory(['email'=>'sales@coffee.shop'],1)->create();
        $this->actingAs($user);
        $response = $this->get(route('shipping.partners'));
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_sales_page_with_login_create_new_missing_params()
    {
        $user = User::factory(['email'=>'sales@coffee.shop'],1)->create();
        $product = Product::factory()->create([
            'slug' => 'gold_coffee',
            'label' => 'Gold coffee',
            'profit_margin' => 0.25
        ]);
        $this->actingAs($user);
        $response = $this->post(route('store.sales'),['product_id' => $product->id]);
        $this->assertDatabaseCount('shipment_costs', 0);
        $response->assertStatus(302);
    }

    public function test_sales_page_with_login_create_new_passed()
    {
        $user = User::factory(['email'=>'sales@coffee.shop'],1)->create();
        $product = Product::factory()->create([
            'slug' => 'gold_coffee',
            'label' => 'Gold coffee',
            'profit_margin' => 0.25
        ]);
        ShipmentCost::factory()->create([
            'cost' => 10,
            'active' => 1
        ]);
        $this->actingAs($user);
        $response = $this->post(route('store.sales'),['product_id' => $product->id,'quantity'=>1,'unit_cost'=>10]);
        //added
        $this->assertDatabaseCount('sales', 1);
        $response->assertStatus(302);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_shipment_page_with_login_create_new()
    {
        $user = User::factory(['email'=>'sales@coffee.shop'],1)->create();
        $this->actingAs($user);
        $response = $this->post(route('store.shipment'),['cost'=>10]);
        $this->assertDatabaseHas('shipment_costs', [
            'cost' => 10
        ]);
        $response->assertStatus(302);
    }
}
