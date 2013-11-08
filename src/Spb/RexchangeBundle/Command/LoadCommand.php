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
            ->setDescription('Загрузка объектов недвижимости с сайта')
            ->addArgument(
                'data-provider',
                InputArgument::REQUIRED,
                'Откуда скачивать данные (bn, eip, emils, avito)?'
            )
            ->addOption(
                'first-id',
                'f',
                InputOption::VALUE_REQUIRED,
                'Начальный идентификатор загружаемых страниц'
            )
            ->addOption(
                'last-id',
                'l',
                InputOption::VALUE_REQUIRED,
                'Последний идентификатор загружаемых страниц'
            )
            ->addOption(
                'dir',
                'd',
                InputOption::VALUE_REQUIRED,
                'Директория для загрузки файлов'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataProvider = $input->getArgument('data-provider');

        switch ($dataProvider) {
            case 'bn':
                echo "i равно 0";
                break;
            case 'eip':
                $output->writeln('<info>eip - не реализовано</info>');
                break;
            case 'emils':
                $output->writeln('<info>emils - не реализовано</info>');
                break;
            case 'avito':
                $output->writeln('<info>avito - не реализовано</info>');
                break;
            default:
                $output->writeln('');
                $output->writeln('<error>Неправильно указан провайдер данных. (bn, eip, emils, avito)</error>');
                $output->writeln('');
                exit;
        }

    }
}