<?php

namespace App\Tests\Application\Command;

use App\Application\Command\PlanLunch;
use PHPUnit\Framework\TestCase;

class PlanLunchTest extends TestCase
{
    /**
     * @test
     */
    public function itIsAPlanLunchCommand(){
        $command = new PlanLunch();

        $this->assertInstanceOf(PlanLunch::class, $command);
    }
}
