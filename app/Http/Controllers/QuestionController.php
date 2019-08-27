<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\QuestionCreateRequest;
use App\Http\Requests\Question\QuestionUpdateRequest;
use App\Http\Responses\QuestionCollectionResponse;
use App\Http\Responses\QuestionResponse;
use App\Question;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('question');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Question $model
     * @return QuestionCollectionResponse|JsonResponse
     */
    public function index(Request $request, Question $model)
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = $model->paginate($request->input('limit'))->appends($request->query());
        $questions = $paginator->getCollection();

        return new QuestionCollectionResponse($questions, $paginator);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionCreateRequest $request
     * @param Question $model
     * @return QuestionResponse|JsonResponse
     */
    public function store(QuestionCreateRequest $request, Question $model)
    {
        $question = $model->create($request->all());

        return new QuestionResponse($question);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return QuestionResponse|JsonResponse
     */
    public function show(Question $question)
    {
        return new QuestionResponse($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuestionUpdateRequest $request
     * @param Question $question
     * @return QuestionResponse|JsonResponse
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        $question->update($request->all());

        return new QuestionResponse($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return Response
     * @throws Exception
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
