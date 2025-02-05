<?php

interface JsonFetcherInterface {
    public function fetch(string $url): array;
}