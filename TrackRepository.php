<?php

require_once 'TrackRepositoryInterface.php';

class TrackRepository implements TrackRepositoryInterface {
    private $conn;

    public function __construct(DBConnect $dbc) {
        $this->conn = $dbc->getConnection();
    }

    public function saveTracks(array $tracks, int $artistId): void {

        // Начало транзакции для сохранение треков в БД
        $this->conn->begin_transaction();

        try {
            $insert = $this->conn->prepare("INSERT INTO tracks (track_name, track_duration, track_artist_id) VALUES (?, ?, ?)");
            $check = $this->conn->prepare("SELECT COUNT(*) as result FROM tracks WHERE track_name like ? and track_artist_id like ? and track_duration like ?");
            
            foreach ($tracks as $track) {

                // Проверяем каждую песню на наличие в БД
                $check->bind_param("sid", 
                    $track['track_name'],
                    $artistId,
                $track['track_duration']);
                $check->execute();
                
                $result = $check->get_result();
                $row = $result->fetch_assoc();

                $count = (int)$row['result'];

                if ($count > 0) {
                    continue;
                }

                // Биндим и выполняем запрос для каждой песни
                $insert->bind_param("sdi",
                    $track['track_name'],
                    $track['track_duration'], 
                    $artistId);
                $insert->execute();
            }

            // Коммит транзакции
            $this->conn->commit();
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