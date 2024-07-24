<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;

class ProductVariantItemController extends Controller
{
    public function index(ProductVariantItemDataTable $datatable, $productId, $variantId)
    {
        $product = Product::findOrFail($productId);
        $variant = ProductVariant::findOrFail($variantId);
        return $datatable->render('admin.product.product-variant-item.index', compact('product', 'variant'));
    }

    public function create(string $productId, string $variantId)
    {
        $product = Product::findOrFail($productId);
        $variant = ProductVariant::findOrFail($variantId);
        return view('admin.product.product-variant-item.create', compact('product', 'variant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'variant_id' => ['required', 'integer'], 
            'name' => ['required', 'max:200', ], 
            'price' => ['required'], 
            'is_default' => ['required'], 
            'status' => ['required'],
        ]);

        $variant = new ProductVariantItem(); 
 
        $variant->product_variant_id = $request->variant_id;
        $variant->name = $request->name;  
        $variant->price = $request->price;  
        $variant->is_default = $request->is_default;  
        $variant->status = $request->status;
        $variant->save();

        toastr('Created Successfully!', 'success');
        return redirect()->route('admin.product-variant-item.index', 
        ['productId' => $request->product_id, 'variantId' => $request->variant_id]);
    }

    public function edit(string $variantItemId)
    {
        $variantItem = ProductVariantItem::findOrFail($variantItemId);  
        return view('admin.product.product-variant-item.edit', compact('variantItem'));
    }

    public function update(Request $request, string $variantItemId)
    {
        $request->validate([ 
            'name' => ['required', 'max:200', ], 
            'price' => ['required'], 
            'is_default' => ['required'], 
            'status' => ['required'],
        ]);

        $variantItem = ProductVariantItem::findOrFail($variantItemId);   
  
        $variantItem->name = $request->name;  
        $variantItem->price = $request->price;  
        $variantItem->is_default = $request->is_default;  
        $variantItem->status = $request->status;
        $variantItem->save();

        toastr('Updated Successfully!', 'success');
        return redirect()->route('admin.product-variant-item.index', 
        ['productId' => $variantItem->productVariant->product_id, 'variantId' => $variantItem->product_variant_id]);
    }

    public function destroy(string $variantItemId)
    {
        $variantitem = ProductVariantItem::findOrFail($variantItemId);
        $variantitem->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
