<?php

namespace Spb\RexchangeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('re:add')
            ->setDescription('Добавление предложений в базу данных')
            ->addArgument(
                'data-provider',
                InputArgument::REQUIRED,
                'Чьи данные добавлять?'
            )
            ->addOption(
                'mode',
                'm',
                InputOption::VALUE_REQUIRED,
                '1 - добавить новые, 2 - добавить новые + обновить старые, добавить новые + обновить старые + сохранить историю?',
                1
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        if ($names = $input->getArgument('names')) {
            $text = 'Hello' .' '.implode(', ', $names).'!';
        }

        if ($input->getOption('yell')) {
            $text = strtoupper($text);
        }

        for ($i = 0; $i < $input->getOption('iterations'); $i++) {
            // green text
            $output->writeln('<info>'.$text.'</info>');
        }


    }
}