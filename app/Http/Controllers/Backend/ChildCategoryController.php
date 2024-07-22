<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ChildCategory;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChildCategoryDataTable $dataTable)
    { 
        return $dataTable->render('admin.child-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.child-category.create', compact('categories'));
    }

    public function getSubCategories(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->id)->where('status', 1)->get();
        return $subcategories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required'], 
            'sub_category' => ['required'], 
            'name' => ['required', 'max:200', 'unique:sub_categories,name'], 
            'status' => ['required'],
        ]);

        $slider = new ChildCategory(); 
 
        $slider->category_id = $request->category;
        $slider->sub_category_id = $request->sub_category;
        $slider->name = $request->name; 
        $slider->slug = Str::slug($request->name); 
        $slider->status = $request->status;
        $slider->save();

        toastr('Created Successfully!', 'success');
        return redirect()->route('admin.child-category.index');
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
        $categories = Category::all();
        $childcategory = ChildCategory::findOrFail($id);
        $subCategories = SubCategory::where('category_id', $childcategory->category_id)->get();

        return view('admin.child-category.edit', compact('childcategory', 'categories', 'subCategories')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => ['required'], 
            'sub_category' => ['required'], 
            'name' => ['required', 'max:200', 'unique:sub_categories,name,'.$id], 
            'status' => ['required'],
        ]);

        $childcategory = ChildCategory::findOrFail($id);
 
        $childcategory->category_id = $request->category;
        $childcategory->sub_category_id = $request->sub_category;
        $childcategory->name = $request->name; 
        $childcategory->slug = Str::slug($request->name); 
        $childcategory->status = $request->status;
        $childcategory->save();

        toastr('Updated Successfully!', 'success');
        return redirect()->route('admin.child-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $childcategory = ChildCategory::findOrFail($id);
        

        $childcategory->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
