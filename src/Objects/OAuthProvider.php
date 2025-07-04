<?php

namespace Stytch\Objects;

class OAuthProvider
{
    public function __construct(
        public string $provider_type,
        public string $provider_subject,
        public string $oauth_user_registration_id,
        public ?string $profile_picture_url = null,
        public ?string $locale = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            provider_type: $data['provider_type'],
            provider_subject: $data['provider_subject'],
            oauth_user_registration_id: $data['oauth_user_registration_id'],
            profile_picture_url: $data['profile_picture_url'] ?? null,
            locale: $data['locale'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'provider_type' => $this->provider_type,
            'provider_subject' => $this->provider_subject,
            'oauth_user_registration_id' => $this->oauth_user_registration_id,
        ];

        if ($this->profile_picture_url) {
            $data['profile_picture_url'] = $this->profile_picture_url;
        }
        if ($this->locale) {
            $data['locale'] = $this->locale;
        }

        return $data;
    }
}
