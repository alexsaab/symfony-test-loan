<?php

namespace App\Controller;

use App\Entity\Credit;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Event\CreditCreatedEvent;
use App\Event\ClientCreatedEvent;
use App\Event\ClientUpdatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MainController extends AbstractController
{

    #[Route(path: '/apply', name: 'credit_apply', methods: ['GET', 'POST'])]
    public function apply(Request $request, EntityManagerInterface $em, ClientRepository $clientRepository, EventDispatcherInterface $eventDispatcher): Response
    {
        $credit = new Credit();
        $client = new Client();

        $states = [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
        ];

        $stateCodes = array_keys($states);

        $form = $this->createFormBuilder(['credit' => $credit, 'client' => $client])
            ->add('credit_amount', NumberType::class, [
                'mapped' => false,
                'label' => 'Loan amount',
            ])
            ->add('credit_term', NumberType::class, [
                'mapped' => false,
                'label' => 'Loan term (months)',
            ])
            ->add('client_firstname', TextType::class, [
                'mapped' => false,
                'label' => 'First name',
            ])
            ->add('client_lastname', TextType::class, [
                'mapped' => false,
                'label' => 'Last name',
            ])
            ->add('client_average_monthly_income', NumberType::class, [
                'mapped' => false,
                'label' => 'Average monthly income'])
            ->add('client_phone', TextType::class, [
                'mapped' => false,
                'label' => 'Phone',
            ])
            ->add('client_email', EmailType::class, [
                'mapped' => false,
                'label' => 'Email',
            ])
            ->add('client_age', NumberType::class, [
                'mapped' => false,
                'label' => 'Age'])
            ->add('client_ssn', TextType::class, [
                'mapped' => false,
                'label' => 'SSN',
            ])
            ->add('client_state', ChoiceType::class, [
                'mapped' => false,
                'label' => 'State',
                'choices' => $stateCodes,
                'choice_label' => function ($stateCode) use ($states) {
                    return $states[$stateCode];
                },
            ])
            ->add('client_city', TextType::class, [
                'mapped' => false,
                'label' => 'City',
            ])
            ->add('client_postal_code', TextType::class, [
                'mapped' => false,
                'label' => 'ZIP code',
            ])
            ->add('client_address', TextType::class, [
                'mapped' => false,
                'label' => 'Address',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Send application'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $credit->setTitle('Loan for ' . $form->get('client_firstname')->getData() . ' ' . $form->get('client_lastname')->getData());
            $credit->setAmount($form->get('credit_amount')->getData());
            $credit->setCurrency('USD');
            $credit->setPercent('20');
            $credit->setTerm($form->get('credit_term')->getData());

            $existingClient = $clientRepository->findOneBy(['ssn' => $form->get('client_ssn')->getData()]);

            if ($existingClient) {
                $client = $existingClient;
                $eventDispatcher->dispatch(new ClientUpdatedEvent($client));
            } else {
                $client->setSsn($form->get('client_ssn')->getData());
                $eventDispatcher->dispatch(new ClientCreatedEvent($client));
            }

            $client->setFirstName($form->get('client_firstname')->getData());
            $client->setLastName($form->get('client_lastname')->getData());
            $client->setAverageMonthlyIncome($form->get('client_average_monthly_income')->getData());
            $client->setEmail($form->get('client_email')->getData());
            $client->setPhone($form->get('client_phone')->getData());
            $client->setAge($form->get('client_age')->getData());
            $client->setSsn($form->get('client_ssn')->getData());
            $client->setState($form->get('client_state')->getData());
            $client->setPostalCode($form->get('client_postal_code')->getData());
            $client->setCity($form->get('client_city')->getData());
            $client->setAddress($form->get('client_address')->getData());

            $em->persist($client);
            $em->flush();

            $credit->setClient($client);
            $em->persist($credit);
            $em->flush();

            $eventDispatcher->dispatch(new CreditCreatedEvent($credit, $client));

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

    #[Route(path: '/', name: 'home')]
    public function home(): Response
    {
        return $this->redirectToRoute('credit_apply');
    }
}
