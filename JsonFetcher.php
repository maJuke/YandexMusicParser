<?php

require_once 'JsonFetcherInterface.php';

// Класс получение "зарытого" JSON с URL
class JsonFetcher implements JsonFetcherInterface {
    public function fetch(string $url): array {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
        $result = curl_exec($ch);

        /* Проверка на код хттп */
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode != 200) {
            throw new Exception("HTTP код ошибки: $httpCode");
        }

        curl_close($ch);
        return json_decode($result, true);
    }
}