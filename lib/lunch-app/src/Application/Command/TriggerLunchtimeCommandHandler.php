<?php

namespace LunchApp\Application\Command;

use LunchApp\Domain\OrderLunchtimeArrived;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class TriggerLunchtimeCommandHandler implements MessageHandlerInterface
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(TriggerLunchtimeCommand $command)
    {
        $this->messageBus->dispatch(new OrderLunchtimeArrived());
    }
}
