<?php

namespace Stytch\Objects\Response;

class M2MClientResponse extends Response
{
    public M2MClient $m2m_client;

    public function __construct(
        string $request_id,
        int $status_code,
        M2MClient $m2m_client,
    ) {
        parent::__construct($request_id, $status_code);
        $this->m2m_client = $m2m_client;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            request_id: $data['request_id'],
            status_code: $data['status_code'],
            m2m_client: M2MClient::fromArray($data['m2m_client']),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'm2m_client' => $this->m2m_client->toArray(),
        ]);
    }
}
