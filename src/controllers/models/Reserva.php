<?php
require_once __DIR__ . '/../../config/database.php';

class Reserva
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Database::conectar();
    }
    public function ListarReserva()
    {
        $filt = $this->conexion->prepare("SELECT * from reserva");
        $filt->execute();
        return $filt->fetchAll();
    }

    public function DetalleReserva($id){
        $filt = $this->conexion->prepare("SELECT * from reserva where id=:id ");
        $filt->execute([':id'=>$id]);
        return $filt->fetch();
    }

    public function CrearReserva($datos){
        $filt = $this->conexion->prepare ("INSERT into reserva (nombre_huesped, email_huesped, nombre_alojamiento, fecha_entrada, fecha_salida, importe) 
        VALUES (:nombre, :email, :alojamiento, :entrada, :salida, :importe)");

        return $filt->execute([':nombre' =>$datos["nombre_huesped"], ':email'=>$datos["email_huesped"], ':alojamiento'=>$datos["nombre_alojamiento"],
        ':entrada'=>$datos["fecha_entrada"],':salida'=>$datos["fecha_salida"],':importe'=>$datos["importe"]]);       
    }
    public function CambiarReserva($id,$estado){
        $filt = $this->conexion->prepare("UPDATE reserva SET estado=:estado where id=:id");
        return $filt->execute([':id'=>$id, ':estado'=>$estado]);
    }
}
?>