<?php
    header("Content-Type: application/json");
    require "../app/db.php";

    try {
        $stmt = $pdo->query("SELECT id, estado FROM asientos");
        $asientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($asientos);
    } catch (Exception $e) {
        echo json_encode([]);
    }
?>