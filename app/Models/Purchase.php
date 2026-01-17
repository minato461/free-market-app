<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    /**
     * 複数代入を許可する属性
     * shipping_addressを含めることで、購入確定時の住所を履歴として保存可能になります。
     */
    protected $fillable = [
        'user_id',
        'item_id',
        'payment_method',
        'shipping_address',
    ];

    /**
     * 購入者（ユーザー）とのリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 購入対象の商品とのリレーション
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}