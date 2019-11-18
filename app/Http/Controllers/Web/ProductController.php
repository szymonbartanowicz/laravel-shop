<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProductService $service
     * @return \Illuminate\Http\Response
     */

    public function index(ProductService $service)
    {
        $products = $service->index();
//        $totalItems = null;
//        $order = null;
//        if (auth()->check()) {
//            $order = auth()->user()->orders()->byStatus(\App\Models\Order::STATUS_DRAFT)->exists() ? auth()->user()->orders()->byStatus(\App\Models\Order::STATUS_DRAFT)->first() : null;
//        }
//        if ($order) {
//            $totalItems = $order->orderItems()->sum('qty');
//        }
//        return view('shop', compact(['products', 'totalItems']));
        return view('shop', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        return view('product.create');
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
//    public function store(ProductRequest $request, ProductService $service)
//    {
//        $validated = $request->validated();
//        $service->store($validated);
//        return redirect('/');
//    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param ProductService $service
     * @return \Illuminate\Http\Response
     */
    public function show($id, ProductService $service)
    {
        $product = $service->show($id);
        return view('product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
//    public function edit($id, ProductService $service)
//    {
//        $product = $service->edit($id);
//        return view('product.edit', compact('product'));
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
//    public function update($id, Request $request, ProductService $service)
//    {
//        $service->update($id, $request->all());
//        return redirect('/');
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id, ProductService $service)
//    {
//        $service->destroy($id);
//        return redirect('/');
//    }
}
