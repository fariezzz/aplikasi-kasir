<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where(function($query) use($search){
                $query->where('name', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['status'] ?? false, function($query, $status){
            $query->whereHas('transaction', function($query) use ($status) {
                $query->where('status', $status);
            });
        });
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}
