<?php


require_once 'conexion.php';


function registrarEntrada($placa, $tipoVehiculoId) {
    $conexion = conectarDB();
    $entrada = date("Y-m-d H:i:s");

    $sql = "INSERT INTO parking_records (plate_number, entry_time, vehicle_type_id)
            VALUES ('$placa', '$entrada', $tipoVehiculoId)";

    if ($conexion->query($sql) === TRUE) {
        echo "Registro de entrada exitoso.";
    } else {
        echo "Error al registrar la entrada: " . $conexion->error;
    }

    $conexion->close();
}


function registrarSalida($placa) {
    $conexion = conectarDB();
    $salida = date("Y-m-d H:i:s");

    $sql = "SELECT entry_time, vehicle_type_id FROM parking_records WHERE plate_number = '$placa' AND exit_time IS NULL";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $registro = $resultado->fetch_assoc();
        $entrada = $registro['entry_time'];
        $tipoVehiculoId = $registro['vehicle_type_id'];

        
        $tiempoEstacionado = (strtotime($salida) - strtotime($entrada)) / 60;

        
        $sqlTarifa = "SELECT rate, is_resident FROM vehicle_types WHERE id = $tipoVehiculoId";
        $resultadoTarifa = $conexion->query($sqlTarifa);
        $tarifa = $resultadoTarifa->fetch_assoc();

        if ($tarifa['is_resident']) {
            $costo = $tiempoEstacionado * $tarifa['rate'];
        } else {
            $costo = $tiempoEstacionado * $tarifa['rate'] * 3;
        }

        
        $sqlActualizar = "UPDATE parking_records SET exit_time = '$salida', cost = $costo WHERE plate_number = '$placa' AND exit_time IS NULL";
        if ($conexion->query($sqlActualizar) === TRUE) {
            echo "Salida registrada. Costo: $" . $costo;
        } else {
            echo "Error al registrar la salida: " . $conexion->error;
        }
    } else {
        echo "No se encontró un registro de entrada para esa placa.";
    }

    $conexion->close();
}
?>
