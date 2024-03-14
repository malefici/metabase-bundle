<?php

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

    public function generate(EmbedTypeEnum $embeddingType, int $id, array $params = [], ?\DateTimeImmutable $expiration = null): string
    {
        $jwt = $this->tokenGenerator->generate($embeddingType, $id, $params, $expiration);

        $appearanceParams = [
            'bordered' => (bool) $this->appearance['border'],
            'titled' => (bool) $this->appearance['title'],
        ];

        $theme = IframeThemeEnum::tryFrom($this->appearance['theme']);
        if ($theme->value !== IframeThemeEnum::light->value) { // don't add param if theme is light
            $appearanceParams['theme'] = $theme->name;
        }

        return sprintf('%s/embed/%s/%s#%s', $this->siteUrl, $embeddingType->value, $jwt, http_build_query($appearanceParams));
    }
}
