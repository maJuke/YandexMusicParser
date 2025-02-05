<?php

interface ArtistRepositoryInterface {
    public function saveArtist(array $artist, int $artistId): void;
}