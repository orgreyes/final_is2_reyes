<?php

namespace Controllers;

use Exception;
use Model\Cita;
use Model\Paciente;
use Model\Medico;
use Model\Clinica;
use MVC\Router;

class DetalleCitasController
{
    public static function index(Router $router)
    {
        $citasPorFechas = static::CitasPorFechas();

        $router->render('detallecitas/index', [
            'citasPorFechas' => $citasPorFechas
        ]);
    }

    public static function CitasPorFechas()
    {
        try {
            $sql = "
                SELECT
                    cita_id,
                    cita_fecha,
                    cita_hora,
                    cita_referencia,
                    cita_situacion,
                    paciente_nombre,
                    paciente_dpi,
                    paciente_telefono,
                    clinica_nombre,
                    medico_nombre
                FROM
                    citas
                JOIN pacientes ON citas.cita_paciente = pacientes.paciente_id
                JOIN medicos ON citas.cita_medico = medicos.medico_id
                JOIN clinicas ON medicos.medico_clinica = clinicas.clinica_id
                WHERE cita_situacion = '1'
                ORDER BY cita_fecha, clinica_nombre, medico_nombre;
            ";

            // Suponiendo que tienes un método fetchArray en el modelo Cita que realiza la consulta SQL
            $citas = Cita::fetchArray($sql);

            // Ahora, agrupamos las citas por fecha, clínica y médico
            $citasPorFechas = [];
            foreach ($citas as $cita) {
                $fecha = date('Y-m-d', strtotime($cita['cita_fecha']));
                $clinica = $cita['clinica_nombre'];
                $medico = $cita['medico_nombre'];

                $cita['cita_hora'] = date('H:i', strtotime($cita['cita_hora']));

                if (!isset($citasPorFechas[$fecha])) {
                    $citasPorFechas[$fecha] = [];
                }

                if (!isset($citasPorFechas[$fecha][$clinica])) {
                    $citasPorFechas[$fecha][$clinica] = [];
                }

                if (!isset($citasPorFechas[$fecha][$clinica][$medico])) {
                    $citasPorFechas[$fecha][$clinica][$medico] = [];
                }

                $citasPorFechas[$fecha][$clinica][$medico][] = $cita;
            }

            return $citasPorFechas;
        } catch (Exception $e) {
            return [];
        }
    }
}
