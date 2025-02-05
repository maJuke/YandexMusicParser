<?php

require_once 'ArtistRepositoryInterface.php';

class ArtistRepository implements ArtistRepositoryInterface {
    private $conn;

    public function __construct(DBConnect $dbc) {
        $this->conn = $dbc->getConnection();
    }

    public function saveArtist(array $artist, int $artistId): void {

        // Начало транзакции для сохранение артиста в БД
        $this->conn->begin_transaction();

        try {
            $insert = $this->conn->prepare("INSERT INTO artists (artist_id, artist_name, artist_sub_count, artist_listeners_amount, artist_albums_amount) VALUES (?, ?, ?, ?, ?)");
            $check = $this->conn->prepare("SELECT COUNT(*) as result FROM artists WHERE artist_id = ?");
            
            
            // Проверяем наличие артиста в БД
            $check->bind_param("i", 
                $artistId);
            $check->execute();

            $result = $check->get_result();
            $row = $result->fetch_assoc();

            $count = (int)$row['result'];

            // Биндим и выполняем запрос для артиста, если его нет
            if ($count === 0 ) {
                $insert->bind_param("isiii",
                $artistId,
                $artist['name'],
                $artist['sub_count'],
                $artist['lm_list'],
                $artist['albums_count']
                );
                $insert->execute();

                // Коммит транзакции
                $this->conn->commit();
            }
        } catch (Exception $e) {

            // Если транзакция не прошла - роллбек и получение ошибки
            $this->conn->rollback();
            throw $e;
        } finally {

            // Все хорошо - закрываем коннект к базе
            $insert->close();
            $check->close();
        }
    }
}