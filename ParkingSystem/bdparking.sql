#BD DEL SISTEMA DEL PARKING
CREATE DATABASE parking_management;
USE parking_management;
#TABLA ADMINS
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
#TABLA DE VEHÍCULOS
CREATE TABLE vehicle_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(50) NOT NULL UNIQUE,
    rate DECIMAL(10, 2) NOT NULL,
    is_resident BOOLEAN NOT NULL DEFAULT FALSE
);
#TABLA DE REGISTROS
CREATE TABLE parking_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plate_number VARCHAR(20) NOT NULL,
    entry_time DATETIME NOT NULL,
    exit_time DATETIME,
    vehicle_type_id INT,
    FOREIGN KEY (vehicle_type_id) REFERENCES vehicle_types(id)
);

CREATE INDEX idx_plate_number ON parking_records (plate_number);
CREATE INDEX idx_username ON admins (username);

#INGRESAR DATOS DE PRUEBA
INSERT INTO vehicle_types (type_name, rate, is_resident) VALUES
('residente', 1.00, TRUE),
('no residente', 3.00, FALSE),
('oficial', 0.00, FALSE);

INSERT INTO parking_records (plate_number, entry_time, exit_time, vehicle_type_id) VALUES
('S1234A', '2024-08-13 13:00:00', '2024-08-13 13:30:00', 1),
('4567ABC', '2024-08-13 13:00:00', '2024-08-13 14:00:00', 2),
('4FRU573', '2024-08-13 13:00:00', '2024-08-13 18:00:00', 3);

-- Insertar administrador con contraseña en texto plano
INSERT INTO admins (username, password) VALUES
('admin1', 'Password123');



SELECT * FROM vehicle_types;
SELECT * FROM parking_records;
SELECT * FROM admins;


