<?php

namespace Tests\Unit\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\UserService;
use App\Services\OrderService;
use App\Models\Order;


class OrderServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_order_create()
    {
        $userService = new UserService();
        $data = make('App\User');
        $user = $userService->register($data);

        $orderService = new OrderService();
        $result = $orderService->create(['user_id' => $user->id]);
        $this->assertEquals($user->id, $result->user_id);
    }

    public function test_only_one_order_with_status_draft_for_one_user_exists()
    {
        $userService = new UserService();
        $data = make('App\User');
        $user = $userService->register($data);

        $products = \App\Models\Product::all()->take(3)->toArray();

        $orderService = new OrderService();
        for ($i = 0; $i < 2; $i++) {
            $orderService->getOrderWithStatusDraft($user->id, $products[1]['id']);
        }

        $count = $user->orders()->where(['user_id' => $user->id, 'status' => 'draft'])->count();

        $this->assertEquals(1, $count);
    }

    public function test_add_item()
    {
        $userService = new UserService();
        $user = make('App\User');
        $user = $userService->register($user);

        $products = \App\Models\Product::all()->take(3)->toArray();

        $orderService = new OrderService();
        $orderService->getOrderWithStatusDraft($user->id, $products[0]['id']);

        $order_id = Order::byUser($user->id)->byStatus(Order::STATUS_DRAFT)->value('id');

        $this->assertDatabaseHas('order_items', ['order_id' => $order_id, 'product_id' => $products[0]['id'], 'qty' => 1]);

        $orderService->getOrderWithStatusDraft($user->id, $products[0]['id']);
        $this->assertDatabaseHas('order_items', ['order_id' => $order_id, 'product_id' => $products[0]['id'], 'qty' => 2]);

        for ($i = 0; $i < 10; $i++) {
            $orderService->getOrderWithStatusDraft($user->id, $products[1]['id']);
        }
        $this->assertDatabaseHas('order_items', ['order_id' => $order_id, 'product_id' => $products[1]['id'], 'qty' => 10]);
    }

    public function test_order_total_updated_properly()
    {
        $userService = new UserService();
        $user = make('App\User');
        $user = $userService->register($user);

        $products = \App\Models\Product::all()->take(3)->toArray();

        $orderService = new OrderService();

        for ($i = 0; $i < 10; $i++) {
            $orderService->getOrderWithStatusDraft($user->id, $products[2]['id']);
        }

        $total = $products[2]['price'] * 10;

        $this->assertDatabaseHas('orders', ['user_id' => $user->id, 'total' => $total, 'status' => 'draft']);
    }

    public function test_order_number_exists()
    {
        $orderNumber = Order::first()->value('number');

        $orderService = new OrderService();
        $result = $orderService->orderNumberExists($orderNumber);
        $this->assertTrue($result);
    }

    public function test_order_status_changes_from_draft_to_new()
    {
        $order = Order::orderBy('id', 'desc')->first();

        $orderService = new OrderService();
        $result = $orderService->changeOrderStatusFromDraftToNew($order->id);
        $this->assertTrue($result);
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'new']);
    }

    public function test_order_with_status_new_can_not_be_edited()
    {
        $order = Order::where(['status' => 'draft'])->first();

        $service = new OrderService();
        $service->changeOrderStatusFromDraftToNew($order->id);
        $result = $service->addItemToOrder($order->id, 1);
        $this->assertFalse($result);
    }
}
