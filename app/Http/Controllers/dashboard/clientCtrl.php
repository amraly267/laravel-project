<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class clientCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create-categories'])->only('create');
        $this->middleware(['permission:update-categories'])->only('edit');
        $this->middleware(['permission:delete-categories'])->only('destroy');
    }

    // === Open Clients Grid Function ===
    public function index(Request $request)
    {
        if (Auth::user()->hasPermission('read-categories')
            || Auth::user()->hasPermission('update-categories')
            || Auth::user()->hasPermission('delete-categories')) {

            $clients = Client::when($request->search, function ($query) use ($request){
               $query->where('name','like', '%'.$request->search.'%')
                   ->orWhere('phone','like', '%'.$request->search.'%')
                   ->orWhere('address','like', '%'.$request->search.'%');
            })->orderBy('id', 'DESC')->paginate(20);
            return view('dashboard.clients.grid', compact('clients'));
        } else {
            abort(404);
        }
    }
    // === End Function ===

    //=== Open Client Form Function ===
    public function create()
    {
        return view('dashboard.clients.form');
    }
    //=== End Function ===

    // === Store Client Data To DB Function ===
    public function store(Request $request)
    {
        // === Input Validations ===
        $request->validate([
            'name' => 'required',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required',
        ]);
        // === End Validation ===

        //=== Handle Phone Array ===
        $clientData = $request->all();
        $clientData['phone'] = array_filter($request->input('phone'));

        // === Save Client Data To DB ===
        $addClient = Client::create($clientData);

        // === Return Success Flash Message ===
        session()->flash('success', trans('site.success_add'));
        return redirect()->route('dashboard.clients.index');
    }
    //=== End Function ===

    //=== Open Edit Client Form Function ===
    public function edit(Client $client)
    {
        return view('dashboard.clients.form', compact('client'));
    }
    //=== End Function ===

    // === Confirm Update Client Data Function ===
    public function update(Request $request, Client $client)
    {
        // === Input Validations ===
        $request->validate([
            'name' => 'required',
            'phone' => 'required|array|min:1',
            'phone.0' => 'required',
            'address' => 'required',
        ]);
        // === End Validation ===

        //=== Handle Phone Array ===
        $clientData = $request->all();
        $clientData['phone'] = array_filter($request->input('phone'));

        // === Update Client Data To DB ===
        $client->update($clientData);

        // === Return Success Flash Message ===
        session()->flash('success', trans('site.success_edit'));
        return redirect()->route('dashboard.clients.index');
    }
    //=== End Function ===

    //=== Delete Client From DB Function  ===
    public function destroy(Client $client)
    {
        $client->delete();
        session()->flash('success', trans('site.success_delete'));
        return redirect()->route('dashboard.clients.index');
    }
    //=== End Function ===


}
