<?php

namespace App\Repositories;

use App\Models\Comment as Model;
use Ramsey\Collection\Collection;

/**
 * Class CommentRepository
 *
 * @package App\Repositories
 */
class CommentRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Получить коллекцию комментариев.
     *
     *
     * @return Model
     */
    public function getComments($columns = '*')
    {
        return $this->startConditions()->all($columns);
    }

    /**
     * Получить коллекцию комментариев для компании.
     *
     *
     * @return Collection
     */
    public function getCommentsForCompany($id, $columns = '*')
    {
        return $this->startConditions()
            ->where('company_id', $id)
            ->get($columns);
    }

    /**
     * Получить общую оценку компании.
     *
     * @param $id
     * @return mixed
     */
    public function getRateForCompany($id)
    {
        return $this->startConditions()
            ->where('company_id', $id)
            ->avg('rating');
    }


    /**
     * Получить сущность комментария.
     *
     *
     * @return Model
     */
    public function getComment($id, $columns = '*')
    {
        return $this->startConditions()->find($id, $columns);
    }


}
