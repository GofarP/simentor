<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Services\Permission\PermissionServiceInterface;
use App\Services\Role\RoleServiceInterface;

class RoleController extends Controller
{
    protected RoleServiceInterface $roleService;
    protected PermissionServiceInterface $permissionService;


    public function __construct(RoleServiceInterface $roleService, PermissionServiceInterface $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $roles = $this->roleService->getAllRoles($request->get('search', ''), 10);

        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $search bisa null, $perPage diabaikan karena $eager=true
        $permissions = $this->permissionService->getAllPermissions(null, 10, true);

        return view('role.create', compact('permissions'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $data = $request->validated();
        $permissions = $request->input('permissions', []); // array of IDs
        $this->roleService->storeRole($data, $permissions);

        return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan.');
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
        return view('role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->roleService->editRole($role, $request->validated());
        return redirect()->route('role.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus.');
    }
}
