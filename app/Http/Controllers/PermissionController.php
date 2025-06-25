<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


       $permissions=Permission::with('permissionGroup')->get();

       return view('permission.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissionGroups=PermissionGroup::all();

         return view('permission.create',compact('permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'key' => 'required|unique:permissions,key'
        ]);

       Permission::create([
            'permission_group_id'=>$request->permissionGroup,
            'name'=>$request->name,
            'key'=>$request->key,
            'sort_order'=>$request->sortorder
        ]);

        return redirect()->route('permissions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
         return view('permission.edit',compact('permission'));
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required',
            'key' => 'required|unique:permissions,key'
        ]);
        
         $permission->update([
            
            'name'=>$request->name,
            'key'=>$request->key,
            'sort_order'=>$request->sortorder
        ]);

        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

       return redirect()->back();
    }
}
