<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

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
