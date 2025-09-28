<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Permission;
use App\Services\Permission\PermissionServiceInterface;

class PermissionController extends Controller
{
    private PermissionServiceInterface $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index(Request $request)
    {
        $permissions = $this->permissionService->getAllPermissions($request->search);
        return view('permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('permission.create');
    }


    public function store(PermissionRequest $request)
    {
        $this->permissionService->storePermission($request->all());
        return redirect()->route('permission.index')->with('success', 'Sukses Menambah Permission.');
    }

    public function edit(Permission $permission)
    {
        return view('permission.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $this->permissionService->editPermission($permission, $request->all());
        return redirect()->route('permission.index')->with('success', 'Sukses Mengubah Permission.');
    }

    public function destroy(Permission $permission)
    {
        $this->permissionService->deletePermission($permission);
        return redirect()->route('permission.index')->with('success', 'Sukses Mengubah Permission.');
    }
}
