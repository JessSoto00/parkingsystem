<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexión MySQL</title>
</head>
<body>
   <?php
 
   $enlace = mysqli_connect("localhost", "root", "", "parking_management", 3307);

   
   if(!$enlace){
        die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
   }

   #Colocado para prueba de conexión
   echo "Conexión exitosa";

   mysqli_close($enlace);
   ?>
</body>
</html>
