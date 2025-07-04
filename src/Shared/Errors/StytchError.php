<?php

namespace Stytch\Shared\Errors;

class StytchError extends \RuntimeException
{
    public int $status_code;
    public string $request_id;
    public string $error_type;
    public string $error_message;
    public string $error_url;
    /** @var array<string, mixed>|null */
    public ?array $error_details;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        if (isset($data['error'])) {
            $this->status_code = $data['status_code'];
            $this->request_id = $data['request_id'];
            $this->error_type = $data['error'];
            $this->error_message = $data['error_description'];
            $this->error_url = $data['error_uri'];
        } else {
            $this->status_code = $data['status_code'];
            $this->request_id = $data['request_id'];
            $this->error_type = $data['error_type'];
            $this->error_message = $data['error_message'];
            $this->error_url = $data['error_url'];
            $this->error_details = $data['error_details'] ?? null;
        }

        $jsonMessage = json_encode($data);
        parent::__construct($jsonMessage !== false ? $jsonMessage : 'Stytch error occurred');
    }
}
