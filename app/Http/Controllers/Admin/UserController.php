<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\UserServices;
use Illuminate\Support\Facades\DB;
use App\Enums\Role;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\EditUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use App\Models\User;
 
class UserController extends Controller
{
    protected $userServices;

    public function __construct(UserServices $userService)
    {
        $this->userServices = $userService;
    }

    public function index(Request $request)
    {
        $query = User::query();
        
        // Lọc theo tên
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // Lọc theo email
        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        // Lọc theo vai trò (role)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $perPage = $request->input('per_page', 10);

        $users = $query->paginate($perPage);
        $roles = Role::cases(); // Assuming you have a Role enum or similar

        return view('admin.user.index', compact('users', 'roles'));
    }


    public function create()
    {
        $optionRoles = Role::cases();

        return view('admin.user.create', compact('optionRoles'));
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        DB::beginTransaction();
        try {
            // Log dữ liệu inputs để kiểm tra
            Log::info('Inputs:', $inputs);

            $user = $this->userServices->createOrUpdate($inputs);
            DB::commit();
            return redirect()->route('users')->with('success', 'Created successfully')
                                            ->with('key', 'User')
                                            ->with('value', $user->email);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Request $request)
    {
        $idUser = $request->id;
        $data = $this->userServices->getDetail($idUser);
        $optionRoles = Role::cases();

        return view('admin.user.edit', [
            'user' => $data,
            'optionRoles' => $optionRoles
        ]);
    }

    public function edit(EditUserRequest $request)
    {
        $inputs = $request->all();

        DB::beginTransaction();
        try {
            $user = $this->userServices->createOrUpdate($inputs);
            DB::commit();
            return redirect()->route('users')->with('success','Edited successfully')
                                            ->with('key', 'User')
                                            ->with('value', $user->username);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Request $request)
    {
        $userid = $request->id;
        DB::beginTransaction();
        try {
            $data = $this->userServices->getDetail($userid);
            $data->delete();
            DB::commit();

            return redirect()->route('users')->with('success','Deleted successfully')
                                            ->with('key', 'User')
                                            ->with('value', $data->username);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function changePassword()
    {
        $idUser = auth()->user()->id;
        $userDetail = $this->userServices->getDetail($idUser);
        return view('admin.user.change-password', [
            'user' => $userDetail,
        ]);
    }

    public function updatePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $userId = $request->id;
        $newPassword = $request->input('new_password');

        DB::beginTransaction();
        try {
            $user = $this->userServices->updatePassword($userId, $newPassword);
            DB::commit();
            return Redirect::back()->with('success', 'Password Changed Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function profileUser()
    {
        $idUser = auth()->user()->id;
        $userDetail = $this->userServices->getDetail($idUser);
        return view('admin.user.profile', [
            'user' => $userDetail,
        ]);
    }
}
