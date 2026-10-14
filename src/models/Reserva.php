<?php
require_once __DIR__ . '/../../config/database.php';

class Reserva
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Database::conectar();
    }
    public function ListarReserva($filtros=[])
    {
        $sql = "SELECT * from reserva WHERE 1=1";
        $parametros = [];

        if (!empty($filtros['estado'])) {
            $sql .= " AND estado = :estado";
            $parametros[':estado'] = $filtros['estado'];
        }

        if (!empty($filtros['fecha_desde'])) {
            $sql .= " AND fecha_entrada >= :fecha_desde";
            $parametros[':fecha_desde'] = $filtros['fecha_desde'];
        }

        if (!empty($filtros['fecha_hasta'])) {
            $sql .= " AND fecha_entrada <= :fecha_hasta";
            $parametros[':fecha_hasta'] = $filtros['fecha_hasta'];
        }

        if (!empty($filtros['nombre'])) {
            $sql .= " AND nombre_huesped LIKE :nombre";
            $parametros[':nombre'] = '%' . $filtros['nombre'] . '%';
        }

        $filt = $this->conexion->prepare($sql);
        $filt->execute($parametros);
        return $filt->fetchAll();
    }

    public function DetalleReserva($id){
        $filt = $this->conexion->prepare("SELECT * from reserva where id=:id ");
        $filt->execute([':id'=>$id]);
        return $filt->fetch();
    }

    public function HistorialReserva($id){
        $filt = $this->conexion->prepare("SELECT * FROM reserva_evento WHERE reserva_id = :id ORDER BY fecha_creacion DESC");
        $filt->execute([':id' => $id]);
        return $filt->fetchAll();
    }

    public function CrearReserva($ArrayDatos){
        $filt = $this->conexion->prepare ("INSERT into reserva (nombre_huesped, email_huesped, nombre_alojamiento, fecha_entrada, fecha_salida, importe, notas) 
        VALUES (:nombre, :email, :alojamiento, :entrada, :salida, :importe, :notas)");

        $guardado = $filt->execute([
            ':nombre' => $ArrayDatos["nombre_huesped"], 
            ':email' => $ArrayDatos["email_huesped"], 
            ':alojamiento' => $ArrayDatos["nombre_alojamiento"],
            ':entrada' => $ArrayDatos["fecha_entrada"],
            ':salida' => $ArrayDatos["fecha_salida"],
            ':importe' => $ArrayDatos["importe"],
            ':notas' => $ArrayDatos["notas"]
        ]);

        if ($guardado) {
            $consultaId = $this->conexion->prepare("SELECT id FROM reserva ORDER BY id DESC LIMIT 1");
            $consultaId->execute();
            $ultimaReserva = $consultaId->fetch();
            $idNuevo = $ultimaReserva['id'];

            $filtEvento = $this->conexion->prepare("INSERT into reserva_evento (reserva_id, tipo, descripcion) VALUES (:id, :tipo, :descripcion)");
            $filtEvento->execute([
                ':id' => $idNuevo,
                ':tipo' => 'CREACION',
                ':descripcion' => 'Reserva creada en la web en estado pendiente'
            ]);
        }

       return $guardado;      
    }
    public function CambiarReserva($id,$estado){
        $filt = $this->conexion->prepare("UPDATE reserva SET estado=:estado where id=:id");
        return $filt->execute([':id'=>$id, ':estado'=>$estado]);
    }
}
?>