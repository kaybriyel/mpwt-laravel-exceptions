<?php

namespace MPWT\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

trait Handler
{

    use HandleException;

    /**
     * Convert an exception into HTML content and store for later review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $th
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function reportException(Request $request, Throwable $th)
    {
        // generate report
        $content = $this->generateReport($request, $th);

        // store debug page
        $this->storeReport($content);

        // return json response

        if ($th instanceof ValidationException)
            return $this->invalidJson($request, $th);
        else
            return response()->json([
                'message' => 'Server Error'
            ], 500);
    }

    /**
     * Convert an exception into HTML content
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return string|false
     *
     * @throws \Throwable
     */
    private function generateReport(Request $request, Throwable $th)
    {
        // get configured debug mode
        $originalState = config('app.debug');

        // enable debug mode
        config(['app.debug' => 1]);

        // get html debug error page content
        $content = $this->toIlluminateResponse(
            $this->convertExceptionToResponse($th),
            $th
        )->prepare($request)
            ->getContent();

        // reset debug mode
        config(['app.debug' => $originalState]);

        return $content;
    }

    /**
     * Save the generated HTML content
     * 
     * @param string $content
     * @return void
     */
    private function storeReport(string $content)
    {
        $contextId = app()->offsetExists('context_id') ? app()->context_id : time();
        $dir = 'exception-reports';

        if (!Storage::disk('local')->exists($dir)) {
            Storage::disk('local')->makeDirectory($dir);
        }

        file_put_contents(storage_path("app/$dir/$contextId.html"), $content);
    }
}
