<?php

namespace MPWT\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MPWT\Exceptions\Contracts\Handler as ContractsHandler;
use MPWT\Exceptions\Contracts\ReportIdentifier as ContractsReportIdentifier;
use MPWT\Exceptions\Traits\HandleException;
use MPWT\Http\Traits\HasAfterRepsponseCallback;
use MPWT\Http\Traits\HasRequestFingerPrint;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ContractsHandler
{

    use HandleException, HasAfterRepsponseCallback, HasRequestFingerPrint;

    public function reportException(Request $request, Throwable $th): Response
    {

        // generate bug report
        $content = $this->generateReport($request, $th);

        // generate identifier
        $identifier = $this->generateIdentifier($request, $th);

        // store report
        $this->storeReport($identifier, $content);

        // notify
        $this->notify($identifier);

        // return json response
        return match (true) {
            $th instanceof ValidationException => $this->invalidJson($request, $th),
            default => response()->json([
                'report_id'  => $identifier->id,
                'messages' => [
                    "An error has occured while processing $identifier->routeName.",
                    "The error report has been sent to our technical team.",
                    "Please be patient."
                ],
                'confidential' => $identifier
            ], 500)
        };
    }

    protected function generateReport(Request $request, Throwable $th)
    {
        // get configured debug mode
        $originalState = config('app.debug');

        // enable debug mode
        config(['app.debug' => 1]);

        // get html bug report page content
        $content = $this->toIlluminateResponse(
            $this->convertExceptionToResponse($th),
            $th
        )->prepare($request)
            ->getContent();

        // reset debug mode
        config(['app.debug' => $originalState]);

        return $content;
    }

    protected function generateIdentifier(Request $request, Throwable $th): ContractsReportIdentifier
    {
        $routeName          = $request->route()->getName();
        $hasAppFingerPrint  = app()->offsetExists('fingerPrint');
        $appFingerPrint     = $hasAppFingerPrint ? app()->fingerPrint : 0;

        $appName            = env('APP_NAME');
        $routeName          = $routeName ? strtoupper($routeName) : 'YOUR REQUEST';
        $errorClass         = get_class($th);
        $errorFile          = $th->getFile() . " " . $th->getLine();
        $errorMessage       = $th->getMessage();
        $errorCode          = $th->getCode();
        $fingerPrint        = $hasAppFingerPrint ? $appFingerPrint : $this->getFingerPrint($request);
        $fullUrl            =  $request->fullUrl();

        $reportIdentifier = new ReportIdentifier(
            $appName,
            $routeName,
            $errorClass,
            $errorFile,
            $errorMessage,
            $errorCode,
            $fingerPrint,
            $fullUrl,
            $hasAppFingerPrint
        );

        return $reportIdentifier;
    }

    protected function storeReport(ContractsReportIdentifier $identifier, string $content): void
    {
        $this->addMPWTAfterResponseCallbacks(function () use ($identifier, $content) {
            // save bug report to storage, will be deleted after notify
            file_put_contents($identifier->getFullFileName(), $content);
        });
    }

    protected function notify(ContractsReportIdentifier $identifier) : void
    {
        $this->addMPWTAfterResponseCallbacks(function () use ($identifier) {
            // prepare notify channel
            $token      = 'bot7075135649:AAGGwZNm7C_Vh5mFjEffuseBlTxwdtNDj7U';
            $telegram   = "https://api.telegram.org/$token";
            $chatId     = 701891228;

            // prepare notify identifier message
            $json = json_encode($identifier, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $text = "```json $json```";

            // notify
            $res = `curl --location '$telegram/sendMessage' --form 'chat_id=$chatId' --form 'text=$text' --form 'parse_mode=markdown'`;
            $json = json_decode($res);

            if ($json->ok) {
                // will send bug report file to reply to identifier message
                $messageId = $json->result->message_id;

                // get file name
                $fullFilename = $identifier->getFullFileName();

                // prepare caption
                $caption = $identifier->errorMessage;

                // notify
                $res = `curl --location '$telegram/sendDocument?chat_id=$chatId&parse_mode=markdown' --form 'document=@"$fullFilename"' --form 'caption="$caption"' --form 'reply_to_message_id=$messageId'`;
                $json = json_decode($res);

                if ($json->ok) {
                    // delete bug report file from storage
                    // unlink($fullFilename);
                }
            }
        });
    }
}
