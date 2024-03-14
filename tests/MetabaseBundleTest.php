<?php

namespace Malefici\Symfony\MetabaseBundle\Tests;

use Malefici\Symfony\MetabaseBundle\DependencyInjection\MetabaseExtension;
use Malefici\Symfony\MetabaseBundle\Metabase\EmbeddingTypeEnum;
use Malefici\Symfony\MetabaseBundle\Metabase\UrlGenerator;
use Malefici\Symfony\MetabaseBundle\MetabaseBundle;
use PHPUnit\Framework\TestCase;

class MetabaseBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new MetabaseBundle();
        $this->assertInstanceOf(MetabaseExtension::class, $bundle->getContainerExtension());
    }

    public function testLinkGeneratorForQuestion(): void
    {
        $linkGenerator = new UrlGenerator('http://example.org', 'secret', '+1 hour', true, true, 'light');

        $this->assertEquals(
            'http://example.org/embed/question/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyZXNvdXJjZSI6eyJxdWVzdGlvbiI6MX0sInBhcmFtcyI6e30sImV4cCI6eyJkYXRlIjoiMjAyNC0wMS0wMSAwMDowMDowMS4wMDAwMDAiLCJ0aW1lem9uZV90eXBlIjozLCJ0aW1lem9uZSI6IlVUQyJ9fQ.TV7zfbC7U0TZ_hdV98YkWvTVZ7wd93kyLT1swxAjKO4#bordered=1&titled=1',
            $linkGenerator->generate(EmbeddingTypeEnum::question, 1, [], new \DateTimeImmutable('2024-01-01 00:00:01'))
        );
    }

    public function testLinkGeneratorForDashboard(): void
    {
        $linkGenerator = new UrlGenerator('http://example.org', 'secret', '+1 hour', true, true, 'light');

        $this->assertEquals(
            'http://example.org/embed/dashboard/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyZXNvdXJjZSI6eyJkYXNoYm9hcmQiOjF9LCJwYXJhbXMiOnsiaWQiOjF9LCJleHAiOnsiZGF0ZSI6IjIwMjQtMDEtMDEgMDA6MDA6MDEuMDAwMDAwIiwidGltZXpvbmVfdHlwZSI6MywidGltZXpvbmUiOiJVVEMifX0.Kr-y21F0wztFeEha_1LIUasDApBlh3Wze_CE_0cNe_U#bordered=1&titled=1',
            $linkGenerator->generate(EmbeddingTypeEnum::dashboard, 1, ['id' => 1], new \DateTimeImmutable('2024-01-01 00:00:01'))
        );
    }
}
