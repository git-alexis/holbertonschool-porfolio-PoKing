<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Rancking;
use App\Form\RanckingFormType;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Repository\RanckingRepository;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rancking')]
final class RanckingController extends AbstractController
{
    #[Route(name: 'app_rancking_listing', methods: ['GET'])]
    public function listing(EventRepository $eventRepository): Response
    {
        return $this->render('rancking/listing.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/view', name: 'app_rancking_view_general', methods: ['GET'])]
    public function viewGeneral(UserRepository $userRepository, RanckingRepository $ranckingRepository, EventRepository $eventRepository): Response
    {
        $users = $userRepository->findAll();
        $events = $eventRepository->findAll();

        $ranking = [];

        foreach ($users as $user) {
            $pseudo = $user->getPseudo();
            $pointsPerEvent = [];
            $totalPoints = 0;
            $totalKills = 0;

            foreach ($events as $event) {
                $rancking = $ranckingRepository->findOneBy(['user' => $user, 'event' => $event]);

                if ($rancking) {
                    $points = $rancking->getPoints();
                    $kills = $rancking->getKillsNumber();
                } else {
                    $points = 0;
                    $kills = 0;
                }

                $pointsPerEvent[$event->getId()] = $points;
                $totalPoints += $points;
                $totalKills += $kills;
            }

            $ranking[] = [
                'pseudo' => $pseudo,
                'pointsPerEvent' => $pointsPerEvent,
                'totalPoints' => $totalPoints,
                'totalKills' => $totalKills,
            ];
        }

        usort($ranking, function ($a, $b) {
            if ($a['totalPoints'] === $b['totalPoints']) {
                return $b['totalKills'] <=> $a['totalKills'];
            }
            return $b['totalPoints'] <=> $a['totalPoints'];
        });

        return $this->render('rancking/view_general.html.twig', [
            'ranking' => $ranking,
            'events' => $events,
        ]);
    }

    #[Route('/{id}', name: 'app_rancking_view', methods: ['GET'])]
    public function view(Event $event, RanckingRepository $ranckingRepository): Response
    {
        $ranckings = $ranckingRepository->findBy(['event' => $event]);

        usort($ranckings, function ($a, $b) {
            return $b->getPoints() <=> $a->getPoints();
        });

        return $this->render('rancking/view.html.twig', [
            'ranckings' => $ranckings,
            'event' => $event,
        ]);
    }

    #[Route('/{id}/create', name: 'app_rancking_create', methods: ['GET', 'POST'])]
    public function create(Event $event, RegistrationRepository $registrationRepository, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $registrations = $registrationRepository->findBy(['event' => $event]);
        $pseudoList = [];

        foreach ($registrations as $registration) {
            $pseudoList[] = $registration->getUser()->getPseudo();
        }

        $points = [];
        $formData = [];

        if ($request->isMethod('POST')) {
            $season = $request->request->get('season');

            $regex = '/^\d{4}\/\d{4}$/';

            if (!(preg_match($regex, $season))) {
                $this->addFlash('error', 'Valid season : year ( yyyy )/year ( yyyy )');
            } else {
                $formData = $request->request->all();

                if ($request->request->has('calculate')) {
                    $size = count($pseudoList);

                    for ($index = 1; $index <= count($pseudoList); $index++) {
                        $rank = $request->request->get('rank_'.$index);
                        $points[$index] = $size - $rank + 1;
                    }

                    return $this->render('rancking/create.html.twig', [
                        'pseudoList' => $pseudoList,
                        'event' => $event,
                        'points' => $points,
                        'formData' => $formData,
                    ]);
                } else {
                    $season = $request->request->get('season');

                    for ($index = 1; $index <= count($pseudoList); $index++) {
                        $pseudo = $request->request->get('pseudo_'.$index);
                        $rank = $request->request->get('rank_'.$index);
                        $point = $request->request->get('points_'.$index);
                        $kill = $request->request->get('kills_'.$index);

                        $user = $userRepository->findOneBy(['pseudo' => $pseudo]);

                        $rancking = new Rancking();
                        $rancking->setEvent($event);
                        $rancking->setUser($user);
                        $rancking->setSeason($season);
                        $rancking->setRankingPosition($rank);
                        $rancking->setPoints($point);
                        $rancking->setKillsNumber($kill);

                        $entityManager->persist($rancking);
                        $entityManager->flush();
                    }

                    return $this->redirectToRoute('app_rancking_listing');
                }
            }
        }

        return $this->render('rancking/create.html.twig', [
            'pseudoList' => $pseudoList,
            'event' => $event,
            'points' => $points,
            'formData' => $formData,
        ]);
    }

    #[Route('/{id}', name: 'app_rancking_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, RanckingRepository $ranckingRepository, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->getPayload()->getString('_token'))) {
            $ranckings = $ranckingRepository->findBy(['event' => $event]);

            foreach ($ranckings as $rancking) {
                $entityManager->remove($rancking);

                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('app_rancking_listing', [], Response::HTTP_SEE_OTHER);
    }
}
