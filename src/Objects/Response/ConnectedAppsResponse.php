<?php

namespace Stytch\Objects\Response;

class ConnectedAppsResponse extends Response
{
    /** @var array<string, mixed> */
    public array $connected_apps;

    /**
     * @param array<string, mixed> $connected_apps
     */
    public function __construct(
        string $request_id,
        int $status_code,
        array $connected_apps,
    ) {
        parent::__construct($request_id, $status_code);
        $this->connected_apps = $connected_apps;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            request_id: $data['request_id'],
            status_code: $data['status_code'],
            connected_apps: $data['connected_apps'] ?? [],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'connected_apps' => $this->connected_apps,
        ]);
    }
}
