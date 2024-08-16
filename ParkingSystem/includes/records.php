<?php
include 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conexion = conectarDB();
    
   
    $plateNumbers = $_POST['plateNumber'];
    $vehicleTypes = $_POST['vehicleType'];
    $entryDates = $_POST['entryDate'];
    $exitDates = $_POST['exitDate'];

  
    $query = "INSERT INTO parking_records (plate_number, entry_time, exit_time, vehicle_type_id) VALUES (?, ?, ?, ?)";

    $stmt = $conexion->prepare($query);

    if ($stmt === false) {
        die(json_encode(["success" => false, "message" => "Error al preparar la consulta: " . $conexion->error]));
    }

    foreach ($plateNumbers as $index => $plateNumber) {
        $vehicleType = $vehicleTypes[$index];
        $entryDate = $entryDates[$index];
        $exitDate = $exitDates[$index];

        if (empty($plateNumber) || empty($entryDate) || empty($vehicleType)) {
            echo json_encode(["success" => false, "message" => "Faltan datos necesarios para guardar el registro."]);
            exit;
        }

        if (empty($exitDate)) {
            $stmt->bind_param("sssi", $plateNumber, $entryDate, null, $vehicleType);
        } else {
            $stmt->bind_param("sssi", $plateNumber, $entryDate, $exitDate, $vehicleType);
        }

        if (!$stmt->execute()) {
            echo json_encode(["success" => false, "message" => "Error al insertar el registro: " . $stmt->error]);
            exit; 
        }
    }

    $stmt->close();
    $conexion->close();

    echo json_encode(["success" => true, "message" => "Datos guardados con éxito"]);
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>
