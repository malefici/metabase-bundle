<?php

namespace Malefici\Symfony\MetabaseBundle\Command;

use Malefici\Symfony\MetabaseBundle\Embedding\EmbedTypeEnum;
use Malefici\Symfony\MetabaseBundle\Embedding\TokenGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EmbeddingGenerateTokenCommand extends Command
{
    private TokenGenerator $tokenGenerator;

    public function __construct(TokenGenerator $tokenGenerator)
    {
        $this->tokenGenerator = $tokenGenerator;
        parent::__construct('metabase:embedding:generate-token');
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

        if (null === ($enumType = EmbedTypeEnum::tryFrom($type))) {
            $output->writeln(sprintf('Unknown type "%s"', $type));

            return Command::INVALID;
        }

        $token = $this->tokenGenerator->generate($enumType, $id, $params);

        $output->writeln($token);

        return Command::SUCCESS;
    }
}
