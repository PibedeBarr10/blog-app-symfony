<?php


namespace App\Controller\Admin\SendNewsletter;


use App\Form\SendNewsletterFormType;
use App\Repository\UserRepository;
use App\Service\SendRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SendNewsletterController extends AbstractController
{
    private UserRepository $userRepository;
    private SendRequest $sendRequest;

    public function __construct(UserRepository $userRepository, SendRequest $sendRequest)
    {
        $this->userRepository = $userRepository;
        $this->sendRequest = $sendRequest;
    }

    #[Route('/admin/sendNewsletter', name: 'send_newsletter', methods: ['GET', 'POST'])]
    public function sendNewsletter(Request $request): Response
    {
        $form = $this->createForm(SendNewsletterFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail_data = $form->get('body')->getData();

            $users = $this->userRepository->findAll();

            foreach ($users as $user) {
                try {
                    $this->sendRequest->sendRequest($user, $mail_data);
                } catch (\Throwable $e) {
                    $this->addFlash('danger', 'Błąd w wysyłaniu raportów - kod '.$e->getCode());
                    return $this->redirectToRoute('dashboard');
                }
            }

            $this->addFlash('success', 'Wysłano newsletter!');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('newsletter/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}