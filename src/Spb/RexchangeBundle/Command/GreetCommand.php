<?php

namespace Spb\RexchangeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('re:greet')
            ->setDescription('Greet someone')
            ->addArgument(
                'names',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'Who do you want to greet (separate multiple names with a space)?'
            )
            ->addOption(
                'yell',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will yell in uppercase letters'
            )
            ->addOption(
                'iterations',
                null,
                InputOption::VALUE_REQUIRED,
                'How many times should the message be printed?',
                1
            );;
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