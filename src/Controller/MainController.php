<?php

namespace App\Controller;


use App\Entity\Credit;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Doctrine\ORM\EntityManagerInterface;

class MainController extends AbstractController
{

    #[Route(path: '/apply', name: 'credit_apply', methods: ['GET', 'POST'])]
    public function apply(Request $request, EntityManagerInterface $em): Response
    {
        $credit = new Credit();
        $client = new Client();

        $form = $this->createFormBuilder(['credit' => $credit, 'client' => $client])
            ->add('credit_amount', NumberType::class, [
                'mapped' => false,
                'label' => 'Сумма кредита',
            ])
            ->add('credit_term', NumberType::class, [
                'mapped' => false,
                'label' => 'Срок кредита (месяцев)',
            ])
            ->add('client_firstname', TextType::class, [
                'mapped' => false,
                'label' => 'Имя',
            ])
            ->add('client_lastname', TextType::class, [
                'mapped' => false,
                'label' => 'Фамилия',
            ])
            ->add('client_email', TextType::class, [
                'mapped' => false,
                'label' => 'Email',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Отправить заявку'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $credit->setAmount($form->get('credit_amount')->getData());
            $credit->setTerm($form->get('credit_term')->getData());
            $client->setFirstName($form->get('client_firstname')->getData());
            $client->setLastName($form->get('client_lastname')->getData());
            $client->setEmail($form->get('client_email')->getData());

            $em->persist($credit);
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('application_success');
        }

        return $this->render('credit_application/apply.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route(path: '/success', name: 'application_success')]
    public function success(): Response
    {
        return $this->render('credit_application/success.html.twig');
    }
}
