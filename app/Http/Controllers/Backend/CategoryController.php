<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    { 
        return $dataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => ['required', 'not_in:empty'], 
            'name' => ['required', 'max:200', 'unique:categories,name'], 
            'status' => ['required'],
        ]);

        $slider = new Category(); 
 
        $slider->icon = $request->icon;
        $slider->name = $request->name; 
        $slider->slug = Str::slug($request->name); 
        $slider->status = $request->status;
        $slider->save();

        toastr('Created Successfully!', 'success');
        return redirect()->back();
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
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'icon' => ['required', 'not_in:empty'], 
            'name' => ['required', 'max:200', 'unique:categories,name,'.$id], 
            'status' => ['required'],
        ]);

        $slider = Category::findOrFail($id);
 
        $slider->icon = $request->icon;
        $slider->name = $request->name; 
        $slider->slug = Str::slug($request->name); 
        $slider->status = $request->status;
        $slider->save();

        toastr('Updated Successfully!', 'success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $subcategory = SubCategory::where('category_id', $category->id)->count();
        if($subcategory>0){
            return response(['status' => 'error', 'message' => 'This items contain, sub items for delete this you have 
            to delete the sub items first!']);
        }

        $category->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
