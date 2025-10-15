<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\Role\RoleServiceInterface;
use App\Services\User\UserServiceInterface;

class UserController extends Controller
{

    private UserServiceInterface $userService;
    private RoleServiceInterface $roleService;

    public function __construct(UserServiceInterface $userService, RoleServiceInterface $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;

        $this->middleware('permission:view.user')->only('index');
        $this->middleware('permission:create.user')->only(['create', 'store']);
        $this->middleware('permission:edit.user')->only(['edit', 'update']);
        $this->middleware('permission:delete.user')->only('destroy');
        $this->middleware('permission:fetch.user')->only('fetchInstruction');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roleService->getAllRoles(null, 10, true);
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->userService->storeUser($request->all());
        return redirect()->route('user.index')->with('success', 'Sukses menambah user');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = $this->roleService->getAllRoles(null, 10, true);
        return view('user.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $this->userService->editUser($user, $request->all());
        return redirect()->route('user.index')->with('success', 'Sukses Mengubah User.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);
        return redirect()->route('user.index')->with('success', 'Sukses Menghapus User.');
    }
}
