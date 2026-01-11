<?php
    require "../app/db.php";
    require "../app/functions.php";

    $asientos = obtenerAsientos($pdo);
    $agruparAsientos = agruparAsientosFila($asientos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
    <title>Asientos</title>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                
                <h1 class="mb-4">Selecciona tu Asiento</h1>
                
                <div class="bg-dark text-white p-2 mb-4 rounded shadow-sm w-100">PANTALLA</div>

                <div id="mapa-asientos" class="mb-5">
                    <?php foreach ($agruparAsientos as $letraFila => $asientoFila): ?>
                        <div class="d-flex justify-content-center align-items-center mb-2">
                            <div class="me-3 fw-bold text-secondary" style="width: 30px;">
                                <?= $letraFila ?>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <?php foreach ($asientoFila as $asiento): ?>
                                    <?php 
                                        $claseBoton = $asiento["estado"] === "ocupado"
                                            ? "btn-danger disabled" 
                                            : "btn-outline-success btn-asiento";
                                        
                                        $atributos = "data-id='" . $asiento["id"] . "' data-status='" . $asiento["estado"] . "'";
                                    ?>
                                    <button type="button" class="btn <?= $claseBoton ?>" <?= $atributos ?> style="width: 50px;">
                                        <?= $asiento["numero_asiento"] ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-center gap-4 mb-4">
                    <div><span class="badge bg-success bg-opacity-10 text-success border border-success p-2"> </span> Disponible</div>
                    <div><span class="badge bg-primary text-dark p-2"> </span> Seleccionado</div>
                    <div><span class="badge bg-danger p-2"> </span> Ocupado</div>
                </div>

                <button id="btn-comprar" class="btn btn-primary btn-lg px-5" disabled>
                    Selecciona asientos
                </button>

            </div>
        </div>
    </div>
</body>
</html>