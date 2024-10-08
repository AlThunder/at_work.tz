<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;

class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->service->companyService->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        return $this->service->companyService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->service->companyService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, string $id)
    {
        return $this->service->companyService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->service->companyService->destroy($id);
    }

    /**
     * Получить комментарии по компании
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComments($id)
    {
        return $this->service->companyService->getComments($id);
    }

    /**
     * Получить общую оценку компании
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRate($id)
    {
        return $this->service->companyService->getRate($id);
    }

    /**
     * Получить топ компаний по оценке
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopRated($limit)
    {
        return $this->service->companyService->getTopRated($limit);
    }
}
