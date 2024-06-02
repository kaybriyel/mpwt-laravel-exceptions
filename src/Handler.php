<?php

namespace MPWT\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionsHandler;
use Illuminate\Validation\ValidationException;
use MPWT\Exceptions\Contracts\Handler as ContractsHandler;
use MPWT\Exceptions\Contracts\ReportIdentifier;
use MPWT\Exceptions\Supports\Laravel10Method;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionsHandler
{
    use ContractsHandler, HandleException, GenerateBugReport, NotifyBugReport, Laravel10Method;

    /**
     * Report exception
     *
     * @param  \Throwable  $th
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function handle(Throwable $th): Response
    {
        $request = request();

        // generate identifier
        $identifier = $this->generateIdentifier($request, $th);

        // process later after response
        $this->addMPWTAfterResponseCallbacks(function () use ($identifier, $request, $th) {
            // generate bug report
            $content = $this->generateReport($request, $th);

            // store report
            $this->storeReport($identifier, $content);

            // notify
            $this->notifyBugReport($identifier);
        });

        // return reasonable json response
        if ($th instanceof ValidationException) {
            return $this->invalidJson($request, $th);
        }

        return $this->reasonableResponse($identifier);
    }

    /**
     * Response short meaningful message
     *
     * @param \MPWT\Exceptions\Contracts\ReportIdentifier $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function reasonableResponse(ReportIdentifier $identifier): Response
    {
        return response()->json([
            'report_id'  => $identifier->id,
            'messages' => [
                "An error has occured while processing $identifier->routeName.",
                "The error report has been sent to our technical team.",
                "Please be patient."
            ]
            // 'confidential' => $identifier
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
