<?php

namespace LunchApp\Application;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class TriggerLunchtimeCommandHandler implements MessageHandlerInterface
{
    public function __invoke(TriggerLunchtimeCommand $command)
    {
        // TODO: Implement __invoke() method.
    }
}
