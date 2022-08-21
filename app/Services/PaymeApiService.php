<?php
/**
 * @author Valentin Ruskevych <valentin.ruskevych@payme.io>
 * User: {valentin}
 * Date: {16/08/2022}
 * Time: {16:20}
 */

namespace App\Services;

use App\Helpers\PaymeApiRequestParameters;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\StreamInterface;

class PaymeApiService
{
    const SCHEMA = 'https';
    const DOMAIN = 'sandbox.payme.io';
    const GENERATE_SALE_PATH = '/api/generate-sale';
    const MPL = 'MPL14985-68544Z1G-SPV5WK2K-0WJWHC7N';
    const INSTALLMENTS = 1;
    const LANGUAGE = 'en';

    const REQUEST_METHOD_GET    = 'GET';
    const REQUEST_METHOD_POST   = 'POST';
    const REQUEST_METHOD_PUT    = 'PUT';
    const REQUEST_METHOD_PATCH  = 'PATCH';
    const REQUEST_METHOD_DELETE = 'DELETE';

    /**
     * @param string $product
     * @param int    $cost
     * @param string $currency
     *
     * @return Request
     */
    public function buildGenerateSaleRequest(string $product, int $cost, string $currency):Request
    {
        $api_url = static::SCHEMA . '://' . static::DOMAIN . static::GENERATE_SALE_PATH;
        return new Request(
            static::REQUEST_METHOD_POST,
            $api_url,
            $this->getJsonHeaders(),
            json_encode($this->buildGenerateSaleRequestBody($product, $cost, $currency))
        );
    }

    /**
     * @return string[]
     */
    public function getJsonHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * @param string $product
     * @param int    $cost
     * @param string $currency
     *
     * @return array
     */
    public function buildGenerateSaleRequestBody(string $product, int $cost, string $currency): array
    {
        return [
                PaymeApiRequestParameters::SELLER_PAYME_ID   => static::MPL,
                PaymeApiRequestParameters::SALE_PRICE        => $cost*100,
                PaymeApiRequestParameters::CURRENCY          => $currency,
                PaymeApiRequestParameters::PRODUCT_NAME      => $product,
                PaymeApiRequestParameters::INSTALLMENTS      => static::INSTALLMENTS,
                PaymeApiRequestParameters::LANGUAGE          => static::LANGUAGE,
        ];
    }

    /**
     * @param Request $request
     * @param array   $options
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestApi(Request $request, array $options = array()):StreamInterface
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request, $options);
        return $response->getBody();
    }
}
