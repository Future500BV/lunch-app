<?php

namespace App\Event;

use App\Message\SendLunchTimeNotification;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class LunchTimeHasArrivedSubscriber implements EventSubscriberInterface
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public static function getSubscribedEvents()
    {
        return [
            LunchTimeHasArrived::NAME => 'onLunchTimeHasArrived'
        ];
    }

    public function onLunchTimeHasArrived(LunchTimeHasArrived $event): void
    {
        $this->messageBus->dispatch(new SendLunchTimeNotification());
    }
}
