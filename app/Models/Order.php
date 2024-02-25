<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters){
        $query->when($filters['status'] ?? false, function($query, $status){
            $query->where('status', $status);
        });
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }

    public function product(){
        return $this->belongsToMany(Product::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
