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

class UrlGenerator
{
    public function __construct(
        private readonly TokenGenerator $tokenGenerator,
        private string $siteUrl,
        private array $appearance
    ) {
    }

    public function getSiteUrl(): string
    {
        return $this->siteUrl;
    }

    public function setSiteUrl(string $siteUrl): UrlGenerator
    {
        $this->siteUrl = $siteUrl;

        return $this;
    }

    public function getAppearance(): array
    {
        return $this->appearance;
    }

    public function setAppearance(array $appearance): UrlGenerator
    {
        $this->appearance = $appearance;

        return $this;
    }

    public function generate(EmbedType $embeddingType, int $id, array $params = [], ?\DateTimeImmutable $expiration = null): string
    {
        $jwt = $this->tokenGenerator->generate($embeddingType, $id, $params, $expiration);

        $appearanceParams = [
            'bordered' => (bool) $this->appearance['border'],
            'titled' => (bool) $this->appearance['title'],
        ];

        $theme = IframeTheme::from($this->appearance['theme']);
        if ($theme->value !== IframeTheme::light->value) { // don't add param if theme is light
            $appearanceParams['theme'] = $theme->name;
        }

        return sprintf('%s/embed/%s/%s#%s', $this->siteUrl, $embeddingType->value, $jwt, http_build_query($appearanceParams));
    }
}
