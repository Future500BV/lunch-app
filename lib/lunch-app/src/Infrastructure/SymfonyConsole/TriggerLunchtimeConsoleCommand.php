<?php

namespace LunchApp\Infrastructure\SymfonyConsole;

use LunchApp\Application\Command\TriggerLunchtimeCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class TriggerLunchtimeConsoleCommand extends Command
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('lunch-app:trigger-lunch-time')
            ->setDescription('This triggers the lunch time in the app')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->messageBus->dispatch(new TriggerLunchtimeCommand());
    }
}
