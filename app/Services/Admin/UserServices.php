<?php

namespace App\Services\Admin;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServices
{
	/**
     * @param int $comicId
     * @return mixed
     */
    public function getListUsers(array $params = [])
    {
        return $this->conditionQuery($params);
    }

    /**
     * @param array $comicIds
     * @param array $params
     * @param array $with
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function conditionQuery($params = [])
    {
        $query = (new User)->newQuery();

        $query->orderBy('id', 'desc');

        // pagination
        $perPage = $params['per_page'] ?? 20;
        return $query->paginate($perPage);
    }


    public function getDetail(string $idUser = '')
    {
        return User::findOrFail($idUser);
    }

    public function updatePassword($idUser, $newPassword)
    {
        $user = User::find($idUser);
        if ($user) {
            $user->password = Hash::make($newPassword);
            $user->save();
            return true;
        }
        return false;
    }
    public function createOrUpdate(array $data)
    {
        return User::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'role' => $data['role'],
                'password' => Hash::make($data['password']),
            ]
        );
    }
}
