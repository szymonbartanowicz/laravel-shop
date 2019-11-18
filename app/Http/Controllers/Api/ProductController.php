<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

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
        return response()->json($service->index());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductService $service)
    {
        $service->store($request->all());
        return response()->json([
            'created' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param ProductService $service
     * @return \Illuminate\Http\Response
     */
    public function show($id, ProductService $service)
    {
        return response()->json($service->show($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, ProductService $service)
    {
        $service->update($id, $request->all());
        return response()->json([
            'edited' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ProductService $service)
    {
        $service->destroy($id);
        return response()->json([
            'deleted' => true
        ]);
    }
}