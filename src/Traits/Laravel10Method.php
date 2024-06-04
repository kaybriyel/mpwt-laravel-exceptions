<?php

namespace MPWT\Exceptions\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

trait Laravel10Method
{
    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function invalidJson(Request $request, ValidationException $exception)
    {
        return response()->json([
            'message' => $this->summarize($exception->validator),
            'errors' => $exception->validator->getMessageBag(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Create an error message summary from the validation errors.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return string
     */
    private function summarize($validator)
    {
        $messages = $validator->getMessageBag()->all();

        if (!count($messages) || !is_string($messages[0])) {
            return $validator->getTranslator()->trans('The given data was invalid.');
        }

        $message = array_shift($messages);

        if ($count = count($messages)) {
            $pluralized = $count === 1 ? 'error' : 'errors';

            $message .= ' ' . $validator->getTranslator()->trans("(and :count more $pluralized)", compact('count'));
        }

        return $message;
    }
}
