<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Permission::class, 'permission');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/RolePermission/Permission/Index', [
            "permissions" => Permission::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'permission_name' => 'required|string|max:255'
            ]);
    
            $role = Permission::create(['name' => $validate['permission_name'] ]);
            
    
            return back()->with('success', 'Permission'. ' ' . $role->name . ' successfully created!');
    
           } catch (PermissionAlreadyExists $e) {
    
                throw ValidationException::withMessages([
                    'permission_name' => 'The permission name must be unique.'
                ]);
                
           }
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
        return inertia('Admin/RolePermission/Permission/Edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validate = $request->validate([
            'permission_name' => 'required|string'
        ]);

        $permission->update([ "name" => $request->input('permission_name')]);

        return back()->with('success', 'Permission successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
            $permission->delete();
    
            return back()->with('success', 'Permission successfully deleted.');
    }
}
