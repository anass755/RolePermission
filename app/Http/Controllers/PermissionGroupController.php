<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use Illuminate\Http\Request;

class PermissionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions=PermissionGroup::all();

       return view('permissionGroup.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissionGroup.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        PermissionGroup::create([
            'name'=>$request->name,
            'sort_order'=>$request->sortorder
        ]);

        return redirect()->route('permissionGroup.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PermissionGroup $permissionGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PermissionGroup $permissionGroup)
    {

       return view('permissionGroup.edit',compact('permissionGroup'));
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PermissionGroup $permissionGroup)
    {
        $permissionGroup->update([
            'name'=>$request->name,
            'sort_order'=>$request->sortorder
        ]);

        return redirect()->route('permissionGroup.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermissionGroup $permissionGroup)
    {
       $permissionGroup->delete();

       return redirect()->back();
    }
}
