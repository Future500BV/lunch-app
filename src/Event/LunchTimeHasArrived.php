<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

final class LunchTimeHasArrived extends Event
{
    const NAME = 'lunch_time_has_arrived';
}
