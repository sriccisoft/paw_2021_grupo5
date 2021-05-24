<?php

namespace Paw\App\Controllers;

use Paw\Core\Controller;
use Paw\App\Models\TurnoCollection;
use Paw\App\Models\Turno;


class TurnoController extends Controller
{
    public ?string $modelName = Turno::class; // Devuelve 'Paw\App\Models\Turno'

    public $table = 'turnos';

    public function index()
    {
        $titulo = "Listado de Turnos";
        $turnos = $this->model->getAll();
        require $this->viewDir . "listadoTurnos.view.php";
    }


    public function saveTurno()
    {

        $datos = [];
        $datos["especialidad"] = $_POST["specialty_input"];
        $datos["profesional"] = $_POST["profesional_input"];
        $datos["nombre"] = $_POST["name_input"];
        $datos["apellido"] = $_POST["surname_input"];
        $datos["email"] = $_POST["email_input"];
        $datos["tel"] = $_POST["tel_input"];
        $datos["fechaNacimiento"] = $_POST["birth_date_input"];
        $datos["edad"] = $_POST["age_input"];
        $datos["fechaTurno"] = $_POST["turn_date_input"];

        $this->model->set($datos);

        $turnos_id = $this->model->insertTurno();

        #$this->model->guardarImagen($_FILES["archivo"], $turnos_id);

        $titulo = "Turno Solicitado";

        require $this->viewDir . "turnoSolicitado.view.php";
    }

}