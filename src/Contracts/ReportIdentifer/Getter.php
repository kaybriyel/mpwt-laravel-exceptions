<?php

namespace MPWT\Exceptions\Contracts\ReportIdentifer;

trait Getter
{
    /** Get the report id.
     *
     * @return string The report id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /** Get the app name.
     *
     * @return string The app name
     */
    public function getAppName(): string
    {
        return $this->appName;
    }

    /** Get the error class.
     *
     * @return string The error class
     */
    public function getErrorClass(): string
    {
        return $this->errorClass;
    }

    /** Get the error file.
     *
     * @return string The error file
     */
    public function getErrorFile(): string
    {
        return $this->errorFile;
    }

    /** Get the error message.
     *
     * @return string The error message
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /** Get the error code.
     *
     * @return int The error code
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /** Get the route name.
     *
     * @return string The route name
     */
    public function getRouteName(): string
    {
        return $this->routeName;
    }

    /** Get the finger print.
     *
     * @return string The finger print
     */
    public function getFingerPrint(): string
    {
        return $this->fingerPrint;
    }

    /** Get the full url.
     *
     * @return string The full url
     */
    public function getFullUrl(): string
    {
        return $this->fullUrl;
    }

    /** Get the has app finger print flag.
     *
     * @return bool The has app finger print flag
     */
    public function getHasAppFingerPrint(): bool
    {
        return $this->hasAppFingerPrint;
    }
}
