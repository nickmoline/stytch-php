<?php

namespace Stytch\Objects\Response;

class M2MClientsResponse extends Response
{
    /** @var array<M2MClient> */
    public array $m2m_clients;
    /** @var array<string, mixed> */
    public array $results_metadata;

    /**
     * @param array<M2MClient> $m2m_clients
     * @param array<string, mixed> $results_metadata
     */
    public function __construct(
        string $request_id,
        int $status_code,
        array $m2m_clients,
        array $results_metadata,
    ) {
        parent::__construct($request_id, $status_code);
        $this->m2m_clients = $m2m_clients;
        $this->results_metadata = $results_metadata;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            request_id: $data['request_id'],
            status_code: $data['status_code'],
            m2m_clients: array_map(fn($client) => M2MClient::fromArray($client), $data['m2m_clients'] ?? []),
            results_metadata: $data['results_metadata'] ?? [],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'm2m_clients' => array_map(fn($client) => $client->toArray(), $this->m2m_clients),
            'results_metadata' => $this->results_metadata,
        ]);
    }
}
