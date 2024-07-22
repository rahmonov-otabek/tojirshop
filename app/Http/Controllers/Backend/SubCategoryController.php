<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\ChildCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $dataTable)
    { 
        return $dataTable->render('admin.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required'], 
            'name' => ['required', 'max:200', 'unique:sub_categories,name'], 
            'status' => ['required'],
        ]);

        $slider = new SubCategory(); 
 
        $slider->category_id = $request->category;
        $slider->name = $request->name; 
        $slider->slug = Str::slug($request->name); 
        $slider->status = $request->status;
        $slider->save();

        toastr('Created Successfully!', 'success');
        return redirect()->route('admin.sub-category.index');
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
        $subcategory = SubCategory::findOrFail($id);
        return view('admin.sub-category.edit', compact('subcategory', 'categories')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => ['required'], 
            'name' => ['required', 'max:200', 'unique:categories,name,'.$id], 
            'status' => ['required'],
        ]);

        $subcategory = SubCategory::findOrFail($id);
 
        $subcategory->category_id = $request->category;
        $subcategory->name = $request->name; 
        $subcategory->slug = Str::slug($request->name); 
        $subcategory->status = $request->status;
        $subcategory->save();

        toastr('Updated Successfully!', 'success');
        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $childcategory = ChildCategory::where('sub_category_id', $subcategory->id)->count();
        if($childcategory>0){
            return response(['status' => 'error', 'message' => 'This items contain, sub items for delete this you have 
            to delete the sub items first!']);
        }
        $subcategory->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
