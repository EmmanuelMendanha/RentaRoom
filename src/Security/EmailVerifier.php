<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    // Constructeur de la classe
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager
    ) {
    }
    // Méthode pour envoyer un email de confirmation
    public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void
    {
        // Génération de la signature pour l'email de vérification
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );
        // Ajout de la signature à l'email
        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);
        // Envoi de l'email
        $this->mailer->send($email);
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */

      // Méthode pour gérer la confirmation de l'email
    public function handleEmailConfirmation(Request $request, UserInterface $user): void
    {
         // Validation de la confirmation de l'email
        $this->verifyEmailHelper->validateEmailConfirmationFromRequest($request, $user->getId(), $user->getEmail());
       // Marquage de l'utilisateur comme vérifié
        $user->setIsVerified(true);
        // Persistance et flush de l'utilisateur
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
