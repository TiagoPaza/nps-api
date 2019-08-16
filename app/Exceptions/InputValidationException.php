<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InputValidationException extends Exception
{
    protected $code = 400;
    protected $title;
    protected $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function render()
    {
        $errors = array_map(function ($attribute, $violation) {
            if (request()->route()->getPrefix() === 'api/v1/en') {
                $this->title = 'Invalid input data.';
            } else {
                $this->title = 'O dado informado está incorreto.';
            }

            return [
                'code' => $this->code,
                'title' => $this->title,
                'source' => [
                    'pointer' => '/' . str_replace('.', '/', $attribute)
                ],
                'detail' => $violation
            ];
        }, array_keys($this->errors), $this->errors);

        return response()->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
    }
}
