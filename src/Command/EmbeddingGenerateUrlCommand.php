<?php

/*
 * This file is part of the malefici/metabase-bundle package.
 *
 * (c) Malefici <nikita@malefici.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Malefici\Symfony\MetabaseBundle\Command;

use Malefici\Symfony\MetabaseBundle\Embedding\EmbedType;
use Malefici\Symfony\MetabaseBundle\Embedding\UrlGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EmbeddingGenerateUrlCommand extends Command
{
    private UrlGenerator $linkGenerator;

    public function __construct(UrlGenerator $tokenGenerator)
    {
        $this->linkGenerator = $tokenGenerator;
        parent::__construct('metabase:embedding:generate-url');
    }

    protected function configure(): void
    {
        $this
            ->addArgument('type', InputArgument::REQUIRED, 'Embedding target type. Only "question" or "dashboard" values are allowed')
            ->addArgument('id', InputArgument::REQUIRED, 'Question or dashboard ID')
            ->addOption('param', 'p', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Embedding target parameters. Example: PARAMETER=VALUE', [])
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getArgument('type');
        $id = $input->getArgument('id');
        $params = $input->getOption('param');

        $_ = array_map(fn (string $param) => explode('=', $param), $params);
        $params = array_combine(array_column($_, 0), array_column($_, 1));

        if (null === ($enumType = EmbedType::tryFrom($type))) {
            $output->writeln(sprintf('Unknown type "%s"', $type));

            return Command::INVALID;
        }

        $url = $this->linkGenerator->generate($enumType, $id, $params);

        $output->writeln($url);

        return Command::SUCCESS;
    }
}
