<?php

require_once 'DBConnect.php';
require_once 'JsonFetcher.php';
require_once 'TrackParser.php';
require_once 'TrackRepository.php';
require_once 'ArtistParser.php';
require_once 'ArtistRepository.php';
require_once 'MusicParser.php';

$dbConnect = new DBConnect("localhost", "root", "yandex_music");
$jsonFetcher = new JsonFetcher();
$trackParser = new TrackParser();
$trackRepository = new TrackRepository($dbConnect);
$artistParser = new ArtistParser();
$artistRepository = new ArtistRepository($dbConnect);
$music = new MusicParser($jsonFetcher, 
                $trackParser, $trackRepository,
                $artistParser, $artistRepository);

if ($argc < 2) {
    die("Внимание! Вы не внесли URL! Используйте команду, типа: php YandexMusicParser.php \"https://music.yandex.ru/artist/36800/tracks\"\n");
}

$url = $argv[1];
$music->parse($url);

$dbConnect->close();