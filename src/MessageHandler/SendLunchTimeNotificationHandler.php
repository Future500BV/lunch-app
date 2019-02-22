<?php

namespace App\MessageHandler;

use App\Entity\SendMail;
use App\Entity\User;
use App\Message\SendLunchTimeNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SendLunchTimeNotificationHandler implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, \Swift_Mailer $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer        = $mailer;
    }

    public function __invoke(SendLunchTimeNotification $lunchTimeNotification)
    {
        $repository = $this->entityManager->getRepository(User::class);
        $users      = $repository->findAll();

        /** @var User $user */
        foreach ($users as $user) {
            $id = $user->getId();

            $message = new \Swift_Message();
            $message->setTo($user->getEmail());
            $message->setSubject('Kies je lunch voor vandaag!');
            $message->setBody(<<<EOT
Kies je lunch! <br>
<a href="http://lunchapp.loc/pick-lunch/$id">klik hier</a><br>
Groetjes, <br>
 <br>
Het Lunch Team
EOT
            );
            $this->mailer->send($message);
            $sendMail = new SendMail();
            $sendMail->setRecipient($user->getEmail());
            $sendMail->setSubject('Kies je lunch voor vandaag');
            $sendMail->setBody('test');
            $sendMail->setSendAt(new \DateTime('now'));
            $this->entityManager->persist($sendMail);
        }
        $this->entityManager->flush();
    }
}
