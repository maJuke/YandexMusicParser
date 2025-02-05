<?php

interface TrackRepositoryInterface {
    public function saveTracks(array $tracks, int $artistId): void;
}