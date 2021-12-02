<?php

namespace App\Controller\Checker\Chocobonplan;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PS5Controller extends AbstractController
{
    #[Route('/checker/chocobonplan/ps5', name: 'checker_chocobonplan_ps5')]
    public function index(Request $request): Response
    {
        $lastTime = $request->getSession()->get('last_time', null);

        $client = HttpClient::create();
        $response = $client->request('GET', 'https://chocobonplan.com/bons-plans/c/console-ps5/');

        $crawler = new Crawler($response->getContent());

        $firstAnnouncement = $crawler->filterXPath('//body/div[2]/section/div[2]/section/article[1]');

        $publishedAtString = $firstAnnouncement->filter('time')->text();

        preg_match('/^Posté il y a (\d) (seconde|minute|heure|jour)/', $publishedAtString, $match);

        $time = match ($match[2]) {
            'seconde' => $match[1],
            'minute' => $match[1] * 60,
            'heure' => $match[1] * 60 * 60,
            'jour' => $match[1] * 60 * 60 * 24,
        };

        $request->getSession()->set('last_time', $time);

        return $this->json([
            'sendNotification' => null === $lastTime || $time < $lastTime,
            'title' => 'A new announcement has just been published on Chocobonplan !',
            'body' => 'A new announcement for PS5 has just been published !',
        ]);
    }
}
