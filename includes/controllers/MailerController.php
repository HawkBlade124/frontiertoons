<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendPasswordReset($to, $token)
    {
        $resetLink = "https://www.frontiertoons.com/reset-password?token=$token";
        $email = (new Email())
            ->from('frontiertoons@gmail.com')
            ->to($to)
            ->subject('Password Reset Request')
            ->html('<p>Click the link to reset your password: <a href="' . $resetLink . '">Reset Password</a></p>');

        $this->mailer->send($email);
    }
}
