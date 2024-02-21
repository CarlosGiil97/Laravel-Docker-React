<?php

use App\Services\OrderService;
use App\Models\Cart;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use Mockery\MockInterface;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;



class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();

        $cartService = new CartService();

        $this->orderService = new OrderService($cartService);
    }

    public function testGenerateOrder()
    {
        $cart = Cart::factory()->create(['done' => false]);

        $cartService = new CartService();
        $orderService = new OrderService($cartService);
        $response = $orderService->generateOrder($cart->id);

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('order', $responseData);
        $this->assertArrayHasKey('products', $responseData);

        $order = Order::findOrFail($responseData['order']['id']);
        $this->assertEquals(0, $order->paid);
        $this->assertEquals(Order::CREDIT_CARD, $order->payment_method);
    }
}
