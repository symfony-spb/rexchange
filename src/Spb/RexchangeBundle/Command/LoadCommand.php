<?php

namespace Spb\RexchangeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LoadCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('re:load')
            ->setDescription('Загрузка предложений с сайта')
            ->addArgument(
                'data-provider',
                InputArgument::REQUIRED,
                'Откуда скачивать данные (bn, eip, emils)?'
            )
            ->addOption(
                'mode',
                'm',
                InputOption::VALUE_REQUIRED,
                'Только добавить, добавить + обновить, добавить + обновить + сохранить историю?',
                1
            );;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataProvider = $input->getArgument('data-provider');

        switch ($dataProvider) {
            case 'bn':
                echo "i равно 0";
                break;
            case 'eip':
                echo "i равно 1";
                break;
            case 'emils':
                echo "i равно 2";
                break;
            default:
                $output->writeln('');
                $output->writeln('<error>Неправильно указан провайдер данных. (bn, eip, emils)</error>');
                $output->writeln('');
                exit;
        }

    }
}