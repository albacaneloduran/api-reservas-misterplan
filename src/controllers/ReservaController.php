<?php
require_once __DIR__ . '/../models/Reserva.php';
class ReservaController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Reserva();
    }

    public function listarR()
    {
        $filtros = [
            'estado' => isset($_GET['estado']) ? $_GET['estado'] : null,
            'fecha_desde' => isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : null,
            'fecha_hasta' => isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : null,
            'nombre' => isset($_GET['nombre']) ? $_GET['nombre'] : null
        ];
        $datos = $this->modelo->ListarReserva($filtros);
        http_response_code(200);
        echo json_encode($datos);
    }

    public function detalleR($id)
    {
        $datos = $this->modelo->DetalleReserva($id);
        if ($datos) {
            http_response_code(200);
            echo json_encode($datos);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "la reserva no existe"]);
        }
    }

    public function crearR($ArrayDatos)
    {
        if (empty($ArrayDatos["nombre_huesped"]) || empty($ArrayDatos["email_huesped"])) {
            http_response_code(400);
            echo json_encode(["error" => "los campos email y nombre son obligatorios"]);
            return;
        } else if (empty($ArrayDatos["fecha_entrada"]) || empty($ArrayDatos["fecha_salida"])) {
            http_response_code(400);
            echo json_encode(["error" => "no se ha seleccionado una fecha de entrada o de salida"]);
            return;
        } else if (strtotime($ArrayDatos["fecha_salida"]) <= strtotime($ArrayDatos["fecha_entrada"])) {
            http_response_code(400);
            echo json_encode(["error" => "La fecha de salida debe ser posterior a la de entrada"]);
            return;
        } else if (!isset($ArrayDatos["importe"]) || $ArrayDatos["importe"] < 0) {
            http_response_code(400);
            echo json_encode(["error" => "El importe es obligatorio"]);
            return;
        } else if (!filter_var($ArrayDatos["email_huesped"], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(["error" => "formato de email erroneo"]);
            return;
        }

        $datos = $this->modelo->CrearReserva($ArrayDatos);
        if ($datos) {
            http_response_code(201);
            echo json_encode(["mensaje" => "reserva creada con exito"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "error interno al guardar la reserva"]);
        }

    }

    public function cambiarR($id, $nuevoEstado)
    {
        if ($nuevoEstado == "") {
            http_response_code(400);
            echo json_encode(["error" => "el estado no puede estar vacio"]);
            return;
        } else if ($nuevoEstado != "pendiente" && $nuevoEstado != "confirmada" && $nuevoEstado != "cancelada") {
            http_response_code(400);
            echo json_encode(["error" => "estado no valido, las opciones son pendiente, confirmada o cancelada"]);
            return;
        }
        $datos = $this->modelo->CambiarReserva($id, $nuevoEstado);
        if ($datos) {
            http_response_code(200);
            echo json_encode(["mensaje" => " estado de la reserva actualizado a : " . $nuevoEstado]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "error interno al acttualizar la reserva"]);
        }
    }

    //Para las vistas
    private $twig;
    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    public function mostrarTabla()
    {
        $datos = $this->modelo->ListarReserva();
        echo $this->twig->render('tabla.twig', ['datos' => $datos]);
    }

    public function mostrarDetallesR($id)
    {
        $datos = $this->modelo->DetalleReserva($id);
        if (!$datos) {
            http_response_code(404);
            echo $this->twig->render('detalle.twig', ['datos' => false]);
            return;
        }
        $historial = $this->modelo->HistorialReserva($id);

        echo $this->twig->render('detalleR.twig', ['datos' => $datos, 'historial' => $historial]);
    }
}
?>