<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Sales $sales_model): JsonResponse
    {
        return response()->json(['items' => $sales_model->getAll()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Sales $sales_model): JsonResponse
    {
        $product    = $request->input('product');
        $cost       = $request->input('cost');
        $currency   = $request->input('currency');

        $api_service = new \App\Services\PaymeApiService();
        $api_response = $api_service->requestApi(
            $api_service->buildGenerateSaleRequest(
                $product,
                $cost,
                $currency
            )
        );

        $parsed_api_response = json_decode($api_response->getContents());

        if($parsed_api_response->status_code === 0) {
            $sales_model->create(
                $product,
                $cost,
                $currency,
                $parsed_api_response->payme_sale_code,
                $parsed_api_response->sale_url
            );
        }

        return response()->json($parsed_api_response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSalesRequest  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalesRequest $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
