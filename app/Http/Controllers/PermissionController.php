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

        $this->middleware('permission:view.permission')->only('index');
        $this->middleware('permission:create.permission')->only(['create', 'store']);
        $this->middleware('permission:edit.permission')->only(['edit', 'update']);
        $this->middleware('permission:delete.permission')->only('destroy');
    }

    public function index()
    {
        return view('permission.index',);
    }

    public function create()
    {
        return view('permission.create');
    }


    public function store(PermissionRequest $request)
    {
        $data['guard']="web";
        $this->permissionService->storePermission($data);
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
        return redirect()->route('permission.index')->with('success', 'Sukses Menghapus Permission.');
    }
}
