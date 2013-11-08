<?php

namespace Spb\RexchangeBundle\Command;

use Guzzle\Http\StaticClient;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\AppKernel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Guzzle\Http\Client;
use Symfony\Component\DomCrawler\Crawler;

class LoadBnCommand extends Command
{
    const BN_BASE_URI = "http://www.bn.ru";
    const BN_FL_START = "/zap_fl.phtml?so1=%u&so2=%u&start=%u";
    const BN_RM_START = "/zap_rm.phtml?so1=%u&so2=%u&start=%u";

    protected function configure()
    {
        $this
            ->setName('bn:load')
            ->setDescription('Загрузка объектов недвижимости с сайта bn.ru')
            ->addArgument(
                'room-or-flat',
                InputArgument::REQUIRED,
                'Загружать комнаты или квартиры?'
            )
            ->addOption(
                'dir',
                null,
                InputOption::VALUE_REQUIRED,
                'Директория для загрузки файлов'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $objType = $input->getArgument('room-or-flat');

        switch ($objType) {
            case 'room':
                $this->bnLoad();
                break;
            case 'flat':
                $output->writeln('<info>eip - не реализовано</info>');
                break;
            default:
                $output->writeln('');
                $output->writeln('<error>Неправильно указан тип объектов недвижимости. Возможные значения: room или flat.</error>');
                $output->writeln('');
                exit;
        }

    }

    private function bnLoad()
    {
        $client = new Client(self::BN_BASE_URI);

        for ($i = 30; $i <= 30; $i++) {
            $request = $client->get('/zap_fl.phtml?so1='.$i.'&so2='.($i+1));
            $response = $request->send();
            $crawler = new Crawler($response->getBody(true),self::BN_BASE_URI);

            //количество страниц
            $pNum = $crawler->filter('.sr_pages table td')->eq(2)->filter('a')->last();


        }


        //$messageutf8 = iconv('windows-1251', 'UTF-8', $response->getBody(true)->);
        //print_r($messageutf8);
    }
}