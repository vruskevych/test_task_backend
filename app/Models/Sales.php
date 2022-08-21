<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sales extends Model
{
    use HasFactory;

    const TABLE_NAME = 'sales';

    protected $dates = [
        'created_at',
        'updated_at',
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
        DB::insert(
            'insert into ' . static::TABLE_NAME . ' (sale_id, product, cost, currency, sale_url, created_at) values (?, ?, ?, ?, ?, ?)',
            [$sale_id, $product, $cost, $currency, $sale_url, (new \DateTime())->format('Y-m-d H:i:s')]
        );
    }

    /**
     * @return array
     */
    public function getAll():array
    {
        return DB::select('select * from ' . static::TABLE_NAME);
    }
}
