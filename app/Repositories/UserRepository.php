<?php

namespace App\Repositories;

use App\Models\User as Model;

/**
 * Class UserRepository
 *
 * @package App\Repositories
 */
class UserRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Получить коллекцию пользователей.
     *
     *
     * @return Model
     */
    public function getUsers($columns = '*')
    {
        return $this->startConditions()->all($columns);
    }

    /**
     * Получить сущность пользователя.
     *
     *
     * @return Model
     */
    public function getUser($id, $columns = '*')
    {
        return $this->startConditions()->find($id, $columns);
    }


}
