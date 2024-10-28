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
        $hit1P = '';
        $hit2P = '';
        $hit3K = '';
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
            $hit1P = round($my_array['data']['me']['hit']['1P']*100, 1);
            $hit2P = round($my_array['data']['me']['hit']['2P']*100, 1);
            $hit3K = round($my_array['data']['me']['hit']['3K']*100, 1);
        }

        return $this->render('statistics/statistics.html.twig', [
            'hit1P' => $hit1P,
            'hit2P' => $hit2P,
            'hit3K' => $hit3K,
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
