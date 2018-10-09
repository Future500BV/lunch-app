<?php

namespace App\Tests\Command;

use App\Application\Command\PlanLunch;
use App\Command\LunchtimeArrivedCommand;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Messenger\MessageBusInterface;

class LunchtimeArrivedCommandTest extends KernelTestCase
{
    /**
     * @var MessageBusInterface|ObjectProphecy
     */
    private $bus;

    /**
     * @var LunchtimeArrivedCommand
     */
    private $consoleCommand;

    protected function setUp()
    {
        $this->bus            = $this->prophesize(MessageBusInterface::class);
        $this->consoleCommand = new LunchtimeArrivedCommand($this->bus->reveal());
    }

    /**
     * @test
     */
    public function itIsALunchtimeArrivedConsoleCommand()
    {
        $this->assertInstanceOf(LunchtimeArrivedCommand::class, $this->consoleCommand);
    }

    /**
     * @test
     */
    public function itIsCorrectlyConfigured()
    {
        $this->assertSame("lunch:lunchtime-arrived", $this->consoleCommand->getName());
        $this->assertSame("Notifies developers when lunchtime arrives.", $this->consoleCommand->getDescription());
    }

    /**
     * @test
     */
    public function itIsCorrectlyDispatched()
    {
        $kernel      = static::createKernel();
        $application = new Application($kernel);

        $this->bus->dispatch(new PlanLunch())->shouldBeCalled();

        $command       = $application->find('lunch:lunchtime-arrived');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command' => $command->getName()
            ]
        );
    }
}
