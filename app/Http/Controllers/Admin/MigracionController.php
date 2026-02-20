<?php
// app/Http/Controllers/Admin/MigracionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use XBase\TableReader;
use App\Models\Materia;
use App\Models\Catedratico;
use App\Models\Kardex;
use App\Models\CalificacionTema;

class MigracionController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:VIP');
    }

    /**
     * Mostrar página de migración
     */
    public function index()
    {
        $opcionesMigracion = [
            'materias' => '📚 Materias',
            'catedraticos' => '👨‍🏫 Catedráticos (PERSONAL.DBF)',
            'kardex' => '📊 Kardex - Calificaciones finales (KARDEX.DBF)',
            'calificaciones' => '📝 Calificaciones por tema (LISTAS.DBF)',
        ];
        
        return view('admin.migraciones.index', compact('opcionesMigracion'));
    }

    /**
     * Procesar el archivo subido y migrar los datos
     */
    public function importar(Request $request)
    {
        // Verificar si es petición AJAX por el header o por el campo oculto
        $isAjax = $request->ajax() || $request->input('ajax') == '1';
        
        try {
            $request->validate([
                'archivo' => 'required|file|max:51200',
                'tipo_datos' => 'required|in:materias,catedraticos,kardex,calificaciones',
                'anio_inicio' => 'required_if:tipo_datos,kardex,calificaciones|integer|min:2000|max:2100',
                'anio_fin' => 'required_if:tipo_datos,kardex,calificaciones|integer|min:2000|max:2100|gte:anio_inicio',
                'truncate' => 'nullable'
            ]);

            $archivo = $request->file('archivo');
            $tipoDatos = $request->tipo_datos;
            $anioInicio = $request->anio_inicio;
            $anioFin = $request->anio_fin;
            $truncate = $request->has('truncate');

            $extension = strtolower($archivo->getClientOriginalExtension());
            if (!in_array($extension, ['dbf', 'DBF', 'Dbf'])) {
                if ($isAjax) {
                    return response()->json([
                        'success' => false,
                        'error' => 'El archivo debe ser de tipo .DBF'
                    ]);
                }
                Alert::error('Error', 'El archivo debe ser de tipo .DBF');
                return back()->withInput();
            }

            $nombreTemp = time() . '_' . $archivo->getClientOriginalName();
            $rutaTemp = $archivo->storeAs('temp', $nombreTemp);

            // Para archivos grandes
            set_time_limit(0);
            ini_set('memory_limit', '512M');
            
            $resultado = $this->procesarArchivoDBF(
                storage_path('app/' . $rutaTemp),
                $tipoDatos,
                $truncate,
                $anioInicio,
                $anioFin
            );

            Storage::delete($rutaTemp);

            // 🔥 SIEMPRE devolver JSON para peticiones AJAX
            if ($isAjax) {
                return response()->json([
                    'success' => $resultado['exitoso'],
                    'registros' => $resultado['registros'],
                    'error' => $resultado['mensaje'] ?? null,
                    'resumen' => $resultado['resumen'] ?? null,
                    'errores' => count($resultado['errores'] ?? [])
                ]);
            }

            // Respuesta tradicional (cuando NO es AJAX)
            if ($resultado['exitoso']) {
                $mensaje = "✅ Se importaron {$resultado['registros']} registros correctamente.";
                if (!empty($resultado['errores'])) {
                    $mensaje .= " ⚠️ " . count($resultado['errores']) . " errores.";
                    session()->flash('errores', array_slice($resultado['errores'], 0, 100));
                    Alert::warning('Importación con advertencias', $mensaje);
                } else {
                    Alert::success('¡Importación exitosa!', $mensaje);
                }
                session()->flash('resumen', $resultado['resumen']);
            } else {
                Alert::error('Error', $resultado['mensaje'] ?? 'Error desconocido');
            }

            return redirect()->route('migraciones.index');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'error' => 'Error de validación: ' . implode(', ', $e->errors())
                ]);
            }
            throw $e;
            
        } catch (\Exception $e) {
            if (isset($rutaTemp)) {
                Storage::delete($rutaTemp);
            }
            Log::error('Error importando: ' . $e->getMessage());
            
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'error' => 'Error: ' . $e->getMessage()
                ]);
            }
            
            Alert::error('Error', 'Ocurrió un error: ' . $e->getMessage());
            return redirect()->route('migraciones.index');
        }
    }

    /**
    * Procesar archivo DBF según el tipo de datos
    */
    private function procesarArchivoDBF($rutaArchivo, $tipoDatos, $truncate, $anioInicio = null, $anioFin = null)
    {
        $resultado = [
            'exitoso' => false,
            'registros' => 0,
            'errores' => [],
            'resumen' => [],
            'mensaje' => ''
        ];

        try {
            if (!file_exists($rutaArchivo)) {
                throw new \Exception("El archivo no existe: {$rutaArchivo}");
            }

            $table = new TableReader($rutaArchivo);
            
            $numRegistros = $table->getRecordCount();
            $columnas = $table->getColumns();
            $campos = [];
            
            foreach ($columnas as $columna) {
                $campos[] = $columna->getName();
            }
            
            $resultado['resumen']['archivo'] = basename($rutaArchivo);
            $resultado['resumen']['registros_totales'] = $numRegistros;
            $resultado['resumen']['campos'] = $campos;
            
            Log::info("Procesando {$tipoDatos} - Archivo: " . basename($rutaArchivo) . " - Registros: {$numRegistros}");
            
            if ($truncate) {
                $this->truncarTabla($tipoDatos);
                $resultado['resumen']['truncate'] = true;
            }

            $contador = 0;
            $errores = [];

            // Para archivos grandes, registrar progreso
            $progresoCallback = function($procesados, $total) {
                if ($total > 0 && $procesados % 1000 == 0) {
                    $porcentaje = round(($procesados / $total) * 100, 2);
                    Log::info("Progreso: {$procesados}/{$total} registros ({$porcentaje}%)");
                }
            };

            switch ($tipoDatos) {
                case 'materias':
                    $contador = $this->importarMaterias($table, $errores, $progresoCallback);
                    $resultado['resumen']['tipo'] = 'Materias';
                    break;
                    
                case 'catedraticos':
                    $contador = $this->importarCatedraticos($table, $errores, $progresoCallback);
                    $resultado['resumen']['tipo'] = 'Catedráticos';
                    break;
                    
                case 'kardex':
                    $contador = $this->importarKardex($table, $errores, $anioInicio, $anioFin, $progresoCallback);
                    $resultado['resumen']['tipo'] = 'Kardex';
                    $resultado['resumen']['anio_inicio'] = $anioInicio;
                    $resultado['resumen']['anio_fin'] = $anioFin;
                    break;
                    
                case 'calificaciones':
                    $contador = $this->importarCalificaciones($table, $errores, $anioInicio, $anioFin, $progresoCallback);
                    $resultado['resumen']['tipo'] = 'Calificaciones por tema';
                    $resultado['resumen']['anio_inicio'] = $anioInicio;
                    $resultado['resumen']['anio_fin'] = $anioFin;
                    break;
            }

            $resultado['exitoso'] = true;
            $resultado['registros'] = $contador;
            $resultado['errores'] = $errores;
            $resultado['resumen']['registros_importados'] = $contador;
            $resultado['resumen']['errores'] = count($errores);

        } catch (\Exception $e) {
            $resultado['mensaje'] = $e->getMessage();
            Log::error('Error procesando DBF: ' . $e->getMessage());
        }

        return $resultado;
    }

    /**
     * IMPORTAR CATEDRATICOS (PERSONAL.DBF) - VERSIÓN AJAX
     */
    private function importarCatedraticos($table, &$errores, $progresoCallback = null)
    {
        $contador = 0;
        $registrosProcesados = 0;
        $totalRegistros = $table->getRecordCount();
        
        while ($record = $table->nextRecord()) {
            $registrosProcesados++;
            
            try {
                $clave = $record->PERCVE ?? null;
                $app = $record->PERAPP ?? '';
                $apm = $record->PERAPM ?? '';
                $nombre = $record->PERNOM ?? '';
                $titulo = $record->PERSIG ?? null;
                $claveTrabajador = $record->PERTAR ?? null;
                $departamento = $record->PERDEP ?? '';
                $fechaIngreso = $record->PERASE ?? null;
                $fechaBaja = $record->PERARA ?? null;
                
                if (empty($clave)) {
                    $errores[] = "Registro #{$registrosProcesados}: Sin PERCVE (clave)";
                    continue;
                }          
                
                $fechaBajaLimpia = $this->limpiarFechaDBF($fechaBaja);               

                // Determinar estatus basado en fecha de baja REAL
                $estatus = 'ACTIVO';
                if (!empty($fechaBajaLimpia)) {
                    $estatus = 'BAJA';
                }
                
                Catedratico::updateOrCreate(
                    ['catedratico_clave' => $clave],
                    [
                        'nombre' => trim($nombre),
                        'apellido_paterno' => trim($app),
                        'apellido_materno' => trim($apm) ?: null,
                        'titulo' => trim($titulo) ?: null,
                        'cedula_profesional' => null,
                        'departamento_clave' => trim($departamento),                        
                        'email' => null,
                        'celular' => null,
                        'fecha_ingreso' => $this->formatearFechaDBF($fechaIngreso),
                        'fecha_baja' => $this->formatearFechaDBF($fechaBaja),                        
                        'estatus' => $estatus,                       
                        'observaciones' => $claveTrabajador ? "Clave trabajador: {$claveTrabajador}" : null
                    ]
                );
                
                $contador++;
                
                // Callback de progreso cada 500 registros
                if ($progresoCallback && $registrosProcesados % 500 == 0) {
                    $progresoCallback($registrosProcesados, $totalRegistros);
                }
                
            } catch (\Exception $e) {
                $clave = $record->PERCVE ?? 'DESCONOCIDO';
                $errores[] = "Error en registro {$clave}: " . $e->getMessage();
            }
        }
        
        // Callback final al terminar
        if ($progresoCallback) {
            $progresoCallback($registrosProcesados, $totalRegistros);
        }
        
        Log::info("Catedráticos importados: {$contador} de {$registrosProcesados} registros");
        
        return $contador;
    }
    
    /**
     * IMPORTAR KARDEX (KARDEX.DBF)
     */
    private function importarKardex($table, &$errores, $anioInicio, $anioFin, $progresoCallback = null)
    {
        $contador = 0;
        $registrosProcesados = 0;
        $totalRegistros = $table->getRecordCount();
        
        $mapaAcreditacion = [
            1 => 'ORDINARIA',
            2 => 'REGULARIZACION_ORDINARIO',
            3 => 'REPETICION',
            4 => 'REGULARIZACION_REPETICION',
            5 => 'EXTRAORDINARIO',
            6 => 'REGULARIZACION_EXTRAORDINARIO'
        ];
        
        while ($record = $table->nextRecord()) {
            $registrosProcesados++;
            
            try {
                $noControl = $record->ALUCTR ?? null;
                $materiaClave = $record->MATCVE ?? null;
                $calificacion = isset($record->KARCAL) ? floatval($record->KARCAL) : 0;
                $opcion = isset($record->TCACVE) ? intval($record->TCACVE) : null;
                $semestre = isset($record->KARNPE1) ? intval($record->KARNPE1) : 0;
                
                // Extraer año del registro (del número de control o actual)
                $anioRegistro = $this->extraerAnioKardex($noControl);
                
                // Filtrar por rango de años
                if ($anioRegistro < $anioInicio || $anioRegistro > $anioFin) {
                    continue;
                }
                
                if (empty($noControl)) {
                    $errores[] = "Registro #{$registrosProcesados}: Sin número de control";
                    continue;
                }
                
                if (empty($materiaClave)) {
                    $errores[] = "Registro {$noControl}: Sin clave de materia";
                    continue;
                }
                
                $opcionAcreditacion = $mapaAcreditacion[$opcion] ?? 'ORDINARIA';
                
                $situacion = 'CURSANDO';
                if ($calificacion >= 70) {
                    $situacion = 'ACREDITADA';
                } elseif ($calificacion > 0 && $calificacion < 70) {
                    $situacion = 'NO ACREDITADA';
                }
                
                // Construir período basado en el año (siempre semestre A por defecto)
                $periodo = $anioRegistro . 'A';
                
                Kardex::updateOrCreate(
                    [
                        'no_control' => $noControl,
                        'materia_clave' => $materiaClave,
                        'periodo' => $periodo
                    ],
                    [
                        'semestre' => $semestre,
                        'anio' => $anioRegistro,
                        'calificacion_final' => $calificacion,
                        'opcion_acreditacion' => $opcionAcreditacion,
                        'situacion' => $situacion,
                        'fecha_examen' => null,
                        'fecha_acreditacion' => $calificacion >= 70 ? now() : null,
                        'creditos_obtenidos' => $calificacion >= 70 ? $this->obtenerCreditosMateria($materiaClave) : 0,
                        'observaciones' => $opcion ? "TCACVE: {$opcion}" : null
                    ]
                );
                
                $contador++;
                
                // Callback de progreso cada 500 registros
                if ($progresoCallback && $registrosProcesados % 500 == 0) {
                    $progresoCallback($registrosProcesados, $totalRegistros);
                }
                
            } catch (\Exception $e) {
                $noControl = $record->ALUCTR ?? 'DESCONOCIDO';
                $errores[] = "Error en registro {$noControl}: " . $e->getMessage();
            }
        }
        
        // Callback final
        if ($progresoCallback) {
            $progresoCallback($registrosProcesados, $totalRegistros);
        }
        
        Log::info("Kardex importados: {$contador} de {$registrosProcesados} registros para años {$anioInicio}-{$anioFin}");
        
        return $contador;
    }

    /**
     * Extraer año del número de control para Kardex
     */
    private function extraerAnioKardex($noControl)
    {
        if (empty($noControl)) {
            return (int) date('Y');
        }
        
        $noControl = trim($noControl);
        
        // Intentar extraer año de los primeros 4 dígitos si es numérico
        if (preg_match('/^(\d{4})/', $noControl, $matches)) {
            $anio = (int) $matches[1];
            // Validar que sea un año razonable (2000-2100)
            if ($anio >= 2000 && $anio <= 2100) {
                return $anio;
            }
        }
        
        // Si no se pudo extraer, usar año actual
        return (int) date('Y');
    }

    /**
     * Extraer año del registro (adaptar según estructura real)
     */
    private function extraerAnioRegistro($record)
    {
        // Opción 1: Si hay un campo de fecha en el registro
        if (isset($record->FECHA) && !empty($record->FECHA)) {
            $fecha = $this->formatearFechaDBF($record->FECHA);
            if ($fecha) {
                return (int) substr($fecha, 0, 4);
            }
        }
        
        // Opción 2: Si el año está en el número de control (ej: 2021001)
        if (isset($record->ALUCTR) && !empty($record->ALUCTR)) {
            $noControl = trim($record->ALUCTR);
            // Intentar extraer año de los primeros 4 dígitos
            if (preg_match('/^(\d{4})/', $noControl, $matches)) {
                return (int) $matches[1];
            }
        }
        
        // Opción 3: Si hay un campo específico de año
        if (isset($record->ANIO) && !empty($record->ANIO)) {
            return (int) $record->ANIO;
        }
        
        // Valor por defecto: año actual
        return (int) date('Y');
    }

    /**
     * Insertar lote de registros en Kardex
     */
    private function insertarLoteKardex($batchData)
    {
        // Usar upsert para evitar duplicados (Laravel 8+)
        Kardex::upsert(
            $batchData,
            ['no_control', 'materia_clave', 'periodo'], // columnas para detectar duplicados
            [
                'semestre', 'anio', 'calificacion_final', 
                'opcion_acreditacion', 'situacion', 'creditos_obtenidos',
                'observaciones', 'updated_at'
            ]
        );
    }

    /**
     * IMPORTAR CALIFICACIONES POR TEMA (LISTAS.DBF)
     */
    private function importarCalificaciones($table, &$errores, $anioInicio, $anioFin, $progresoCallback = null)
    {
        $contador = 0;
        $registrosProcesados = 0;
        $totalRegistros = $table->getRecordCount();
        $materiasConUnidades = [];
        
        $mapaAcreditacion = [
            1 => 'ORDINARIA',
            2 => 'REGULARIZACION_ORDINARIO',
            3 => 'REPETICION',
            4 => 'REGULARIZACION_REPETICION',
            5 => 'EXTRAORDINARIO',
            6 => 'REGULARIZACION_EXTRAORDINARIO'
        ];
        
        while ($record = $table->nextRecord()) {
            $registrosProcesados++;
            
            try {
                $profesorClave = isset($record->PDOCVE) ? str_pad(trim($record->PDOCVE), 4, '0', STR_PAD_LEFT) : null;
                $noControl = $record->ALUCTR ?? null;
                $materiaClave = $record->MATCVE ?? null;
                $grupoClave = $record->GPOCVE ?? null;
                $calificacionFinal = isset($record->LISCAL) ? floatval($record->LISCAL) : 0;
                $opcion = isset($record->TCACVE) ? intval($record->TCACVE) : null;
                
                // Extraer año del registro
                $anioRegistro = $this->extraerAnioCalificaciones($noControl, $record);
                
                // Filtrar por rango de años
                if ($anioRegistro < $anioInicio || $anioRegistro > $anioFin) {
                    continue;
                }
                
                if (empty($noControl) || empty($materiaClave)) {
                    continue;
                }
                
                // Determinar número de unidades (de LISTC1 a LISTC15)
                $numUnidades = 0;
                for ($i = 1; $i <= 15; $i++) {
                    $campoListc = 'LISTC' . $i;
                    if (isset($record->$campoListc) && intval($record->$campoListc) == 1) {
                        $numUnidades++;
                    }
                }
                
                // Si no se detectaron unidades por LISTC, intentar con LISPA
                if ($numUnidades == 0) {
                    for ($i = 1; $i <= 15; $i++) {
                        $campoLispa = 'LISPA' . $i;
                        if (isset($record->$campoLispa) && floatval($record->$campoLispa) > 0) {
                            $numUnidades++;
                        }
                    }
                }
                
                // Si aún así no hay unidades, asumir 1 si hay calificación final
                if ($numUnidades == 0 && $calificacionFinal > 0) {
                    $numUnidades = 1;
                }
                
                // Procesar cada unidad
                for ($i = 1; $i <= $numUnidades; $i++) {
                    $campoLispa = 'LISPA' . $i;
                    $calificacionUnidad = isset($record->$campoLispa) ? floatval($record->$campoLispa) : 0;
                    
                    if ($calificacionUnidad > 0) {
                        CalificacionTema::updateOrCreate(
                            [
                                'no_control' => $noControl,
                                'materia_clave' => $materiaClave,
                                'num_tema' => $i,
                                'periodo' => $anioRegistro . 'A'
                            ],
                            [
                                'profesor_clave' => $profesorClave ?? 'DESCONOCIDO',
                                'grupo_clave' => $grupoClave ?? 'S/G',
                                'anio' => $anioRegistro,
                                'calificacion' => $calificacionUnidad,
                                'tipo_evaluacion' => $mapaAcreditacion[$opcion] ?? 'ORDINARIA',
                                'fecha_evaluacion' => null,
                                'nombre_tema' => "Unidad {$i}"
                            ]
                        );
                        
                        $contador++;
                    }
                }
                
                // Actualizar kardex con calificación final
                if ($calificacionFinal > 0) {
                    $semestre = $this->extraerSemestreDeGrupo($grupoClave);
                    
                    Kardex::updateOrCreate(
                        [
                            'no_control' => $noControl,
                            'materia_clave' => $materiaClave,
                            'periodo' => $anioRegistro . 'A'
                        ],
                        [
                            'semestre' => $semestre,
                            'anio' => $anioRegistro,
                            'calificacion_final' => $calificacionFinal,
                            'opcion_acreditacion' => $mapaAcreditacion[$opcion] ?? 'ORDINARIA',
                            'situacion' => $calificacionFinal >= 70 ? 'ACREDITADA' : 'NO ACREDITADA',
                            'creditos_obtenidos' => $calificacionFinal >= 70 ? $this->obtenerCreditosMateria($materiaClave) : 0
                        ]
                    );
                }
                
                // Callback de progreso cada 500 registros
                if ($progresoCallback && $registrosProcesados % 500 == 0) {
                    $progresoCallback($registrosProcesados, $totalRegistros);
                }
                
            } catch (\Exception $e) {
                $errores[] = "Error en registro #{$registrosProcesados}: " . $e->getMessage();
            }
        }
        
        // Callback final
        if ($progresoCallback) {
            $progresoCallback($registrosProcesados, $totalRegistros);
        }
        
        Log::info("Calificaciones importadas: {$contador} unidades de {$registrosProcesados} materias");
        
        return $contador;
    }

    /**
     * Extraer año del registro para calificaciones
     */
    private function extraerAnioCalificaciones($noControl, $record)
    {
        // Intentar del número de control
        if (!empty($noControl)) {
            $noControl = trim($noControl);
            if (preg_match('/^(\d{4})/', $noControl, $matches)) {
                $anio = (int) $matches[1];
                if ($anio >= 2000 && $anio <= 2100) {
                    return $anio;
                }
            }
        }
        
        // Si hay algún campo de fecha en el registro
        if (isset($record->FECHA) && !empty($record->FECHA)) {
            $fecha = $this->formatearFechaDBF($record->FECHA);
            if ($fecha) {
                return (int) substr($fecha, 0, 4);
            }
        }
        
        return (int) date('Y');
    }

    /**
     * IMPORTAR MATERIAS (archivo pendiente)
     */
    private function importarMaterias($table, &$errores, $progresoCallback = null)
    {
        $contador = 0;
        $registrosProcesados = 0;
        $totalRegistros = $table->getRecordCount();
        
        while ($record = $table->nextRecord()) {
            $registrosProcesados++;
            
            try {
                // TODO: Mapear campos cuando tengas la estructura real del archivo de materias
                // Ejemplo genérico:
                $materiaClave = $record->CLAVE ?? $record->MATCVE ?? null;
                $materiaNombre = $record->NOMBRE ?? $record->MATNOM ?? '';
                $creditos = $record->CREDITOS ?? 0;
                $semestre = $record->SEMESTRE ?? 1;
                $carreraClave = $record->CARRERA ?? $record->CARCLAVE ?? '';
                
                if (empty($materiaClave)) {
                    $errores[] = "Registro #{$registrosProcesados}: Sin clave de materia";
                    continue;
                }
                
                // Crear o actualizar materia
                Materia::updateOrCreate(
                    ['materia_clave' => $materiaClave],
                    [
                        'materia_nombre' => trim($materiaNombre),
                        'materia_nombre_corto' => substr(trim($materiaNombre), 0, 50),
                        'carrera_clave' => $carreraClave,
                        'carrera_nombre' => 'POR DEFINIR',
                        'semestre' => $semestre,
                        'plan_clave' => 'DEFAULT',
                        'departamento_clave' => 'S/D',
                        'creditos' => $creditos,
                        'horas_teoria' => 0,
                        'horas_practica' => 0,
                        'num_unidades' => 5,
                        'tipo_materia' => 'OBLIGATORIA',
                        'activa' => true,
                        'estatus' => 'VIGENTE'
                    ]
                );
                
                $contador++;
                
                // Callback de progreso cada 500 registros
                if ($progresoCallback && $registrosProcesados % 500 == 0) {
                    $progresoCallback($registrosProcesados, $totalRegistros);
                }
                
            } catch (\Exception $e) {
                $errores[] = "Error en registro #{$registrosProcesados}: " . $e->getMessage();
            }
        }
        
        // Callback final
        if ($progresoCallback) {
            $progresoCallback($registrosProcesados, $totalRegistros);
        }
        
        Log::info("Materias importadas: {$contador} de {$registrosProcesados} registros");
        
        return $contador;
    }

    /**
    * Formatear fecha del DBF a Y-m-d (MEJORADA)
    */
    private function formatearFechaDBF($fechaDBF)
    {
        if (empty($fechaDBF)) {
            return null;
        }
        
        // Si es string, limpiar espacios
        if (is_string($fechaDBF)) {
            $fechaDBF = trim($fechaDBF);
            if (empty($fechaDBF)) {
                return null;
            }
        }
        
        // Si es objeto DateTime
        if ($fechaDBF instanceof \DateTime) {
            return $fechaDBF->format('Y-m-d');
        }
        
        // Si es string en formato DBF (YYYYMMDD)
        if (is_string($fechaDBF) && strlen($fechaDBF) == 8 && is_numeric($fechaDBF)) {
            $anio = substr($fechaDBF, 0, 4);
            $mes = substr($fechaDBF, 4, 2);
            $dia = substr($fechaDBF, 6, 2);
            
            // Validar que sea una fecha real
            if (checkdate(intval($mes), intval($dia), intval($anio))) {
                return "{$anio}-{$mes}-{$dia}";
            }
        }
        
        // Si es timestamp numérico
        if (is_numeric($fechaDBF) && $fechaDBF > 0) {
            return date('Y-m-d', $fechaDBF);
        }
        
        return null;
    }

    /**
     * Determinar nivel de estudios basado en título
     */
    private function determinarNivelEstudios($titulo)
    {
        if (empty($titulo)) return null;
        
        $tituloUpper = strtoupper($titulo);
        
        if (strpos($tituloUpper, 'DR') !== false) return 'DOCTORADO';
        if (strpos($tituloUpper, 'MTR') !== false || strpos($tituloUpper, 'MAE') !== false) return 'MAESTRIA';
        if (strpos($tituloUpper, 'ING') !== false || strpos($tituloUpper, 'LIC') !== false) return 'LICENCIATURA';
        
        return null;
    }

    /**
     * Obtener créditos de una materia
     */
    private function obtenerCreditosMateria($materiaClave)
    {
        $materia = Materia::where('materia_clave', $materiaClave)->first();
        return $materia ? $materia->creditos : 0;
    }

    /**
     * Extraer semestre de la clave de grupo (ej: 5M1A → 5)
     */
    private function extraerSemestreDeGrupo($grupoClave)
    {
        if (empty($grupoClave)) {
            return 1;
        }
        
        preg_match('/^(\d+)/', $grupoClave, $matches);
        
        if (isset($matches[1])) {
            return intval($matches[1]);
        }
        
        return 1;
    }

    /**
     * Vaciar tabla según tipo
     */
    private function truncarTabla($tipoDatos)
    {
        switch ($tipoDatos) {
            case 'materias':
                Materia::truncate();
                Log::info('Tabla materias truncada');
                break;
            case 'catedraticos':
                Catedratico::truncate();
                Log::info('Tabla catedraticos truncada');
                break;
            case 'kardex':
                Kardex::truncate();
                Log::info('Tabla kardex truncada');
                break;
            case 'calificaciones':
                CalificacionTema::truncate();
                Log::info('Tabla calificaciones_temas truncada');
                break;
        }
    }

    /**
    * NUEVA FUNCIÓN: Limpiar fecha de DBF (elimina espacios y valida)
    */
    private function limpiarFechaDBF($fechaDBF)
    {
        if (empty($fechaDBF)) {
            return null;
        }
        
        // Si es string, limpiar espacios
        if (is_string($fechaDBF)) {
            $fechaLimpia = trim($fechaDBF);
            
            // Si después de limpiar espacios está vacío, es null
            if (empty($fechaLimpia)) {
                return null;
            }
            
            // Si tiene 8 espacios o caracteres no válidos
            if (strlen($fechaLimpia) == 0 || $fechaLimpia === '') {
                return null;
            }
        }
        
        // Usar la función existente para formatear
        return $this->formatearFechaDBF($fechaDBF);
    }

    /**
     * Formatear tamaño de archivo
     */
    private function formatearTamanio($bytes)
    {
        $unidades = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($unidades) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $unidades[$i];
    }
}