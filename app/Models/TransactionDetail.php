<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transactions_details';
    public $timestamps = false;

    protected $fillable = ['qty', 'price', 'tran_id', 'product_id', 'user_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'tran_id');
    }
}
