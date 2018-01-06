<?php

namespace Commands;

use Library\ParenthesisChecker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParenthesisCheckCommand extends Command
{
    /**
     * @var ParenthesisChecker
     */
    protected $checker;

    public function __construct($checker)
    {
        $this->checker = $checker;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('check')
            ->setDescription('Проверка соотвествия открывающих скобок закрывающим');

        $this->addArgument('filepath',
            InputArgument::REQUIRED,
            'Путь до файла проверки');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filepath');
        if (!(is_file($filePath) && is_readable($filePath))) {
            $output->writeln("Файл $filePath не существует или не может быть прочитан");
            return;
        }

        $fileContent = file_get_contents($filePath);
        try {
            if ($this->checker->check($fileContent)) {
                $output->writeln("Скобки расставлены верно");
            } else {
                $output->writeln("Скобки расставлены неверно");
            }
        } catch (\InvalidArgumentException $e) {
            $output->writeln($e->getMessage());
        }
    }
}