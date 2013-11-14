<?php

namespace Spb\RexchangeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class ParseBnCommand extends Command
{
    const BN_BASE_URI = 'http://www.bn.ru';

    protected function configure()
    {
        $this
            ->setName('parse:bn')
            ->setDescription('Разбор(парсинг) html файлов, загруженных с bn.ru')
            ->addOption(
                'dir',
                'd',
                InputOption::VALUE_REQUIRED,
                'Директория с html файлами для парсинга',
                './'
            )
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Имя файла с данными'
            )

        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getOption('dir');
        $file = $input->getOption('output');

        foreach (scandir($dir) as $file) {
            try {
                if ($file == '.' || $file == '..') continue;

                $crawler = new Crawler(file_get_contents($dir . '/' . $file), self::BN_BASE_URI);

                $r['№'] = intval($file);

                $r['Заголовок'] = $crawler->filter('.head_obj')->text();
                //Парсим заголовок
                list($r['Объект#'], $r['Регион#'], $rest) = explode(", ", $r['Заголовок'], 3);
                //метро в заголовке
                preg_match('/, м\. ([^,]*), /', $r['Заголовок'], $matches);
                $r['Метро#'] = isset($matches[1]) ? $matches[1] : 'неопределено';

                $crawler->filter('.kvart_left')->filter('table')->eq(0)->filter('tr')->each(
                    function (Crawler $node, $i) use (&$r) {
                        $key = trim($node->filter('td')->eq(0)->text(), ": ");
                        $value = $node->filter('td')->eq(1);

                        switch ($key) {
                            case 'Цена':
                                $r[$key] = intval($value->text());
                                break;
                            case 'Телефон':
                                $r[$key] = $value->text();
                                break;
                            case 'Субъект':
                                if ($value->filter('a')->count() > 0)
                                    $r[$key] = $value->filter('a')->link()->getUri();
                                else
                                    $r[$key] = $value->text();
                                break;
                            default:
                                $r[$key] = $value->html();
                                break;
                        }

                    }
                );

                $crawler->filter('.kvart_left')->filter('table')->eq(1)->filter('tr')->each(
                    function (Crawler $node, $i) use (&$r) {
                        if ($node->filter('td[colspan="2"]')->count() > 0) return;

                        $key = trim($node->filter('td')->eq(0)->text(), ": ");
                        $value = $node->filter('td')->eq(1);

                        $r[$key] = $value->text();

                    }
                );

                $r['Дополнительно'] = $crawler->filter('div#description')->count() > 0 ? $crawler->filter('div#description')->html() : '';

                $r['Фото'] = $crawler->filter('.kvart_right')->filter('div[style="display: none"]')->filter('a')->each(
                    function (Crawler $node, $i) {
                        return $node->link()->getUri();
                    }
                );

                //print_r($r);
                $output->writeln(json_encode($r));
            } catch (\Exception $ex) {
                $errors[] = $file;
                $output->writeln(json_encode(array('errors' => $errors)));
            }

        }
    }
}