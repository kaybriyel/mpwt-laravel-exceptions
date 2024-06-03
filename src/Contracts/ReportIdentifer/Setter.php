<?php

namespace MPWT\Exceptions\Contracts\ReportIdentifer;

trait Setter
{
    /** Set the report id.
     *
     * @param string $id The report id
     * @return void
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /** Set the app name.
     *
     * @param string $appName The app name
     * @return void
     */
    public function setAppName(string $appName): void
    {
        $this->appName = $appName;
    }

    /** Set the error class.
     *
     * @param string $errorClass The error class
     * @return void
     */
    public function setErrorClass(string $errorClass): void
    {
        $this->errorClass = $errorClass;
    }

    /** Set the error file.
     *
     * @param string $errorFile The error file
     * @return void
     */
    public function setErrorFile(string $errorFile): void
    {
        $this->errorFile = $errorFile;
    }

    /** Set the error message.
     *
     * @param string $errorMessage The error message
     * @return void
     */
    public function setErrorMessage(string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    /** Set the error code.
     *
     * @param int $errorCode The error code
     * @return void
     */
    public function setErrorCode(int $errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    /** Set the route name.
     *
     * @param string $routeName The route name
     * @return void
     */
    public function setRouteName(string $routeName): void
    {
        $this->routeName = $routeName;
    }

    /** Set the finger print.
     *
     * @param string $fingerPrint The finger print
     * @return void
     */
    public function setFingerPrint(string $fingerPrint): void
    {
        $this->fingerPrint = $fingerPrint;
    }

    /** Set the full url.
     *
     * @param string $fullUrl The full url
     * @return void
     */
    public function setFullUrl(string $fullUrl): void
    {
        $this->fullUrl = $fullUrl;
    }

    /** Set the has app finger print flag.
     *
     * @param bool $hasAppFingerPrint The has app finger print flag
     * @return void
     */
    public function setHasAppFingerPrint(bool $hasAppFingerPrint): void
    {
        $this->hasAppFingerPrint = $hasAppFingerPrint;
    }
}
