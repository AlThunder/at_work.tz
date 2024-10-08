<?php

namespace App\Services\Api;


use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;

class UserService
{
    private mixed $userRepository;


    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = [
            'id',
            'name',
            'surname',
            'phone',
            'avatar',
        ];
        $users = $this->userRepository->getUsers($columns);

        if ($users) {
            return response()->json(['success' => true, $users]);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка получения данных'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        $data = $request->validated();
        $storage = Storage::disk('public');
        $data['avatar'] = $storage->put('/images/avatars', $data['avatar']);

        $user = User::create($data);
        if ($user) {
            return response()->json(['success' => true, 'message' => 'Данные успешно сохранены']);
        } else {
            if($storage->exists($data['avatar']))
                $storage->delete($data['avatar']);
            return response()->json(['success' => false, 'message' => 'Ошибка сохранения данных'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $columns = [
            'id',
            'name',
            'surname',
            'phone',
            'avatar',
        ];
        $user = $this->userRepository->getUser($id, $columns);
        if ($user) {
            return response()->json(['success' => true, $user]);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка получения данных'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, string $id)
    {
        $user = $this->userRepository->getUser($id);
        $old_avatar = $user['avatar'];
        $data = $request->validated();
        if($id !== $data['id']) return response()->json(['success' => false, 'message' => 'Ошибка обновления данных'], 500);
        $storage = Storage::disk('public');
        $data['avatar'] = $storage->put('/images/avatars', $data['avatar']);

        $result = $user->update($data);
        if ($result) {
            if($storage->exists($old_avatar))
                $storage->delete($old_avatar); //при загрузке новых картинок удаляем старые
            return response()->json(['success' => true, 'Данные успешно обновлены']);
        } else {
            if($storage->exists($data['avatar']))
                $storage->delete($data['avatar']); // удаляем новую картинку, если запись в БД не обновилась
            return response()->json(['success' => false, 'message' => 'Ошибка сохранения'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = $this->userRepository->getUser($id);

        if($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Данные успешно удалены']);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка удаления данных'], 500);
        }
    }

}
