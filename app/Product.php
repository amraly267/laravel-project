<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Softdeletes;
    protected $fillable = ['name_en', 'name_ar', 'description_en', 'description_ar', 'category_id', 'image',
        'purchasing_price', 'selling_price', 'stock_count'];

    protected $appends = ['imagePath', 'totalProfit'];
    

    public function categories()
    {
        return $this->belongsTo(Category::class, 'id');
    }

    public function getImagePathAttribute()
    {
        return asset('uploads/products/' . $this->image);
    }

    public function getTotalProfitAttribute()
    {
        $totalProfit = $this->selling_price - $this->purchasing_price;
        $profitPercentage = number_format(($totalProfit * 100) / $this->purchasing_price, 2) ;
        return $totalProfit ." (". $profitPercentage ."%)";
    }


}
