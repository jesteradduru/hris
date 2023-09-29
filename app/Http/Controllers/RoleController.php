<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(){
        $this->authorizeResource(Role::class, 'role');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/RolePermission/Role/Index', [
            "roles" => Role::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
    $this->authorize('create', Role::class);
       try {
        $validate = $request->validate([
            'role_name' => 'required|string|max:255'
        ]);

        $role = Role::create(['name' => $validate['role_name'] ]);
        

        return back()->with('success', 'Role'. ' ' . $role->name . ' successfully created!');

       } catch (RoleAlreadyExists $e) {

            throw ValidationException::withMessages([
                'role_name' => 'The role name must be unique.'
            ]);
            
       }
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
    public function edit(Role $role)
    {
        return inertia('Admin/RolePermission/Role/Edit', [
            'permissions' => $role->permissions,
            'role' => $role,
            'all_permissions' => Permission::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validate = $request->validate([
            'role_name' => 'required|string'
        ]);

        $role->update([ "name" => $request->input('role_name')]);

        $role->syncPermissions($request->input('permissions'));

        return back()->with('success', 'Role successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return back()->with('success', 'Role successfully deleted.');
    }
}
