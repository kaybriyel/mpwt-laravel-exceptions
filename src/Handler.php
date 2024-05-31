<?php

namespace MPWT\Exceptions;

use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use MPWT\Exceptions\Contracts\Handler as ContractsHandler;
use MPWT\Exceptions\Contracts\ReportIdentifier as ContractsReportIdentifier;
use MPWT\Exceptions\Traits\HandleException;
use MPWT\Exceptions\Traits\HasAfterRepsponseCallback;
use MPWT\Exceptions\Traits\HasRequestFingerPrint;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ContractsHandler
{

    use HandleException, HasAfterRepsponseCallback, HasRequestFingerPrint;

    public function reportException(Request $request, Throwable $th): Response
    {

        // generate report
        $content = $this->generateReport($request, $th);

        $identifier = $this->generateIdentifier($request, $th);

        // store debug page
        $this->storeReport($identifier, $content);

        $action = $identifier->route_name;

        // return json response
        return match (true) {
            $th instanceof ValidationException => $this->invalidJson($request, $th),
            default => response()->json([
                'report_id'  => $identifier->id,
                'messages' => [
                    "An error has occured while processing $action.",
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

    protected function generateIdentifier(Request $request, Throwable $th): ContractsReportIdentifier
    {

        $app_name = env('APP_NAME');

        $error_class = get_class($th);

        $error_file = $th->getFile() . " " . $th->getLine();

        $error_message = $th->getMessage();

        $error_code = $th->getCode();

        $route_name = $request->route()->getName();
        $route_name = $route_name ? strtoupper($route_name) : 'ERROR';

        $app_finger_print = app()->offsetExists('finger_print') ? app()->finger_print : 0;

        $has_app_finger_print = $app_finger_print !== 0;

        $finger_print = $app_finger_print ? $app_finger_print : $this->getFingerPrint($request);

        $full_url =  $request->fullUrl();

        $report_identifier = new ReportIdentifier(
            $app_name,
            $route_name,
            $error_class,
            $error_file,
            $error_message,
            $error_code,
            $finger_print,
            $full_url,
            $has_app_finger_print
        );

        return $report_identifier;
    }

    protected function storeReport(ContractsReportIdentifier $identifier, string $content): void
    {
        $this->addMPWTAfterResponseCallbacks(function () use ($identifier, $content) {
            $dir    = 'exception-reports';
            $name   = $identifier->id;

            if (!Storage::disk('local')->exists($dir)) {
                Storage::disk('local')->makeDirectory($dir);
            }

            $full_filename = storage_path("app/$dir/$name.html");

            file_put_contents($full_filename, $content);

            $token      = 'bot7075135649:AAGGwZNm7C_Vh5mFjEffuseBlTxwdtNDj7U';
            $telegram   = "https://api.telegram.org/$token";
            $chat_id    = 701891228;

            $json = json_encode($identifier, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $text = "```json $json```";
            $res = json_decode(`curl --location '$telegram/sendMessage' --form 'chat_id=$chat_id' --form 'text=$text' --form 'parse_mode=markdown'`);

            if ($res->ok) {
                $message_id = $res->result->message_id;

                $error_message = $identifier->error_message;
                $caption = "$error_message";

                $res = json_decode(`curl --location '$telegram/sendDocument?chat_id=$chat_id&parse_mode=markdown' --form 'document=@"$full_filename"' --form 'caption="$caption"' --form 'reply_to_message_id=$message_id'`);
                if ($res->ok) {
                    unlink($full_filename);
                }
            }
        });
    }

}
