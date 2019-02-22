<?php

namespace App\Command;


use App\Event\LunchTimeHasArrived;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class LunchTimeHasArrivedCommand extends Command
{
    protected static $defaultName = 'app:lunch-time-has-arrived';
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        parent::__construct();

        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this->setDescription('Create event that lunch time has arrived');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventDispatcher->dispatch(
            LunchTimeHasArrived::NAME,
            new LunchTimeHasArrived()
        );

        $this->logger->info(sprintf('%s Event has been dispatched', LunchTimeHasArrived::NAME));
    }
}
