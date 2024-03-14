<?php

/*
 * This file is part of the malefici/metabase-bundle package.
 *
 * (c) Malefici <nikita@malefici.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Malefici\Symfony\MetabaseBundle\Tests;

use Malefici\Symfony\MetabaseBundle\DependencyInjection\MetabaseExtension;
use Malefici\Symfony\MetabaseBundle\Embedding\EmbedType;
use Malefici\Symfony\MetabaseBundle\Embedding\TokenGenerator;
use Malefici\Symfony\MetabaseBundle\Embedding\UrlGenerator;
use Malefici\Symfony\MetabaseBundle\MetabaseBundle;
use PHPUnit\Framework\TestCase;

class MetabaseBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new MetabaseBundle();
        $this->assertInstanceOf(MetabaseExtension::class, $bundle->getContainerExtension());
    }

    public function testTokenGenerator(): void
    {
        $tokenGenerator = self::createTokenGenerator();

        $this->assertEquals(
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyZXNvdXJjZSI6eyJxdWVzdGlvbiI6MX0sInBhcmFtcyI6e30sImV4cCI6MTcwNDA2NzIwMX0.fLNHkCMQMBc7MDhYvlIGgglwPVu4rmVasoFqa-2QFDM',
            $tokenGenerator->generate(EmbedType::question, 1, [], new \DateTimeImmutable('2024-01-01 00:00:01'))
        );
    }

    public function testUrlGeneratorForQuestion(): void
    {
        $tokenGenerator = self::createTokenGenerator();
        $linkGenerator = new UrlGenerator($tokenGenerator, 'https://example.org', ['border' => false, 'title' => false, 'theme' => 'light']);

        $this->assertEquals(
            'https://example.org/embed/question/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyZXNvdXJjZSI6eyJxdWVzdGlvbiI6MX0sInBhcmFtcyI6e30sImV4cCI6MTcwNDA2NzIwMX0.fLNHkCMQMBc7MDhYvlIGgglwPVu4rmVasoFqa-2QFDM#bordered=0&titled=0',
            $linkGenerator->generate(EmbedType::question, 1, [], new \DateTimeImmutable('2024-01-01 00:00:01'))
        );
    }

    public function testUrlGeneratorForDashboard(): void
    {
        $tokenGenerator = self::createTokenGenerator();
        $linkGenerator = new UrlGenerator($tokenGenerator, 'https://example.org', ['border' => true, 'title' => true, 'theme' => 'dark']);

        $this->assertEquals(
            'https://example.org/embed/dashboard/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyZXNvdXJjZSI6eyJkYXNoYm9hcmQiOjF9LCJwYXJhbXMiOnsiaWQiOjF9LCJleHAiOjE3MDQwNjcyMDF9.9v2JRFFSIVgAfbHBZMhBynVQ58ZtbFPOZuwdc5PSYJs#bordered=1&titled=1&theme=night',
            $linkGenerator->generate(EmbedType::dashboard, 1, ['id' => 1], new \DateTimeImmutable('2024-01-01 00:00:01'))
        );
    }

    public function testWrongDateModifier(): void
    {
        $tokenGenerator = clone self::createTokenGenerator();
        $tokenGenerator->setTokenExpirationModifier('+TWENTY days');

        $this->expectException(\DateMalformedStringException::class);
        $tokenGenerator->generate(EmbedType::dashboard, 1);
    }

    public function testWrongTheme(): void
    {
        $tokenGenerator = self::createTokenGenerator();
        $linkGenerator = new UrlGenerator($tokenGenerator, 'https://example.org', ['border' => true, 'title' => true, 'theme' => 'yellow']);

        $this->expectException(\ValueError::class);
        $linkGenerator->generate(EmbedType::dashboard, 1, ['id' => 1]);
    }

    private static function createTokenGenerator(): TokenGenerator
    {
        return new TokenGenerator(
            '76ff41a84ed1c6b294528b8339ab357173c020d767119c571d931eae27bd07d5',
        );
    }
}
