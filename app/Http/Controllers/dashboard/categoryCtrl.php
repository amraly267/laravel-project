<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Auth;

class categoryCtrl extends Controller
{
    public function __construct()
    {
        // $this->middleware(['permission:read-users'])->only('destroy');
        $this->middleware(['permission:create-categories'])->only('create');
        $this->middleware(['permission:update-categories'])->only('edit');
        $this->middleware(['permission:delete-categories'])->only('destroy');
    }

    // === Open Categories Grid Function ===
    public function index(Request $request)
    {
        if (Auth::user()->hasPermission('read-categories')
            || Auth::user()->hasPermission('update-categories')
            || Auth::user()->hasPermission('delete-categories')) {

            $categories = Category::when($request->search, function ($query) use ($request) {
                $query->where('name_en', 'like', '%' . $request->search . '%')
                    ->orWhere('name_ar', 'like', '%' . $request->search . '%');
            })->orderBy('id', 'DESC')->paginate(20);

            return view('dashboard.categories.grid', compact('categories'));
        } else {
            abort(404);
        }
    }
    // === End Function ===

    //=== Open Category Form Function ===
    public function create()
    {
        return view('dashboard.categories.form');
    }
    // === End Function ===

    // === Store Category Data To DB Function ===
    public function store(Request $request)
    {
//        if ($request->ajax()) {
            // === Input Validations ===
            $request->validate([
                'name_ar' => ['required', Rule::unique('categories')],
                'name_en' => ['required', Rule::unique('categories')],
            ],['name_ar.required' => 'error in namew aer']);
            // === End Validation ===

            // === Remove Not Needed Data Then Save Data To DB ===
            $categoryData = $request->except(['_token', '_method']);
            $addCategory = Category::Create($categoryData);
            // === End Save Data ===

            // === Return Success Flash Message ===
            session()->flash('success', __('site.success_add'));
            return redirect()->route('dashboard.categories.index');
//        }
    }
    // === End Function ===

    //=== Open Edit Category Form Function ===
    public function edit(Category $category)
    {
        return view('dashboard.categories.form', compact('category'));
    }
    //=== End Function ===

    // === Confirm Update Category Data Function ===
    public function update(Request $request, Category $category)
    {
        // === Input Validations ===
        $request->validate([
            'name_ar' => ['required', Rule::unique('categories')->ignore($category->id)],
            'name_en' => ['required', Rule::unique('categories')->ignore($category->id)],
        ]);
        // === End Validation ===

        // === Remove Not Needed Data Then Update Data To DB ===
        $categoryData = $request->except(['_token', '_method']);
        $category->update($categoryData);
        // === End Update Data ===

        // === Return Success Flash Message ===
        session()->flash('success', __('site.success_edit'));
        return redirect()->route('dashboard.categories.index');
    }
    // === End Function ===

    // === Delete Category Function ===
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', __('site.success_delete'));
        return redirect()->route('dashboard.categories.index');
    }
    // === End Function ===

}
