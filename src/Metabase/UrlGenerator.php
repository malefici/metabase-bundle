<?php

namespace Malefici\Symfony\MetabaseBundle\Metabase;

use Firebase\JWT\JWT;

use function Symfony\Component\Clock\now;

readonly class UrlGenerator
{
    public function __construct(
        private string $siteUrl,
        private string $metabaseSecretKey,
        private string $tokenExpirationModifier,
        private string $border,
        private string $title,
        private string $theme
    ) {
    }

    public function generate(EmbeddingTypeEnum $embeddingType, int $id, array $params = [], ?\DateTimeImmutable $expiration = null)
    {
        $payload = [
            'resource' => [
                $embeddingType->value => $id,
            ],
            'params' => (object) $params, // because here must be an object
            'exp' => null === $expiration ? now($this->tokenExpirationModifier)->getTimestamp() : $expiration,
        ];

        $jwt = JWT::encode($payload, $this->metabaseSecretKey, 'HS256');

        $appearanceParams = [
            'bordered' => (bool) $this->border,
            'titled' => (bool) $this->title,
        ];

        $theme = EmbeddedThemeEnum::tryFrom($this->theme);
        if ($theme->value !== EmbeddedThemeEnum::light->value) {
            $appearanceParams['theme'] = $theme->value;
        }

        return sprintf('%s/embed/%s/%s#%s', $this->siteUrl, $embeddingType->value, $jwt, http_build_query($appearanceParams));
    }
}
