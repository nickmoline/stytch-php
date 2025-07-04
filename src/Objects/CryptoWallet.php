<?php

namespace Stytch\Objects;

class CryptoWallet
{
    public function __construct(
        public string $crypto_wallet_id,
        public string $crypto_wallet_address,
        public string $crypto_wallet_type,
        public bool $verified,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            crypto_wallet_id: $data['crypto_wallet_id'],
            crypto_wallet_address: $data['crypto_wallet_address'],
            crypto_wallet_type: $data['crypto_wallet_type'],
            verified: $data['verified'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'crypto_wallet_id' => $this->crypto_wallet_id,
            'crypto_wallet_address' => $this->crypto_wallet_address,
            'crypto_wallet_type' => $this->crypto_wallet_type,
            'verified' => $this->verified,
        ];
    }
}
