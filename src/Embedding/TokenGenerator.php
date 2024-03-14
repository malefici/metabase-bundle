<?php

namespace Malefici\Symfony\MetabaseBundle\Embedding;

use Firebase\JWT\JWT;

use function Symfony\Component\Clock\now;

class TokenGenerator
{
    public function __construct(
        private readonly string $metabaseSecretKey,
        private string $tokenExpirationModifier = ''
    ) {
    }

    public function getTokenExpirationModifier(): string
    {
        return $this->tokenExpirationModifier;
    }

    public function setTokenExpirationModifier(string $tokenExpirationModifier): TokenGenerator
    {
        $this->tokenExpirationModifier = $tokenExpirationModifier;

        return $this;
    }

    public function generate(EmbedTypeEnum $embeddingType, int $id, array $params = [], ?\DateTimeImmutable $expiration = null): string
    {
        $payload = [
            'resource' => [
                $embeddingType->value => $id,
            ],
            'params' => (object) $params, // because here must be an object
            'exp' => (null === $expiration ? now($this->tokenExpirationModifier) : $expiration)->getTimestamp(),
        ];

        return JWT::encode($payload, $this->metabaseSecretKey, 'HS256');
    }
}
