<?php


namespace App\Services;


use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;


class OrderService
{
    public function findById($id)
    {
        return Order::findOrFail($id);
    }

    public function create($input)
    {
        $input['status'] = Order::STATUS_DRAFT;
        $input['number'] = self::createOrderNumber();

        try {
            $order = Order::create($input);

            return $order;
        } catch (\Exception $e) {
            throw new $e;
        }
    }

    public function getOrderWithStatusDraft($user_id, $product_id)
    {
        if (Order::byUser($user_id)->byStatus(Order::STATUS_DRAFT)->doesntExist()) {
            // create

            self::create([
                'user_id' => $user_id
            ]);
        }

        $order_id = Order::byUser($user_id)->byStatus(Order::STATUS_DRAFT)->value('id');

        try {
            $result = $this->addItemToOrder($order_id, $product_id);

            return $result;
        } catch (\Exception $e) {
            throw new $e;
        }

    }

    public function addItemToOrder($order_id, $product_id)
    {
        if ($this->findById($order_id)->status == Order::STATUS_DRAFT) {
            if (OrderItem::byOrder($order_id)->byProduct($product_id)->doesntExist()) {
                try {
                    // create

                    $item = OrderItem::create(['order_id' => $order_id, 'product_id' => $product_id]);
                    self::updateOrderTotal($order_id, $product_id);

                    return $item;
                } catch (\Exception $e) {
                    throw new $e;
                }
            }
            self::updateOrderTotal($order_id, $product_id);

            return OrderItem::byOrder($order_id)->byProduct($product_id)->increment('qty');
        }

        return false;
    }

    public function updateOrderTotal($order_id, $product_id)
    {
        $order = $this->findById($order_id);
        $productPrice = Product::where('id', $product_id)->value('price');
        try {
            return $order->increment('total', $productPrice);
        } catch (\Exception $e) {
            throw new $e;
        }
    }

    public function createOrderNumber()
    {
        $orderNumber = '';
        for ($i = 0; $i < 10; $i++) {
            $orderNumber .= rand(1, 9);
        }
        if ($this->orderNumberExists($orderNumber)) {
            $this->createOrderNumber();

            return false;
        }

        return $orderNumber;
    }

    public function orderNumberExists($orderNumber)
    {
        return Order::where('number', $orderNumber)->exists();
    }

    public function changeOrderStatusFromDraftToNew($order_id)
    {
        $order = $this->findById($order_id);

        return $order->update(['status' => 'new']);
    }

    public function getTotalItems($user)
    {
        $totalItems = null;
        $order = null;
        if ($user) {
            $order = $user->orders()->byStatus(\App\Models\Order::STATUS_DRAFT)->exists() ? auth()->user()->orders()->byStatus(\App\Models\Order::STATUS_DRAFT)->first() : null;
        }
        if ($order) {
            $totalItems = $order->orderItems()->sum('qty');
            return $totalItems;
        }
    }
}
