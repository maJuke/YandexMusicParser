<?php

class TrackParser {
    public function parse(array $data): array {
        $tracks = [];
        
        foreach ($data['tracks'] as $track) {
            $tracks[] = [
                'track_name' => trim($track['title']),
                'track_duration' => $track['durationMs'] / 1000
            ];
        }
        return $tracks;
    }
}