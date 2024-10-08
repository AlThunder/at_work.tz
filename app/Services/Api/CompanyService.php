<?php

namespace App\Services\Api;


use App\Models\Company;
use App\Repositories\CommentRepository;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    private mixed $companyRepository;
    private mixed $commentRepository;


    public function __construct()
    {
        $this->companyRepository = app(CompanyRepository::class);
        $this->commentRepository = app(CommentRepository::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = [
            'id',
            'name',
            'description',
            'logo',
        ];
        $companies = $this->companyRepository->getCompanies($columns);

        if ($companies) {
            return response()->json(['success' => true, $companies]);
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
        $data['logo'] = $storage->put('/images/logos', $data['logo']);

        $company = Company::create($data);
        if ($company) {
            return response()->json(['success' => true, 'message' => 'Данные успешно сохранены']);
        } else {
            if($storage->exists($data['logo']))
                $storage->delete($data['logo']);
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
            'description',
            'logo',
        ];
        $company = $this->companyRepository->getCompany($id, $columns);
        if ($company) {
            return response()->json(['success' => true, $company]);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка получения данных'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, string $id)
    {
        $company = $this->companyRepository->getCompany($id);
        $old_logo = $company['logo'];
        $data = $request->validated();
        if($id !== $data['id']) return response()->json(['success' => false, 'message' => 'Ошибка обновления данных'], 500);
        $storage = Storage::disk('public');
        $data['logo'] = $storage->put('/images/logos', $data['logo']);

        $result = $company->update($data);
        if ($result) {
            if($storage->exists($old_logo))
                $storage->delete($old_logo); //при загрузке новых картинок удаляем старые
            return response()->json(['success' => true, 'Данные успешно обновлены']);
        } else {
            if($storage->exists($data['logo']))
                $storage->delete($data['logo']); // удаляем новую картинку, если запись в БД не обновилась
            return response()->json(['success' => false, 'message' => 'Ошибка сохранения'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $company = $this->companyRepository->getCompany($id);

        if($company) {
            $company->delete();
            return response()->json(['success' => true, 'message' => 'Данные успешно удалены']);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка удаления данных'], 500);
        }
    }

    public function getComments($id)
    {
        $columns = [
            'id',
            'user_id',
            'content',
        ];
        $comments = $this->commentRepository->getCommentsForCompany($id, $columns);
        if ($comments) {
            return response()->json(['success' => true, $comments]);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка получения данных'], 500);
        }
    }

    public function getRate($id)
    {
        $rate = $this->commentRepository->getRateForCompany($id);
        if ($rate) {
            return response()->json(['success' => true, 'rating' => $rate]);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка получения данных'], 500);
        }
    }

    public function getTopRated($limit)
    {
        $columns = [
            'id',
            'name',
            'description',
            'logo',
        ];
        $companies = $this->companyRepository->getTopCompaniesRated($limit, $columns);
        if ($companies) {
            return response()->json(['success' => true, 'rating' => $companies]);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка получения данных'], 500);
        }
    }

}
