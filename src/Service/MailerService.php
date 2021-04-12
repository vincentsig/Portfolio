<?php

namespace App\Service;

use App\Form\ContactType;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Mime\Email;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Exception\LogicException as ExceptionLogicException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService
{
    private FormFactoryInterface $formFactory;

    private MailerInterface $mailer;

    private FormInterface $form;

    private string $email;

    public function __construct(FormFactoryInterface $formFactory, MailerInterface $mailer, $email)
    {
        $this->mailer = $mailer;
        $this->formFactory = $formFactory;
        $this->email = $email;
    }

    /**
     *
     * @param Request $request
     * @return bool
     * @throws InvalidOptionsException
     * @throws LogicException
     * @throws RuntimeException
     * @throws InvalidArgumentException
     * @throws ExceptionLogicException
     * @throws TransportExceptionInterface
     */
    public function sendEmail(Request $request): bool
    {
        $this->form = $this->formFactory->create(ContactType::class)->handleRequest($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $contactFormData = $this->form->getData();

            $message = (new Email())
            ->from($contactFormData['email'])
            ->to($this->email)
            ->subject('Portfolio message - author name :' . $contactFormData['fullName'])
            ->text(
                'Sender : '.$contactFormData['email'].\PHP_EOL.
                $contactFormData['message'],
                'text/plain'
            );

            $this->mailer->send($message);

            return true;
        }

        return false;
    }

    /**
     * 
     * @return FormInterface 
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }
}
