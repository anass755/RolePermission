<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles=Role::all();

        return view('role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validate=$request->validate([
            'name' => 'required',
            'key' => 'required|unique:roles,key'
        ]);

        Role::create([
            'name'=>$request->name,
            'key'=>$request->key
        ]);

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        
        return view('role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'key' => 'required|unique:permissions,key'
        ]);

        $role->update([
            'name'=>$request->name,
            'key'=>$request->key
        ]);

        return redirect()->route('roles.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        
        return redirect()->route('roles.index');
    }

    public function permissionShow(Role $role){

        $permissionGroups=PermissionGroup::with('permissions')->get();
        return view('role.permissionShow',compact('permissionGroups','role'));
    }

    public function storeAssign(Request $request, Role $role){

        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index');
    }
}
