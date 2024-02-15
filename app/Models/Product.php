<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $orders = Order::all();
            $transactions = Transaction::all();

            foreach ($orders as $order) {
                $productIds = json_decode($order->product_id);

                if (in_array($product->id, $productIds)) {
                    $order->delete();
                }
            }

            foreach ($transactions as $transaction) {
                $productIds = json_decode($transaction->product_id);

                if (in_array($product->id, $productIds)) {
                    $transaction->delete();
                }
            }

            if ($product->image) {
                Storage::delete($product->image);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){
            $query->where(function($query) use($search){
                $query->where('name', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['category'] ?? false, function($query, $category){
            $query->whereHas('category', function($query) use ($category) {
                $query->where('slug', $category);
            });
        });
    }
}
