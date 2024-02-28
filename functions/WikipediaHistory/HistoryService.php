<?php

class HistoryService {
    public function save($data) {
        $word = $data['text'];
        $results = json_encode($data['results']);
        $created_at = date('Y-m-d H:i:s');

        echo $word;
        echo $results;
        echo $created_at;

        $conn = getConnection();

        $sql = "INSERT INTO search_histories (word, created_at) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $word, $created_at);

        if ($stmt->execute() === TRUE) {
            $data = ['data' => 'Success'];
        } else {
            $data = ['data' => 'Error al insertar en la base de datos: ' . $conn->error];
        }

        $stmt->close();
        $conn->close();

        echo $data;
    }
}

?>