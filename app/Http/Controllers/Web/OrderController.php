<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function addItemToOrder(OrderService $service, Request $request)
    {
        $service->getOrderWithStatusDraft($request['user_id'], $request['product_id']);
        return redirect()->route('products.index');
    }

    public function closeOrder(OrderService $service, Request $request)
    {
        $service->changeOrderStatusFromDraftToNew($request['order_id']);
        return redirect()->route('products.index');
    }

    public static function getTotalItems()
    {
        $user = auth()->user();
        $service = new OrderService();
        $totalItems = $service->getTotalItems($user);
        return $totalItems;
    }
}
