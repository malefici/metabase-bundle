<?php

namespace Malefici\Symfony\MetabaseBundle\Twig;

use Malefici\Symfony\MetabaseBundle\Embedding\EmbedTypeEnum;
use Malefici\Symfony\MetabaseBundle\Embedding\UrlGenerator;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MetabaseExtension extends AbstractExtension
{
    public function __construct(readonly UrlGenerator $linkGenerator)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('metabase_embedded', $this->renderIframe(...), ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    private function renderIframe(Environment $env, string $type, int $id, array $embeddingParams = [], array $templateParams = []): string
    {
        if (null === ($enumType = EmbedTypeEnum::tryFrom($type))) {
            throw new \InvalidArgumentException(sprintf('Unknown embedding type "%s"', $type));
        }

        $iframeUrl = $this->linkGenerator->generate($enumType, $id, $embeddingParams);

        return $env
            ->load('@Metabase/iframe.html.twig')
            ->renderBlock('metabase_iframe', array_merge(['iframe_url' => $iframeUrl], $templateParams));
    }
}
