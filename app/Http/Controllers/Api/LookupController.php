<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AttributeResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\OrderResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductAttribute;

class LookupController
{

    public function getOrders()
    {
        $orders = Order::orderBy('name', 'asc')
            ->whereRelation('orderItems', 'seller_id', ['seller_id' => auth('sanctum')->user()->id])
            ->get()
        ;

        return response()->json(OrderResource::collection($orders), 200);
    }

    public function getBrands()
    {
        $brands = Brand::orderBy('name', 'asc')
            ->get()
        ;

        return response()->json(BrandResource::collection($brands), 200);
    }

    public function getCategories(bool $parentOnly = false)
    {
        $query = Category::orderBy('created_at', 'desc');
        if ($parentOnly) {
            $query->where(function ($query) {
                $query->where('parent_id', '=', null)
                    ->orWhere('parent_id', '=', 0)
                ;
            });
        }

        $categories = $query->get();

        return response()->json(CategoryResource::collection($categories), 200);
    }

    public function getSubcategories(int $categoryId)
    {
        $categories = Category::orderBy('name', 'asc')
            ->where('parent_id', $categoryId)
            ->get()
        ;

        return response()->json(CategoryResource::collection($categories), 200);
    }

    public function getAttributes()
    {
        $attributes = ProductAttribute::orderBy('name', 'asc')
            ->get()
        ;

        return response()->json(AttributeResource::collection($attributes), 200);
    }
}
