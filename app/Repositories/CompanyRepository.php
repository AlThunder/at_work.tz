<?php

namespace App\Repositories;

use App\Models\Company as Model;

/**
 * Class CompanyRepository
 *
 * @package App\Repositories
 */
class CompanyRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Получить коллекцию компаний.
     *
     *
     * @return Model
     */
    public function getCompanies($columns = '*')
    {
        return $this->startConditions()->all($columns);
    }

    /**
     * Получить сущность компании.
     *
     *
     * @return Model
     */
    public function getCompany($id, $columns = '*')
    {
        return $this->startConditions()->find($id, $columns);
    }

    public function getTopCompaniesRated($limit, $columns = '*')
    {
        return $this->startConditions()
            ->select($columns)
            ->withAvg('comments', 'rating')
            ->orderBy('comments_avg_rating', 'desc')
            ->limit($limit)
            ->get();
    }


}
