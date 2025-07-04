<?php

namespace Stytch\Shared\Errors;

class ClientError extends \RuntimeException
{
    public string $error_code;
    /** @var mixed */
    public $cause;

    /**
     * @param mixed $cause
     */
    public function __construct(string $code, string $message, $cause = null)
    {
        $msg = "{$code}: {$message}";
        if ($cause) {
            $msg .= ": " . (string) $cause;
        }
        parent::__construct($msg);
        $this->error_code = $code;
        $this->cause = $cause;
    }
}
