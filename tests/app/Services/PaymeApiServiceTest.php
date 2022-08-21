<?php

namespace Tests\app\Services;

use App\Services\PaymeApiService;
use App\Helpers\PaymeApiRequestParameters;
use Tests\TestCase;

class PaymeApiServiceTest extends TestCase
{
    protected $api_service;

    public function setUp():void
    {
        $this->api_service = new PaymeApiService();
    }

    public function tearDown():void
    {
        $this->api_service = null;
    }

    /**
     * json headers provider test.
     *
     * @return void
     */
    public function test_getJsonHeaders()
    {
        $json_datatype = 'application/json';
        $headers = $this->api_service->getJsonHeaders();
        $this->assertCount(2, $headers, 'headers amount was different than expected');
        $this->assertArrayHasKey('Content-Type', $headers, '"Content-Type" header is missing');
        $this->assertArrayHasKey('Accept', $headers, '"Accept" header is missing');
        $this->assertEquals($json_datatype, $headers['Content-Type'], 'Content type header for json is unexpected.');
        $this->assertEquals($json_datatype, $headers['Accept'], 'Accept header for json is unexpected.');
    }

    /**
     * Test CodeGenerated Generate Sale request body.
     * @return void
     */
    public function test_buildGenerateSaleRequestBody()
    {
        $product = 'AProduct';
        $cost = '120';
        $currency = 'USD';
        $body_params = $this->api_service->buildGenerateSaleRequestBody($product, $cost, $currency);

        $this->assertCount(6, $body_params, 'Sale Request Body was not exactly 6 items.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::SELLER_PAYME_ID, $body_params, 'Body missing seller payme id param.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::SALE_PRICE, $body_params, 'body missing sale price param.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::CURRENCY, $body_params, 'body missing currency param.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::PRODUCT_NAME, $body_params, 'body missing product name param.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::INSTALLMENTS, $body_params, 'body missing installments param.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::LANGUAGE, $body_params, 'body missing language param.');
        $this->assertEquals($cost*100, $body_params[PaymeApiRequestParameters::SALE_PRICE], 'The cost calculated wrong?');
        $this->assertEquals($currency, $body_params[PaymeApiRequestParameters::CURRENCY], 'Unexpected currency.');
        $this->assertEquals($product, $body_params[PaymeApiRequestParameters::PRODUCT_NAME], 'The product is not the same we provided.');
    }

    /**
     * Test for Generate Sale Request Builder.
     * Including headers, body, method, uri.
     * @return void
     */
    public function test_buildGenerateSaleRequest()
    {
        $product = 'AProduct';
        $cost = '120';
        $currency = 'USD';
        $request = $this->api_service->buildGenerateSaleRequest($product, $cost, $currency);
        $this->assertEquals('POST', $request->getMethod(), 'method is not post.');
        $this->assertEquals(PaymeApiService::REQUEST_METHOD_POST, $request->getMethod(), 'method is not equal to Api wrapper constant.');
        $this->assertEquals('https://sandbox.payme.io//api/generate-sale', $request->getUri(), 'improper URL built by wrapper?');
        $request_headers = $request->getHeaders();
        $json_datatype = 'application/json';
        $this->assertCount(2, $request_headers, 'headers amount was different than expected');
        $this->assertArrayHasKey('Content-Type', $request_headers, '"Content-Type" header is missing');
        $this->assertArrayHasKey('Accept', $request_headers, '"Accept" header is missing');
        $this->assertEquals($json_datatype, $request_headers['Content-Type'], 'Content type header for json is unexpected.');
        $this->assertEquals($json_datatype, $request_headers['Accept'], 'Accept header for json is unexpected.');

        $request_body = json_decode($request->getBody());
        $this->assertCount(6, $request_body, 'Sale Request Body was not exactly 6 items.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::SELLER_PAYME_ID, $request_body, 'Body missing seller payme id param.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::SALE_PRICE, $request_body, 'body missing sale price param.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::CURRENCY, $request_body, 'body missing currency param.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::PRODUCT_NAME, $request_body, 'body missing product name param.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::INSTALLMENTS, $request_body, 'body missing installments param.');
        $this->assertArrayHasKey(PaymeApiRequestParameters::LANGUAGE, $request_body, 'body missing language param.');
        $this->assertEquals($cost*100, $request_body[PaymeApiRequestParameters::SALE_PRICE], 'The cost calculated wrong?');
        $this->assertEquals($currency, $request_body[PaymeApiRequestParameters::CURRENCY], 'Unexpected currency.');
        $this->assertEquals($product, $request_body[PaymeApiRequestParameters::PRODUCT_NAME], 'The product is not the same we provided.');
    }
}
