<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class VendorProductController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductDataTable $dataTable)
    { 
        return $dataTable->render('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('vendor.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:2048'],
            'name' => ['string', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max:600'],
            'long_description' => ['required'],
            'product_type' => ['required'], 
            'status' => ['required'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
        ]);

        $product = new Product();
                                
        /** Handle upload file */
        $imagePath = $this->uploadImage($request, 'image', 'uploads');

        $product->thumb_image = $imagePath;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name); 
        $product->vendor_id = Auth::user()->vendor->id;;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type; 
        $product->status = $request->status;
        $product->is_approved = 0;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description; 
        $product->save();

        toastr('Created Successfully!', 'success');
        return redirect()->route('vendor.product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id); 
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }
        $subCategories = SubCategory::where('category_id', $product->category_id)->get(); 
        $childCategories = ChildCategory::where('sub_category_id', $product->sub_category_id)->get(); 
        $categories = Category::all();
        $brands = Brand::all();
        return view('vendor.product.edit', compact('categories', 'brands', 'product', 'subCategories', 'childCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'max:2048'],
            'name' => ['string', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max:600'],
            'long_description' => ['required'],
            'product_type' => ['required'], 
            'status' => ['required'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
        ]);

        $product = Product::findOrFail($id);
                          
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }
        /** Handle update file */ 
        $imagePath = $this->updateImage($request, 'image', 'uploads', $product->thumb_image); 

        $product->thumb_image = empty(!$imagePath) ? $imagePath : $product->thumb_image;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name); 
        $product->vendor_id = Auth::user()->vendor->id;;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type; 
        $product->status = $request->status;
        $product->is_approved = $request->is_approved ?? 0;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description; 
        $product->save();

        toastr('Updated Successfully!', 'success');
        return redirect()->route('vendor.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }

        $this->deleteImage($product->thumb_image);

        $gallery_images = ProductImageGallery::where('product_id', $product->id)->get();

        foreach($gallery_images as $image){
            $this->deleteImage($image->image);
            $image->delete();
        }
 
        $variants = ProductVariant::where('product_id', $product->id)->get();
        foreach($variants as $variant){
            $variant->productVariantItems()->delete();
            $variant->delete();
        }

        $product->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
    
    public function getSubCategories(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->id)->where('status', 1)->get();
        return $subcategories;
    }

    public function getChildCategories(Request $request)
    {
        $childcategories = ChildCategory::where('sub_category_id', $request->id)->where('status', 1)->get();
        return $childcategories;
    }
}
