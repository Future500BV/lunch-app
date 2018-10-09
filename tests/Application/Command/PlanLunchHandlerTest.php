<?php

namespace App\Tests\Application\Command;

use App\Application\Command\PlanLunch;
use App\Application\Command\PlanLunchHandler;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

final class PlanLunchHandlerTest extends TestCase
{
    /**
     * @var \Swift_Mailer|ObjectProphecy
     */
    private $mailer;

    /**
     * @var \Twig_Environment|ObjectProphecy
     */
    private $twig;

    /**
     * @var PlanLunchHandler
     */
    private $handler;

    public function setUp()
    {
        $this->mailer  = $this->prophesize(\Swift_Mailer::class);
        $this->twig    = $this->prophesize(\Twig_Environment::class);
        $this->handler = new PlanLunchHandler($this->mailer->reveal(), $this->twig->reveal());
    }

    /**
     * @test
     */
    public function itSendsEmailNotificationToAllEmployees()
    {
//
//        $messageBody = 'Hi Mitchel';
//
//        $this->twig->render('emails/registration.html.twig', ['name' => 'Mitchel'])->willReturn($messageBody);
//
//        $message = (new \Swift_Message())
//            ->setSubject('Subject')
//            ->setFrom('send@example.com')
//            ->setTo('mitchel@future500.nl')
//            ->setBody(
//                $messageBody,
//                'text/html'
//            );

        $this->mailer->send(Argument::type(\Swift_Message::class))->shouldBeCalled();

        $this->handler->__invoke(new PlanLunch());
    }

}

