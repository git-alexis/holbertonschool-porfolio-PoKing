<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


class StatisticsController extends AbstractController
{
    #[Route('/statistics', name: 'app_statistics')]
    public function index(Request $request): Response
    {
        $hitHC = '';
        $hit1P = '';
        $hit2P = '';
        $hit3K = '';
        $hitST = '';
        $hitFL = '';
        $hitFH = '';
        $hit4K = '';
        $hitSF = '';
        $numberCard1Board = '';
        $numberCard2Board = '';
        $numberCard3Board = '';
        $colorCard1Board = '';
        $colorCard2Board = '';
        $colorCard3Board = '';
        $numberCard1Hole = '';
        $numberCard2Hole = '';
        $colorCard1Hole = '';
        $colorCard2Hole = '';

        if ($request->isMethod('POST')) {
            $numberCard1Board = $request->request->get('numbersboard1');
            $numberCard2Board = $request->request->get('numbersboard2');
            $numberCard3Board = $request->request->get('numbersboard3');
            $colorCard1Board = $request->request->get('suitsboard1');
            $colorCard2Board = $request->request->get('suitsboard2');
            $colorCard3Board = $request->request->get('suitsboard3');

            $numberCard1Hole = $request->request->get('numbershole1');
            $numberCard2Hole = $request->request->get('numbershole2');
            $colorCard1Hole = $request->request->get('suitshole1');
            $colorCard2Hole = $request->request->get('suitshole2');

            $card1Board = $request->request->get('boardcards1');
            $card2Board = $request->request->get('boardcards2');
            $card3Board = $request->request->get('boardcards3');

            $card1Hole = $request->request->get('holecards1');
            $card2Hole = $request->request->get('holecards2');

            if ($card1Board == $card2Board or $card1Board == $card3Board or $card1Board == $card1Hole or $card1Board == $card2Hole or $card2Board == $card3Board or $card2Board == $card1Hole
            or $card2Board == $card2Hole or $card3Board == $card1Hole or $card3Board == $card2Hole or $card1Hole == $card2Hole) {
                $this->addFlash('error', '5 different cards must be selected.');
            } else {
                $client = new \GuzzleHttp\Client(['verify' => false]);
            
                $url = "https://sf-api-on-demand-poker-odds-v1.p.rapidapi.com/flop?board=".$card1Board."%2C".$card2Board."%2C".$card3Board."&hole=".$card1Hole."%2C".$card2Hole;

                $response = $client->request('GET', $url, [
                    'headers' => [
                        'x-rapidapi-host' => 'sf-api-on-demand-poker-odds-v1.p.rapidapi.com',
                        'x-rapidapi-key' => 'aa4035016fmsh513542321987616p15abf9jsn6b00fae1d717',
                    ],
                ]);

                $json = $response->getBody();
                $my_array = json_decode($json, true);

                $hitHC = round($my_array['data']['me']['hit']['HC']*100, 1);
                $hit1P = round($my_array['data']['me']['hit']['1P']*100, 1);
                $hit2P = round($my_array['data']['me']['hit']['2P']*100, 1);
                $hit3K = round($my_array['data']['me']['hit']['3K']*100, 1);
                $hitST = round($my_array['data']['me']['hit']['ST']*100, 1);
                $hitFL = round($my_array['data']['me']['hit']['FL']*100, 1);
                $hitFH = round($my_array['data']['me']['hit']['FH']*100, 1);
                $hit4K = round($my_array['data']['me']['hit']['4K']*100, 1);
                $hitSF = round($my_array['data']['me']['hit']['SF']*100, 1);
            }
        }

        return $this->render('statistics/statistics.html.twig', [
            'hitHC' => $hitHC,
            'hit1P' => $hit1P,
            'hit2P' => $hit2P,
            'hit3K' => $hit3K,
            'hitST' => $hitST,
            'hitFL' => $hitFL,
            'hitFH' => $hitFH,
            'hit4K' => $hit4K,
            'hitSF' => $hitSF,
            'numbersboard1' => $numberCard1Board,
            'numbersboard2' => $numberCard2Board,
            'numbersboard3' => $numberCard3Board,
            'suitsboard1' => $colorCard1Board,
            'suitsboard2' => $colorCard2Board,
            'suitsboard3' => $colorCard3Board,
            'numbershole1' => $numberCard1Hole,
            'numbershole2' => $numberCard2Hole,
            'suitshole1' => $colorCard1Hole,
            'suitshole2' => $colorCard2Hole,
        ]);
    }
}
