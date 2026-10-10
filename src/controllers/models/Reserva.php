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

    public function CrearReserva($ArrayDatos){
        $filt = $this->conexion->prepare ("INSERT into reserva (nombre_huesped, email_huesped, nombre_alojamiento, fecha_entrada, fecha_salida, importe) 
        VALUES (:nombre, :email, :alojamiento, :entrada, :salida, :importe)");

        return $filt->execute([':nombre' =>$ArrayDatos["nombre_huesped"], ':email'=>$ArrayDatos["email_huesped"], ':alojamiento'=>$ArrayDatos["nombre_alojamiento"],
        ':entrada'=>$ArrayDatos["fecha_entrada"],':salida'=>$ArrayDatos["fecha_salida"],':importe'=>$ArrayDatos["importe"]]);       
    }
    public function CambiarReserva($id,$estado){
        $filt = $this->conexion->prepare("UPDATE reserva SET estado=:estado where id=:id");
        return $filt->execute([':id'=>$id, ':estado'=>$estado]);
    }
}
?>