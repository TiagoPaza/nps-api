<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionReply\QuestionReplyCreateRequest;
use App\Http\Requests\QuestionReply\QuestionReplyUpdateRequest;
use App\Http\Responses\QuestionReplyCollectionResponse;
use App\Http\Responses\QuestionReplyResponse;
use App\QuestionReply;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param QuestionReply $model
     * @return QuestionReplyCollectionResponse|JsonResponse
     */
    public function index(Request $request, QuestionReply $model)
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = $model->paginate($request->input('limit'))->appends($request->query());
        $questionReplies = $paginator->getCollection();

        return new QuestionReplyCollectionResponse($questionReplies, $paginator);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionReplyCreateRequest $request
     * @param QuestionReply $model
     * @return QuestionReplyResponse|JsonResponse
     */
    public function store(QuestionReplyCreateRequest $request, QuestionReply $model)
    {
        $questionReply = $model->create($request->all());

        return new QuestionReplyResponse($questionReply);
    }

    /**
     * Display the specified resource.
     *
     * @param QuestionReply $questionReply
     * @return QuestionReplyResponse|JsonResponse
     */
    public function show(QuestionReply $questionReply)
    {
        return new QuestionReplyResponse($questionReply);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuestionReplyUpdateRequest $request
     * @param QuestionReply $questionReply
     * @return QuestionReplyResponse|JsonResponse
     */
    public function update(QuestionReplyUpdateRequest $request, QuestionReply $questionReply)
    {
        $questionReply->update($request->all());

        return new QuestionReplyResponse($questionReply);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param QuestionReply $questionReply
     * @return Response
     * @throws Exception
     */
    public function destroy(QuestionReply $questionReply)
    {
        $questionReply->delete();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
