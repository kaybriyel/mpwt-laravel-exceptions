<?php

namespace MPWT\Exceptions\Traits;

use Illuminate\Support\Facades\Log;
use MPWT\Exceptions\Contracts\Traits\CanNotifyBugReport;
use MPWT\Exceptions\Contracts\ReportIdentifier;

trait NotifyBugReport
{
    use CanNotifyBugReport, Notifiable;

    /** {@inheritdoc} */
    protected function notifyBugReport(ReportIdentifier $identifier): void
    {
        $channel    = $this->channel('telegram', 'bot7075135649:AAGGwZNm7C_Vh5mFjEffuseBlTxwdtNDj7U');
        $reciever   = 701891228;

        // prepare message
        $json = json_encode($identifier, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $text = "```json $json```";
        $form = [
            "chat_id=$reciever",
            "'text=$text'",
            "parse_mode=markdown"
        ];

        // send report identier
        $res  = $this->notify($channel, $form);
        $json = json_decode($res);

        // will send bug report file
        if ($json && $json->ok) {
            // replying to previous message
            $replyToMessageId = $json->result->message_id;

            // get file name
            $fullFilename = $identifier->getFullFileName();

            // prepare message
            $form = [
                "chat_id=$reciever",
                "parse_mode=markdown",
                "reply_to_message_id=$replyToMessageId",
                "'document=@\"$fullFilename\"'",
                "'caption=\"$identifier->errorMessage\"'"
            ];

            // send bug report file
            $res = $this->notify($channel, $form, true);
            $json = json_decode($res);

            if ($json && $json->ok) {
                // delete bug report file from storage
                unlink($fullFilename);
                return;
            }
        }

        // if code reach here, sending telegram fails.
        $des = $json ? $json->description : $json;
        Log::error("Telegram $des", ['res' => $json]);
    }
}
