<?php
    function obtenerAsientos($pdo) {
        $stmt = $pdo->query("SELECT * FROM asientos ORDER BY fila, numero_asiento");
        return $stmt->fetchAll();
    }

    function agruparAsientosFila($asientos) {
        $filas = [];
        foreach ($asientos as $asiento) {
            $filas[$asiento["fila"]][] = $asiento;
        }
        return $filas;
    }
?>