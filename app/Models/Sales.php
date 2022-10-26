<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Sales extends Model
{
    use HasFactory;

    const TABLE_NAME = "sales";

    protected $dates = [
        "created_at",
        "updated_at",
    ];

    /**
     * @param string $product
     * @param int    $cost
     * @param string $currency
     * @param int    $sale_id
     * @param string $sale_url
     *
     * @return void
     */
    public function create(
        string $product,
        int $cost,
        string $currency,
        int $sale_id,
        string $sale_url
    ): void
    {
        static::query()->insert(
            [
                "sale_id" => $sale_id,
                "product" => $product,
                "cost" => $cost,
                "currency" => $currency,
                "sale_url" => $sale_url,
                "created_at" => Carbon::now(),
            ]
        );
    }

    /**
     * @return array
     */
    public function getAll():array
    {
        return static::all();
    }
}
