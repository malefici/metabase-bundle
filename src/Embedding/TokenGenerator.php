<?php

/*
 * This file is part of the malefici/metabase-bundle package.
 *
 * (c) Malefici <nikita@malefici.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Malefici\Symfony\MetabaseBundle\Embedding;

use Firebase\JWT\JWT;

use function Symfony\Component\Clock\now;

class TokenGenerator
{
    public function __construct(
        private readonly string $metabaseSecretKey,
        private string $tokenExpirationModifier = 'now'
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

    public function generate(EmbedType $embeddingType, int $id, array $params = [], ?\DateTimeImmutable $expiration = null): string
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
