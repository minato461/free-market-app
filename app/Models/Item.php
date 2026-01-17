<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Purchase;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brand_id',
        'name',
        'description',
        'price',
        'condition',
        'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_item', 'item_id', 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 購入情報とのリレーション
     */
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    /**
     * 売却済みかどうかを判定するメソッド
     * 購入データ（purchasesテーブル）が存在すればtrueを返します。
     */
    public function isSold(): bool
    {
        return $this->purchase()->exists();
    }

    /**
     * アクセサ定義（$item->is_sold で呼び出し可能）
     */
    public function getIsSoldAttribute()
    {
        return $this->isSold();
    }
}