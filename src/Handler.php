<?php

namespace MPWT\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MPWT\Exceptions\Contracts\Handler as ContractsHandler;
use MPWT\Exceptions\Contracts\ReportIdentifier;
use MPWT\Exceptions\Traits\GenerateBugReport;
use MPWT\Exceptions\Traits\Laravel10Method;
use MPWT\Exceptions\Traits\NotifyBugReport;
use MPWT\Http\Traits\CanExecuteAfterResponse;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ContractsHandler
{
    use GenerateBugReport, NotifyBugReport, CanExecuteAfterResponse, Laravel10Method;

    /** {@inheritdoc} */
    public function handle(\Throwable $th): Response
    {
        $request = request();

        // generate identifier
        $identifier = $this->generateIdentifier($request, $th);

        // process later after response
        $this->handleAfterResponse($identifier, $request, $th);

        // return reasonable json response
        return match (true) {
            $th instanceof ValidationException => $this->invalidJson($request, $th),
            default => $this->reasonableResponse($identifier)
        };
    }

    /** {@inheritdoc} */
    protected function handleAfterResponse(ReportIdentifier $identifier, Request $request, \Throwable $th): void
    {
        $this->addMPWTAfterResponseCallbacks(function () use ($identifier, $request, $th) {
            // generate bug report
            $content = $this->generateReport($request, $th);

            // store report
            $this->storeReport($identifier, $content);

            // notify
            $this->notifyBugReport($identifier);
        });
    }

    /** {@inheritdoc} */
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
