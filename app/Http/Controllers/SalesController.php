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
    public function store(Request $request, Sales $salesModel): JsonResponse
    {
        $product    = $request->input('product');
        $cost       = $request->input('cost');
        $currency   = $request->input('currency');

        $apiService = new \App\Services\PaymeApiService();
        $apiResponse = $apiService->requestApi(
            $apiService->buildGenerateSaleRequest(
                $product,
                $cost,
                $currency
            )
        );

        $parsedApiResponse = json_decode($apiResponse->getContents());

        if($parsedApiResponse->status_code === 0) {
            $salesModel->create(
                $product,
                $cost,
                $currency,
                $parsedApiResponse->payme_sale_code,
                $parsedApiResponse->sale_url
            );
        }

        return response()->json($parsedApiResponse);
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
