<?php

require_once '../../config/db.php';

class History
{
    private $connection;

    public function __construct()
    {
        $this->connection = getConnection();
    }

    public function save($data)
    {
        $word       = $data['text'];
        $results    = json_encode($data['results']);
        $created_at = date('Y-m-d H:i:s');

        try {
            $sql  = "INSERT INTO search_histories (word, results, created_at) VALUES (?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("sss", $word, $results, $created_at);

            if ($stmt->execute() === true) {
                $message = 'The search history could be saved successfully.';
            } else {
                $message = 'Error inserting into database: ' . $this->connection->error;
            }

            $stmt->close();
            $this->connection->close();

            return $message;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}