CREATE DATABASE IF NOT EXISTS misterplan_reservas;
USE misterplan_reservas;

CREATE TABLE reserva (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_huesped VARCHAR(120) NOT NULL,
    email_huesped VARCHAR(150) NOT NULL,
    nombre_alojamiento VARCHAR(150) NOT NULL,
    fecha_entrada DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada') NOT NULL DEFAULT 'pendiente',
    importe DECIMAL(10, 2) NOT NULL,
    notas TEXT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reserva_evento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reserva_id) REFERENCES reserva(id)
);

INSERT INTO reserva (nombre_huesped, email_huesped, nombre_alojamiento, fecha_entrada, fecha_salida, estado, importe) VALUES 
('Alba Canelo', 'alba@email.com', 'Apartamento Rural Cáceres', '2026-11-10', '2026-11-15', 'pendiente', 250.00),
('Rudi García', 'rudi@email.com', 'Cabaña Valle del Jerte', '2026-08-01', '2026-08-05', 'confirmada', 320.50),
('Carlos Ruiz', 'carlos@email.com', 'Hotel Plaza Mayor', '2026-12-01', '2026-12-04', 'cancelada', 180.00),
('Elena Gómez', 'elena@email.com', 'Apartamento Rural Cáceres', '2026-10-20', '2026-10-25', 'confirmada', 200.00),
('Luis Miguel Parejo', 'luis@email.com', 'Casa Rural Monfragüe', '2027-01-10', '2027-01-15', 'pendiente', 450.00);

INSERT INTO reserva_evento (reserva_id, tipo, descripcion) VALUES 
(1, 'CREACION', 'Reserva creada en la web en estado pendiente'),
(2, 'CREACION', 'Reserva creada inicialmente en estado pendiente'),
(2, 'CONFIRMACION', 'El cliente ha realizado el pago por transferencia. Reserva confirmada.'),
(3, 'CREACION', 'Reserva creada por teléfono en estado pendiente'),
(3, 'CANCELACION', 'El cliente canceló la reserva por imprevistos familiares.'),
(4, 'CREACION', 'Reserva creada y confirmada directamente en recepción.'),
(5, 'CREACION', 'Reserva creada en la web en estado pendiente');