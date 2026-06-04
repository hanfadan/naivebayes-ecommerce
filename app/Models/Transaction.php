<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $table = 'transactions';
    public $timestamps = false;

    protected $fillable = ['total', 'invoice', 'user_id', 'created', 'modified'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'tran_id');
    }

    public static function generateCode(): string
    {
        $row  = DB::selectOne('SELECT MAX(RIGHT(invoice,4)) as code FROM transactions WHERE DATE(created) = CURDATE()');
        $code = $row ? (int) $row->code : 0;
        return 'INV' . date('Ymd') . sprintf('%04d', $code + 1);
    }

    public static function totalAll(): int
    {
        return (int) self::count();
    }

    public static function totalNow(): int
    {
        return (int) self::whereRaw('DATE(created) = CURDATE()')->count();
    }

    public static function totalMonth(): int
    {
        return (int) self::whereYear('created', date('Y'))
            ->whereMonth('created', date('m'))
            ->count();
    }

    public static function totalUser(): int
    {
        return (int) User::where('role', 'user')->count();
    }

    public static function findAll(): array
    {
        return self::select('transactions.id', 'transactions.total', 'transactions.invoice', 'users.name as user')
            ->leftJoin('users', 'transactions.user_id', '=', 'users.id')
            ->get()
            ->toArray();
    }

    public static function findDetails(string $invoice): array
    {
        $trans = self::where('invoice', $invoice)->first();
        if (!$trans) return [];

        return TransactionDetail::select(
            'transactions_details.id',
            'transactions_details.qty',
            'transactions_details.price',
            'products.name as product'
        )
            ->leftJoin('products', 'transactions_details.product_id', '=', 'products.id')
            ->where('transactions_details.tran_id', $trans->id)
            ->get()
            ->toArray();
    }
}
