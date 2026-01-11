<?php
    header("Content-Type: application/json");
    require "../app/db.php"; 

    $datos = json_decode(file_get_contents("php://input"), true);

    if (isset($datos["idsAsientos"]) && !empty($datos["idsAsientos"])) {
        $idsAsientos = $datos["idsAsientos"];
        
        $marcadores = str_repeat("?,", count($idsAsientos) - 1) . "?";
        
        try {
            $sql = "UPDATE asientos SET estado = 'ocupado' WHERE id IN ($marcadores) AND estado = 'disponible'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($idsAsientos);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(["exito" => true, "mensaje" => "Reserva exitosa"]);
            } else {
                echo json_encode(["exito" => false, "mensaje" => "Algunos asientos ya no estaban disponibles o ya estaban ocupados."]);
            }
        } catch (Exception $e) {
            echo json_encode(["exito" => false, "mensaje" => "Error en la base de datos: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["exito" => false, "mensaje" => "No se seleccionaron asientos"]);
    }
?>