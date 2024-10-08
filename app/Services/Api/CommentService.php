<?php

namespace App\Services\Api;


use App\Models\Comment;
use App\Repositories\CommentRepository;
use Exception;

class CommentService
{
    private mixed $commentRepository;


    public function __construct()
    {
        $this->commentRepository = app(CommentRepository::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = [
            'id',
            'user_id',
            'company_id',
            'content',
            'rating',
        ];
        $comments = $this->commentRepository->getComments($columns);

        if ($comments) {
            return response()->json(['success' => true, $comments]);
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
        // Ловим ошибку на уникальность, убрать этот блок отлова ошибок при логике, не допускающей дубля связки user_company в comments
        try
        {
            Comment::create($data);
        }
        catch(Exception $e)
        {
            if($e->getCode() === '23000')
                return response()->json(['success' => false, 'message' => 'Данный пользователь уже создал комментарий по этой компании'], 500);
            app()->make(\App\Exceptions\Handler::class)->report($e); // Report the exception if you don't know what actually caused it
            return response()->json(['success' => false, 'message' => 'Ошибка сохранения данных'], 500);
        }
        return response()->json(['success' => true, 'message' => 'Данные успешно сохранены']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $columns = [
            'id',
            'user_id',
            'company_id',
            'content',
            'rating',
        ];
        $comment = $this->commentRepository->getComment($id, $columns);
        if ($comment) {
            return response()->json(['success' => true, $comment]);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка получения данных'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, string $id)
    {

        $comment = $this->commentRepository->getComment($id);

        $data = $request->validated();
        if($id !== $data['id']) return response()->json(['success' => false, 'message' => 'Ошибка обновления данных'], 500);
        try
        {
            $comment->update($data);
        }
        catch(Exception $e)
        {
            if($e->getCode() === '23000')
                return response()->json(['success' => false, 'message' => 'Данный пользователь уже создал комментарий по этой компании'], 500);
            app()->make(\App\Exceptions\Handler::class)->report($e); // Report the exception if you don't know what actually caused it
            return response()->json(['success' => false, 'message' => 'Ошибка обновления данных'], 500);
        }
        return response()->json(['success' => true, 'message' => 'Данные успешно обновлены']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $comment = $this->commentRepository->getComment($id);

        if($comment) {
            $comment->delete();
            return response()->json(['success' => true, 'message' => 'Данные успешно удалены']);
        } else {
            return response()->json(['success' => false, 'message' => 'Ошибка удаления данных'], 500);
        }
    }

}
