<?php

namespace App\Application\Command;

final class PlanLunchHandler
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig   = $twig;
    }

    public function __invoke(PlanLunch $planLunch)
    {
        foreach ($this->getEmployees() as $employee) {
            $this->sendEmailToEmployee($employee['email'], $employee['name']);
        }
    }

    private function sendEmailToEmployee(string $email, string $name)
    {
        $message = (new \Swift_Message())
            ->setSubject('Subject')
            ->setFrom('send@example.com')
            ->setTo($email)
            ->setBody(
                $this->twig->render(
                    'emails/registration.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    private function getEmployees()
    {
        return [
            [
                'name'  => 'Mitchel',
                'email' => 'mitchel@future500.nl',
            ],
            [
                'name'  => 'Ainsley',
                'email' => 'ainsley@hotmail.com',
            ],
        ];
    }
}
