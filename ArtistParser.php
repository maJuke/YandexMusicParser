<?php

class ArtistParser {
    public function parse(array $data) : array {

        $artistData = [];

        if (isset($data['artist'])) {
            $artist = $data['artist'];

            $artistData['name'] = $artist['name'] ?? null; 
            $artistData['sub_count'] = $artist['likesCount'] ?? null; 
        }

        if (isset($data['albums'])) {
            $artistData['albums_count'] = count($data['albums']) ?? 0;
        }

        if (isset($data['stats'])) {
            $stats = $data['stats'];
            $artistData['lm_list'] = $stats['lastMonthListeners'] ?? 0;
        }

        return $artistData;
    }
}