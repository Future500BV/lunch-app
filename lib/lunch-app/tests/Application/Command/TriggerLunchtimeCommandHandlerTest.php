<?php

namespace LunchApp\Application\Command;

use LunchApp\Domain\OrderLunchtimeArrived;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Messenger\MessageBusInterface;

class TriggerLunchtimeCommandHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function itPutaAnEventIntoAMessageBus()
    {
        /** @var MessageBusInterface|ObjectProphecy $messageBus */
        $messageBus = $this->prophesize(MessageBusInterface::class);
        $instance = new TriggerLunchtimeCommandHandler($messageBus->reveal());

        $messageBus->dispatch(new OrderLunchtimeArrived())->shouldBeCalled();

        $instance->__invoke( new TriggerLunchtimeCommand() );
    }
}
