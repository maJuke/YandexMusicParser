<?php

require_once 'JsonFetcher.php';
require_once 'TrackParser.php';
require_once 'TrackRepository.php';
require_once 'ArtistParser.php';
require_once 'ArtistRepository.php';

class MusicParser {

    private $jsonFetcher;
    private $trackParser;
    private $trackRepository;
    private $artistParser;
    private $artistRepository;

    public function __construct(JsonFetcher $jsonFetcher, TrackParser $trackParser,
                                    TrackRepository $trackRepository, ArtistParser $artistParser,
                                    ArtistRepository $artistRepository) {
        $this->jsonFetcher = $jsonFetcher;
        $this->trackParser = $trackParser;
        $this->trackRepository = $trackRepository;
        $this->artistParser = $artistParser;
        $this->artistRepository = $artistRepository;
    }

    public function parse(string $url): void {
        $partsOfURL = explode('/', parse_url($url, PHP_URL_PATH));
        $artistID = $partsOfURL[2];
        $trackPage = 0;

        $allTracks = [];

        while (true) {
             $jsonURL = "https://music.yandex.ru/handlers/artist.jsx?artist=$artistID&what=tracks&sort=&dir=&period=month&trackPage=$trackPage&trackPageSize=100&lang=ru&external-domain=music.yandex.ru&overembed=false";
             $data = $this->jsonFetcher->fetch($jsonURL);
             $artist = $this->artistParser->parse($data);

             if (isset($data['tracks']) && count($data['tracks']) > 0) {
                $tracks = $this->trackParser->parse($data);
                $allTracks = array_merge($allTracks, $tracks);
                //print_r($allTracks); - дебаг в консоль
                $trackPage++;
             } else {
                break;
             }
        }
        $this->artistRepository->saveArtist($artist, $artistID);
        $this->trackRepository->saveTracks($allTracks, $artistID);

        echo "Парсинг закончен! Все новые треки были заведены в базу!";
    }
}