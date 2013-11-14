<?php

namespace Spb\RexchangeBundle\Command;

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
    const BN_FL_START_URL = "/zap_fl.phtml?so1=%u&so2=%u&start=%u";
    const BN_RM_START_URL = "/zap_rm.phtml?sg1=%u&sg2=%u&start=%u";
    const BN_RECORDS_PER_PAGE = 50;
    const BN_MIN_FLAT_SQ = 25;
    const BN_MAX_FLAT_SQ = 175;
    const BN_MIN_ROOM_SQ = 10;
    const BN_MAX_ROOM_SQ = 30;

    protected function configure()
    {
        $this
            ->setName('load:bn')
            ->setDescription('Загрузка объектов недвижимости с сайта bn.ru')
            ->addArgument(
                'room-or-flat',
                InputArgument::REQUIRED,
                'Загружать комнаты или квартиры?'
            )
            ->addOption(
                'dir',
                'd',
                InputOption::VALUE_REQUIRED,
                'Директория для загрузки файлов',
                './'
            )
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Имя файла с сылками'
            )
            ->addOption(
                'so1',
                null,
                InputOption::VALUE_REQUIRED,
                'Минимальная площадь квартиры',
                self::BN_MIN_FLAT_SQ
            )
            ->addOption(
                'so2',
                null,
                InputOption::VALUE_REQUIRED,
                'Максимальная площадь квартиры',
                self::BN_MAX_FLAT_SQ
            )
            ->addOption(
                'sg1',
                null,
                InputOption::VALUE_REQUIRED,
                'Минимальная площадь комнаты',
                self::BN_MIN_ROOM_SQ
            )
            ->addOption(
                'sg2',
                null,
                InputOption::VALUE_REQUIRED,
                'Максимальная площадь комнаты',
                self::BN_MAX_ROOM_SQ
            )
            ->addOption(
                'silent',
                null,
                InputOption::VALUE_NONE
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getOption('dir');


        if (!is_dir($dir)) {
            $output->writeln('');
            $output->writeln('<error>Указанной директории не существует.</error>');
            $output->writeln('');

            exit(1);
        }

        if (!is_writeable($dir)) {
            $output->writeln('');
            $output->writeln('<error>Недостаточно прав для записи в директорию.</error>');
            $output->writeln('');

            exit(2);
        }

        $objType = $input->getArgument('room-or-flat');

        switch ($objType) {
            case 'room':
                $f = $input->getOption('sg1');
                $l = $input->getOption('sg2');

                if ($f == self::BN_MIN_ROOM_SQ && $l == self::BN_MAX_ROOM_SQ) {
                    $edgeFlag = true;
                } else {
                    $edgeFlag = false;
                }

                $uri = self::BN_RM_START_URL;

                if (!$file = $input->getOption('output')) {
                    $file = 'room.txt';
                }
                break;
            case 'flat':
                $f = $input->getOption('so1');
                $l = $input->getOption('so2');

                if ($f == self::BN_MIN_FLAT_SQ && $l == self::BN_MAX_FLAT_SQ) {
                    $edgeFlag = true;
                } else {
                    $edgeFlag = false;
                }

                $uri = self::BN_FL_START_URL;

                if (!$file = $input->getOption('output')) {
                    $file = 'flat.txt';
                }

                break;
            default:
                $output->writeln('');
                $output->writeln('<error>Неправильно указан тип объектов недвижимости. Возможные значения: room или flat.</error>');
                $output->writeln('');
                exit;
        }

        $client = new Client(self::BN_BASE_URI);
        //маскируемся под YandexBot
        //http://help.yandex.ru/webmaster/robot-workings/check-yandex-robots.xml
        $client->setUserAgent('Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)');

        //ccылки к объектам
        $allLinks = array();
        $allpLinks = array();

        for ($i = $f; $i <= $l; $i++) {
            $url = sprintf($uri, $i, $i+1, 0);
            //поменяем крайние параметры
            if ($edgeFlag) {
                if ($i == $f) {
                    $url = sprintf($uri, 0, $i+1, 0);
                }
                if ($i == $l) {
                    $url = sprintf($uri, $i, 1000, 0);
                }
            }

            $request = $client->get($url);
            $response = $request->send();
            $c1 = new Crawler($response->getBody(true),self::BN_BASE_URI);

            //узнаем количество страниц
            $c2 = $c1->filter('.sr_pages table td')->eq(2)->filter('a');
            if ($c2->count() == 0 ) {
                $pNum = 1;
            } else {
                $pNum = $c2->last()->html();
            }

            // вывод текущего состояния
            if (!$input->getOption('silent')) {
                $output->writeln($url .': ' . '<info>' . $pNum . '</info>');
            }

            //пробегаем по всем страницам, начиная с 1
            for ($j = 0; $j < $pNum; $j++) {
                $url = sprintf($uri, $i, $i+1, $j*self::BN_RECORDS_PER_PAGE);
                $request = $client->get($url);
                $response = $request->send();
                $c3 = new Crawler($response->getBody(true),self::BN_BASE_URI);

                $links = $c3->filter('.results')->filter('td[title="Детальная информация об объекте"]')->each(
                    function (Crawler $node, $i) {
                        return $node->filter('a')->link()->getUri();
                    }
                );
                array_walk ($links, function (&$item) { $item = strstr($item, '?', true); });
                $allLinks = array_merge($allLinks, $links);

                $plinks = $c3->filter('.results')->filter('.bg3')->each(
                    function (Crawler $node, $i) {
                        return $node->filter('td')->eq(1)->filter('a')->link()->getUri();
                    }
                );
                array_walk ($plinks, function (&$item) { $item = strstr($item, '?', true); });
                $allpLinks = array_merge($allpLinks, $plinks);

            }
        }
        file_put_contents($dir.'/'.$file, implode("\n", array_unique($allLinks)));
        file_put_contents($dir.'/p'.$file, implode("\n", array_unique($allpLinks)));
    }
}