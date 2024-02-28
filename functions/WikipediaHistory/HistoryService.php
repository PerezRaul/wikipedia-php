<?php

require_once '../connection/db.php';

class HistoryService
{
    public function save($data)
    {
        $word       = $data['text'];
        $results    = json_encode($data['results']);
        $created_at = date('Y-m-d H:i:s');

        try {
            $conn = getConnection();

            $sql  = "INSERT INTO search_histories (word, results, created_at) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $word, $results, $created_at);

            if ($stmt->execute() === true) {
                $message = 'The search history could be saved successfully.';
            } else {
                $message = 'Error inserting into database: ' . $conn->error;
            }

            $stmt->close();
            $conn->close();

            return $message;
        } catch (Exception $e) {
            throw new Exception($e->getMessage);
        }
    }
}