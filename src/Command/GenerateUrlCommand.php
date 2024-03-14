<?php

namespace Malefici\Symfony\MetabaseBundle\Command;

use Malefici\Symfony\MetabaseBundle\Metabase\EmbeddingTypeEnum;
use Malefici\Symfony\MetabaseBundle\Metabase\UrlGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateUrlCommand extends Command
{
    private UrlGenerator $linkGenerator;

    public function __construct(UrlGenerator $linkGenerator)
    {
        $this->linkGenerator = $linkGenerator;
        parent::__construct('metabase:generate-url');
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

        if (null === ($enumType = EmbeddingTypeEnum::tryFrom($type))) {
            $output->writeln(sprintf('Unknown type "%s"', $type));

            return Command::INVALID;
        }

        $token = $this->linkGenerator->generate($enumType, $id, $params);

        $output->writeln($token);

        return Command::SUCCESS;
    }
}
