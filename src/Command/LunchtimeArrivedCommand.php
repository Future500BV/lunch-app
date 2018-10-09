<?php

namespace App\Command;

use App\Application\Command\PlanLunch;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;


final class LunchtimeArrivedCommand extends Command
{
    /**
     * @var MessageBusInterface
     */
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        parent::__construct();

        $this->bus = $bus;
    }

    protected function configure()
    {
        $this
            ->setName('lunch:lunchtime-arrived')
            ->setDescription('Notifies developers when lunchtime arrives.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bus->dispatch(new PlanLunch());
    }
}
