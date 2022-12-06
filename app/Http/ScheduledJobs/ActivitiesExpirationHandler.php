<?php

namespace App\Http\ScheduledJobs;

use App\Models\Actividad;
use App\Models\Actividad_Evidencia;
use App\User;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Log;

class ActivitiesExpirationHandler
{
    const EVIDENCIAS_NO_VALIDADAS = 0;
    const EVIDENCIAS_VALIDADAS = 1;
    const ACTIVIDAD_SIN_RESPONSABLES = 2;

    public function __invoke() {
        $this->tratarActividadesCercanasAlCierre();
    }

    public function tratarActividadesCercanasAlCierre() {
        $fecha_rango_notificacion = $this->calFechaRangoCierre();
        $actividades_lista = Actividad::where('vigente', '=', 'true')->where('feccierre', '<=', $fecha_rango_notificacion)->get();
        $resultados = [];

        foreach ($actividades_lista as $actividad) {
            $status = $this->evidenciasValidadas($actividad);
            $curr_user_id = (int)$actividad->id_user;

            if (!array_key_exists($curr_user_id, $resultados)) {
                $this->initResultados($resultados, $curr_user_id);
            }

            $ref = &$resultados[$curr_user_id];

            switch ($status) {
                case self::ACTIVIDAD_SIN_RESPONSABLES:
                    array_push($ref->sin_responsables, $actividad->id);
                    break;
                case self::EVIDENCIAS_NO_VALIDADAS:
                    array_push($ref->no_validadas, $actividad->id);
                    break;
                case self::EVIDENCIAS_VALIDADAS:
                    array_push($ref->validadas, $actividad->id);
                    break;
            }
        }

        foreach ($resultados as $user_id => $res) {
            $this->cerrarActividades($res->validadas, $user_id);
        }
    }

    public function cerrarActividades($queue, $user_id) {
        try {
            if (count($queue) == 0) return;
            //Actividad::whereIn('id', $queue)->update(['vigente' => 'false']);
            Log::channel('jobs')->info(sprintf('User ID: %d, actividades cerradas [%s]', $user_id, implode(',', $queue)));
        } catch (\Exception $e) {
            Log::channel('jobs')->error($e->getMessage());
        }
    }

    private function initResultados(&$res, &$user_id) {
        $res[$user_id] = (object) [];
        $res[$user_id]->sin_responsables = [];
        $res[$user_id]->no_validadas = [];
        $res[$user_id]->validadas = [];
    }

    /**
     * @description Notificara via correo al encargado de la actividad que esta se encuentra proxima a cerrar,
     * solo si se encuentra en los dias de notificacion y no ha sido notificado previamente
     */
    public function notificar(&$actividad, &$fecha_rango_notificacion) {
        $encargado = User::find($actividad->id_user);
        dd($encargado);
    }

    public function evidenciasValidadas(&$actividad) : int {
        $actividades_evidencia = Actividad_Evidencia::where('actividad_id', '=', $actividad->id)->get();
        if ($actividades_evidencia->count() == 0) {
            return self::ACTIVIDAD_SIN_RESPONSABLES;
        }
        foreach ($actividades_evidencia as $evidencia) {
            if ($evidencia->validado != 'true') {
                return self::EVIDENCIAS_NO_VALIDADAS;
            }
        }
        return self::EVIDENCIAS_VALIDADAS;
    }

    /**
     * @description Dias previos a la fecha de cierre donde el encargado de la actividad
     * recibira un correo de notificacion en caso de la actividad haya sido cerrada.
     */
    public function getDiasDeNotificacion() : array {
        return [1, 7, 15];
    }

    public function getRangoNotificacion() : int {
        return (int)max($this->getDiasDeNotificacion()) + 1;
    }

    public function calFechaRangoCierre() {
        $fecha_rango_notificacion = new DateTime();
        $days_string = strval($this->getRangoNotificacion()) . ' days';
        date_add($fecha_rango_notificacion, DateInterval::createFromDateString($days_string));
        return $fecha_rango_notificacion;
    }

    /**
     * @descripcion Dias habiles para modificacion despues que la actividad ya haya sido cerrada automaticamente,
     * al terminar este periodo ya se permitiran modificaciones y la actividad ya dejara de ser vigente automaticamente
     */
    public function getDiasLimiteParaModificacion() : int {
        $dias = env('ACT_CIERRE_DIAS_LIMITE');
        if (!isset($dias) || !is_numeric($dias)) {
            return 15;
        }
        return intval($dias);
    }
}

