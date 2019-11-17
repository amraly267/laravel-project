<?php

namespace App\Http\Controllers\dashboard;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Auth;
use DB;


class productCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create-products'])->only('create');
        $this->middleware(['permission:update-products'])->only('edit');
        $this->middleware(['permission:delete-products'])->only('destroy');
    }

    // === Open Products Grid Function ===
    public function index(Request $request)
    {
        if (Auth::user()->hasPermission('read-products')
            || Auth::user()->hasPermission('update-products')
            || Auth::user()->hasPermission('delete-products')) {

            $categories = Category::all();
            $products = Product::when($request->search || $request->category, function ($query) use ($request) {
                if ($request->category != "all") {
                    $query->where('category_id', $request->category);
                }
                if ($request->search) {
                    $query->where('name_en', 'like', '%' . $request->search . '%')
                        ->orWhere('name_ar', 'like', '%' . $request->search . '%')
                        ->orWhere('description_en', 'like', '%' . $request->search . '%')
                        ->orWhere('description_ar', 'like', '%' . $request->search . '%');
                }
            })->with('categories')->orderBy('id', 'DESC')->paginate(20);

            return view('dashboard.products.grid', compact('products', 'categories'));

        } else {
            abort(404);
        }
    }
    // === End Function ===

    //=== Open Product Form Function ===
    public function create()
    {
        $categories = Category::all()->sortByDesc('id');
        return view('dashboard.products.form', compact('categories'));
    }
    // === End Function ===

    // === Store Product Data To DB Function ===
    public function store(Request $request)
    {
        // === Input Validations ===
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png',
            'name_ar' => 'required',
            'name_en' => 'required',
            'purchasing_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_count' => 'required|numeric',
        ]);
        // === End Validation ===

        // === Remove Not Needed Data ===
        $productData = $request->except(['_token', '_method', 'image']);

        // === Upload Image If Existing ===
        if ($request->image) {
            $image = Image::make($request->image->getRealPath());
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products/' . $request->image->hashName()));
            $productData['image'] = $request->image->hashName();
        }
        // === End Upload Image ===

        // === Save Product Data To DB ===
        $addProduct = Product::Create($productData);

        // === Return Success Flash Message ===
        session()->flash('success', __('site.success_add'));
        return redirect()->route('dashboard.products.index');
    }
    // === End Function ===

    //=== Open Edit Product Form Function ===
    public function edit(Product $product)
    {
        $categories = Category::all()->sortByDesc('id');
        return view('dashboard.products.form', compact('categories'))->with('product', $product);
    }
    //=== End Function ===

    // === Confirm Update Product Data Function ===
    public function update(Request $request, Product $product)
    {
        // === Input Validations ===
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png',
            'name_ar' => 'required',
            'name_en' => 'required',
            'purchasing_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_count' => 'required|numeric',
        ]);
        // === End Validation ===

        // === Remove Not Needed Data ===
        $productData = $request->except(['_token', '_method', 'image']);

        // === Upload Image If Existing ===
        if ($request->image) {
            if ($product->image != "default.png") {
                Storage::disk('public_uploads')->delete('products/' . $product->image);
            }
            $image = Image::make($request->image->getRealPath());
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products/' . $request->image->hashName()));
            $productData['image'] = $request->image->hashName();
        }
        // === End Upload Image ===

        // === Update Data To DB ===
        $product->update($productData);

        // === Return Success Flash Message ===
        session()->flash('success', __('site.success_edit'));
        return redirect()->route('dashboard.products.index');
    }
    // === End Function ===

    // === Delete Product Function ===
    public function destroy(Product $product)
    {
        $product->delete();
        session()->flash('success', __('site.success_delete'));
        return redirect()->route('dashboard.products.index');
    }
    // === End Function ===


}
