<?php

namespace App\Http\Controllers\dashboard;

use App\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;

class userCtrl extends Controller
{

    public function __construct()
    {
        // $this->middleware(['permission:read-users'])->only('destroy');
        $this->middleware(['permission:create-users'])->only('create');
        $this->middleware(['permission:update-users'])->only('edit');
        $this->middleware(['permission:delete-users'])->only('destroy');
    }

    // === Open Users Grid Function ===
    public function index(Request $request)
    {
        if (Auth::user()->hasPermission('read-users')
            || Auth::user()->hasPermission('update-users')
            || Auth::user()->hasPermission('delete-users')) {
            if ($request->search) {
                $users = User::whereHas('roles', function ($query) use ($request) {
                    $query->where("name", "admin")
                        ->where('users.id', '<>', auth()->user()->id)
                        ->Where('first_name', 'like', '%' . $request->input('search') . '%')
                        ->orWhere('last_name', 'like', '%' . $request->input('search') . '%');
                })->orderBy('id', 'DESC')->paginate(20);

            } else {
                $users = User::whereHas("roles", function ($query) {
                    $query->where("name", "admin")
                        ->where('users.id', '<>', auth()->user()->id);
                })->orderBy('id', 'DESC')->paginate(20);
            }

            return view('dashboard.users.grid', compact('users'));
        } else {
            abort(404);
        }
    }
    //=== End Function ===

    //=== Open User Form Function ===
    public function create()
    {
        return view('dashboard.users.form');
    }
    // === End Function ===

    // === Add New User Function ===
    public function store(Request $request)
    {
        // === Input Validations ===
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required | unique:users',
            'image' => 'mimes:jpeg,jpg,png',
            'password' => 'required',
            'confirm_password' => 'required | same:password',
            'permissions' => 'required | min:1',
        ]);
        // === End Validation ===

        // === Remove Not Needed Data And Encrypt The Password ===
        $userData = $request->except(['password', 'confirm_password', '_token', '_method', 'permissions', 'image']);
        $userData['password'] = bcrypt($request->input('password'));
        $userData['remember_token'] = $request->input('_token');
        // === End Remove And Encryption ===

        // === Upload Image If Existing ===
        if ($request->image) {
            $image = Image::make($request->image->getRealPath());
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users/' . $request->image->hashName()));
            $userData['image'] = $request->image->hashName();
        }
        // === End Upload Image ===

        // === Save Data To DB ===
        $addUser = User::firstOrCreate($userData);
        $addUser->attachRole('admin');
        $addUser->syncPermissions($request->input('permissions'));
        // === End Save Data ===

        // === Return Success Flash Message ===
        session()->flash('success', __('site.success_add'));
        return redirect()->route('dashboard.users.index');
    }
    //=== End Function ===

    //=== Open Edit User Form Function ===
    public function edit(user $user)
    {
        if ($user->hasRole('admin')) {
            return view('dashboard.users.form', compact('user'));
        } else {
            abort(404);
        }
    }
    //=== End Function ===

    // === Confirm Update User Data Function ===
    public function update(Request $request, user $user)
    {
        // === Input Validations ===
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'image' => 'mimes:jpeg,jpg,png',
            'permissions' => 'required | min:1',
        ]);
        // === End Validation ===

        // === Remove Not Needed Data And Encrypt The Password ===
        $userData = $request->except(['_token', '_method', 'permissions', 'image']);
        $userData['remember_token'] = $request->input('_token');
        // === End Remove And Encryption ===

        // === Upload Image If Existing ===
        if ($request->image) {
            if ($user->image != "default.png") {
                Storage::disk('public_uploads')->delete('users/' . $user->image);
            }
            $image = Image::make($request->image->getRealPath());
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users/' . $request->image->hashName()));
            $userData['image'] = $request->image->hashName();
        }
        // === End Upload Image ===

        // === Save Updates To DB ===
        $user->update($userData);
        $user->syncPermissions($request->input('permissions'));
        // === End Save Data ===

        // === Return Success Flash Message ===
        session()->flash('success', __('site.success_edit'));
        return redirect()->route('dashboard.users.index');
    }
    //=== End Function ===

    //=== Delete User From DB Function ===
    public function destroy(user $user)
    {
        if ($user->hasRole('admin')) {
            if ($user->image != "default.png") {
                Storage::disk('public_uploads')->delete('users/' . $user->image);
            }
            $user->delete();
            session()->flash('success', __('site.success_delete'));
            return redirect()->route('dashboard.users.index');
        } else {
            abort(404);
        }
    }
    //=== End Function ===

}
