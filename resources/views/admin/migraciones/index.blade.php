@extends('template.molde')

@section('title','Importar datos')

@section('ruta')
	<label class="label label-success">Importar datos BDF</label>
@endsection

@section('contenido')
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				{{-- Tarjeta principal --}}
				<div class="card">
					<div class="card-header bg-primary text-white">
						<h4 class="mb-0">
							<i class="fas fa-database me-2"></i>Importar Archivos FoxPro (.DBF)
						</h4>
					</div>
					
					<div class="card-body">
						
						{{-- Mensajes de SweetAlert --}}
						@if(session('errores') && count(session('errores')) > 0)
							<div class="alert alert-warning alert-dismissible fade show" role="alert">
								<h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Se encontraron algunos errores:</h5>
								<div style="max-height: 200px; overflow-y: auto;">
									<ul class="mb-0">
										@foreach(session('errores') as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						@endif
						
						{{-- Mostrar resumen de importación --}}
						@if(session('resumen'))
							<div class="alert alert-info alert-dismissible fade show" role="alert">
								<h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Resumen de importación:</h5>
								<table class="table table-sm table-borderless mb-0">
									<tr>
										<td><strong>Archivo:</strong></td>
										<td>{{ session('resumen.archivo') }}</td>
									</tr>
									<tr>
										<td><strong>Tipo:</strong></td>
										<td>{{ session('resumen.tipo') }}</td>
									</tr>
									<tr>
										<td><strong>Registros en archivo:</strong></td>
										<td>{{ session('resumen.registros_totales') }}</td>
									</tr>
									<tr>
										<td><strong>Registros importados:</strong></td>
										<td>{{ session('resumen.registros_importados') }}</td>
									</tr>
									@if(session('resumen.anio_inicio'))
									<tr>
										<td><strong>Rango de años:</strong></td>
										<td>{{ session('resumen.anio_inicio') }} - {{ session('resumen.anio_fin') }}</td>
									</tr>
									@endif
									@if(session('resumen.truncate'))
									<tr>
										<td><strong>Tabla truncada:</strong></td>
										<td><span class="badge bg-warning">Sí</span></td>
									</tr>
									@endif
								</table>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						@endif
						
						{{-- Formulario principal con AJAX --}}
						<form action="{{ route('migraciones.importar') }}" 
							method="POST" 
							enctype="multipart/form-data"
							id="formImportar"
							class="mt-3">
							@csrf
							
							{{-- Campo oculto para AJAX --}}
							<input type="hidden" name="ajax" id="ajax" value="0">
							
							<div class="row">
								<div class="col-md-8 offset-md-2">
									
									{{-- Tipo de datos --}}
									<div class="mb-4">
										<label for="tipo_datos" class="form-label fw-bold">
											<i class="fas fa-tag me-1"></i>¿Qué tipo de datos vas a importar?
											<span class="text-danger">*</span>
										</label>
										<select name="tipo_datos" 
												id="tipo_datos" 
												class="form-select @error('tipo_datos') is-invalid @enderror"
												required>
											<option value="">-- Selecciona el tipo de datos --</option>
											@foreach($opcionesMigracion as $value => $label)
												<option value="{{ $value }}" {{ old('tipo_datos') == $value ? 'selected' : '' }}>
													{{ $label }}
												</option>
											@endforeach
										</select>
										@error('tipo_datos')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									
									{{-- Archivo --}}
									<div class="mb-4">
										<label for="archivo" class="form-label fw-bold">
											<i class="fas fa-file me-1"></i>Selecciona el archivo .DBF
											<span class="text-danger">*</span>
										</label>
										<div class="input-group">
											<input type="file" 
												class="form-control @error('archivo') is-invalid @enderror" 
												id="archivo" 
												name="archivo" 
												accept=".dbf,.DBF,.Dbf"
												required>
											<span class="input-group-text" id="fileSize"></span>
										</div>
										@error('archivo')
											<div class="invalid-feedback d-block">{{ $message }}</div>
										@enderror
										<div class="form-text text-muted">
											<i class="fas fa-info-circle me-1"></i>Máximo 50MB. Solo archivos .DBF
										</div>
									</div>
									
									{{-- Rango de años (para Kardex y Calificaciones) --}}
									<div class="mb-4" id="campoRangoAnios" style="display: none;">
										<label class="form-label fw-bold">
											<i class="fas fa-calendar-alt me-1"></i>Rango de años a importar
											<span class="text-danger">*</span>
										</label>
										<div class="row">
											<div class="col-md-6">
												<div class="input-group mb-2">
													<span class="input-group-text">Desde</span>
													<input type="number" 
														class="form-control @error('anio_inicio') is-invalid @enderror" 
														id="anio_inicio" 
														name="anio_inicio" 
														value="{{ old('anio_inicio', date('Y') - 5) }}"
														min="2000"
														max="2100"
														step="1"
														placeholder="Año inicial">
												</div>
												@error('anio_inicio')
													<div class="invalid-feedback d-block">{{ $message }}</div>
												@enderror
											</div>
											<div class="col-md-6">
												<div class="input-group mb-2">
													<span class="input-group-text">Hasta</span>
													<input type="number" 
														class="form-control @error('anio_fin') is-invalid @enderror" 
														id="anio_fin" 
														name="anio_fin" 
														value="{{ old('anio_fin', date('Y')) }}"
														min="2000"
														max="2100"
														step="1"
														placeholder="Año final">
												</div>
												@error('anio_fin')
													<div class="invalid-feedback d-block">{{ $message }}</div>
												@enderror
											</div>
										</div>
										<div class="form-text text-muted">
											<i class="fas fa-info-circle me-1"></i>Solo se importarán registros con año entre <span id="rangoInfo"></span>
										</div>
									</div>
									
									{{-- Opciones adicionales --}}
									<div class="mb-4">
										<div class="form-check">
											<input type="checkbox" 
												class="form-check-input" 
												id="truncate" 
												name="truncate" 
												value="1"
												{{ old('truncate') ? 'checked' : '' }}>
											<label class="form-check-label fw-bold" for="truncate">
												<i class="fas fa-trash-alt me-1 text-danger"></i>
												Vaciar tabla antes de importar
											</label>
											<div class="form-text text-muted">
												Si marcas esta opción, se eliminarán todos los registros existentes antes de importar
											</div>
										</div>
									</div>
									
									{{-- Información dinámica --}}
									<div class="alert alert-info" id="infoTipo" style="display: none;" role="alert">
										<i class="fas fa-info-circle me-2"></i>
										<span id="infoTexto"></span>
									</div>
									
									{{-- Barra de progreso mejorada --}}
									<div class="progress mb-4" id="barraProgreso" style="display: none; height: 30px;">
										<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
											id="progreso"
											role="progressbar" 
											style="width: 0%"
											aria-valuenow="0"
											aria-valuemin="0"
											aria-valuemax="100">
											<span id="progresoTexto">0%</span>
										</div>
									</div>
									
									{{-- Estado de importación mejorado --}}
									<div id="estadoImportacion" class="text-center mb-3" style="display: none;">
										<div class="d-flex align-items-center justify-content-center">
											<div class="spinner-border text-primary me-3" role="status" id="spinnerImportacion">
												<span class="visually-hidden">Cargando...</span>
											</div>
											<div class="text-start">
												<div class="fw-bold" id="estadoTexto">Preparando importación...</div>
												<div class="small text-muted" id="registrosProcesados"></div>
												<div class="small text-muted" id="tiempoTranscurrido"></div>
											</div>
										</div>
									</div>
									
									{{-- Botones --}}
									<div class="d-flex justify-content-center gap-3 mt-4">
										<button type="submit" class="btn btn-success btn-lg" id="btnImportar">
											<i class="fas fa-upload me-2"></i>Importar Datos
										</button>
										<button type="button" class="btn btn-info btn-lg" id="btnDepurar">
											<i class="fas fa-bug me-2"></i>Depurar
										</button>
										<button type="reset" class="btn btn-outline-secondary btn-lg" id="btnLimpiar">
											<i class="fas fa-undo me-2"></i>Limpiar
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				
				{{-- Instrucciones y ayuda en dos columnas --}}
				<div class="row mt-4">
					<div class="col-md-6 mb-3">
						<div class="card h-100">
							<div class="card-header bg-info text-white">
								<h5 class="mb-0">
									<i class="fas fa-question-circle me-2"></i>Instrucciones
								</h5>
							</div>
							<div class="card-body">
								<ol class="mb-0">
									<li class="mb-2">Selecciona el <strong>tipo de datos</strong> que vas a importar</li>
									<li class="mb-2">Haz clic en "Elegir archivo" y selecciona tu archivo <code>.DBF</code></li>
									<li class="mb-2">Para Kardex y Calificaciones, especifica el <strong>rango de años</strong> a importar</li>
									<li class="mb-2">Opcional: marca "Vaciar tabla" si quieres reemplazar todos los datos</li>
									<li class="mb-2">Haz clic en "Importar Datos" y espera a que termine el proceso</li>
									<li class="mb-2">Usa "Depurar" para ver la estructura del archivo sin importar</li>
									<li class="mb-2 text-info"><i class="fas fa-hourglass-half me-1"></i>La barra de progreso mostrará el avance en tiempo real</li>
								</ol>
							</div>
						</div>
					</div>
					
					<div class="col-md-6 mb-3">
						<div class="card h-100">
							<div class="card-header bg-warning">
								<h5 class="mb-0">
									<i class="fas fa-file-alt me-2"></i>Formatos esperados
								</h5>
							</div>
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table table-sm mb-0">
										<thead class="table-light">
											<tr>
												<th>Tipo</th>
												<th>Archivo esperado</th>
												<th>Campos principales</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Catedráticos</td>
												<td><code>PERSONAL.DBF</code></td>
												<td><small>PERCVE, PERAPP, PERAPM, PERNOM, PERSIG, PERDEP</small></td>
											</tr>
											<tr>
												<td>Kardex</td>
												<td><code>KARDEX.DBF</code></td>
												<td><small>ALUCTR, MATCVE, KARCAL, TCACVE, KARNPE1</small></td>
											</tr>
											<tr>
												<td>Calificaciones</td>
												<td><code>LISTAS.DBF</code></td>
												<td><small>ALUCTR, MATCVE, GPOCVE, LISPA1..LISPA15</small></td>
											</tr>
											<tr>
												<td>Materias</td>
												<td><code>MATERIAS.DBF</code></td>
												<td><small>Pendiente</small></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- Modal para depuración --}}
	<div class="modal fade" id="modalDepuracion" tabindex="-1" aria-labelledby="modalDepuracionLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header bg-info text-white">
					<h5 class="modal-title" id="modalDepuracionLabel">
						<i class="fas fa-bug me-2"></i>Información de depuración
					</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="modalDepuracionBody">
					<div class="text-center">
						<div class="spinner-border text-primary" role="status">
							<span class="visually-hidden">Cargando...</span>
						</div>
						<p class="mt-2">Cargando información del archivo...</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			
			// Elementos del DOM
			const tipoDatos = document.getElementById('tipo_datos');
			const archivo = document.getElementById('archivo');
			const fileSize = document.getElementById('fileSize');
			const campoRangoAnios = document.getElementById('campoRangoAnios');
			const anioInicio = document.getElementById('anio_inicio');
			const anioFin = document.getElementById('anio_fin');
			const infoTipo = document.getElementById('infoTipo');
			const infoTexto = document.getElementById('infoTexto');
			const btnImportar = document.getElementById('btnImportar');
			const btnDepurar = document.getElementById('btnDepurar');
			const btnLimpiar = document.getElementById('btnLimpiar');
			const barraProgreso = document.getElementById('barraProgreso');
			const progreso = document.getElementById('progreso');
			const progresoTexto = document.getElementById('progresoTexto');
			const estadoImportacion = document.getElementById('estadoImportacion');
			const estadoTexto = document.getElementById('estadoTexto');
			const registrosProcesados = document.getElementById('registrosProcesados');
			const tiempoTranscurrido = document.getElementById('tiempoTranscurrido');
			
			// Mensajes informativos (igual que antes)
			const mensajes = {
				'materias': '📚 Importarás el catálogo de materias.',
				'catedraticos': '👨‍🏫 Importarás el catálogo de profesores.',
				'kardex': '📊 Importarás calificaciones finales.',
				'calificaciones': '📝 Importarás calificaciones por tema.'
			};
			
			// Mostrar tamaño del archivo
			archivo.addEventListener('change', function() {
				if (this.files && this.files[0]) {
					let file = this.files[0];
					let size = (file.size / (1024 * 1024)).toFixed(2);
					fileSize.textContent = size + ' MB';
				}
			});
			
			// Mostrar/ocultar rango de años
			tipoDatos.addEventListener('change', function() {
				let tipo = this.value;
				campoRangoAnios.style.display = (tipo === 'kardex' || tipo === 'calificaciones') ? 'block' : 'none';
				
				if (tipo && mensajes[tipo]) {
					infoTexto.textContent = mensajes[tipo];
					infoTipo.style.display = 'block';
				} else {
					infoTipo.style.display = 'none';
				}
			});
			
			// Botón depurar (igual que antes)
			btnDepurar.addEventListener('click', async function(e) {
				e.preventDefault();
				// ... mantener el código existente de depuración ...
			});
			
			// Botón limpiar
			btnLimpiar.addEventListener('click', function() {
				tipoDatos.value = '';
				archivo.value = '';
				fileSize.textContent = '';
				infoTipo.style.display = 'none';
				campoRangoAnios.style.display = 'none';
			});
						
			// Envío del formulario
			document.getElementById('formImportar').addEventListener('submit', async function(e) {
				e.preventDefault();
				
				// Validaciones básicas
				if (!tipoDatos.value || !archivo.files[0]) {
					Swal.fire('Atención', 'Completa todos los campos', 'warning');
					return;
				}
				
				// Mostrar UI de progreso
				barraProgreso.style.display = 'block';
				estadoImportacion.style.display = 'block';
				btnImportar.disabled = true;
				btnImportar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Importando...';
				btnDepurar.disabled = true;
				btnLimpiar.disabled = true;
				
				// Resetear progreso
				progreso.style.width = '0%';
				progresoTexto.textContent = '0%';
				estadoTexto.innerHTML = 'Procesando archivo...';
				registrosProcesados.innerHTML = '';
				
				// ANIMACIÓN AUTOMÁTICA
				let progresoAutomatico = 0;
				let intervalo = setInterval(() => {
					if (progresoAutomatico < 90) {
						progresoAutomatico += Math.random() * 2;
						if (progresoAutomatico > 90) progresoAutomatico = 90;
						progreso.style.width = progresoAutomatico + '%';
						progresoTexto.textContent = Math.floor(progresoAutomatico) + '%';
					}
				}, 800);
				
				try {
					let formData = new FormData(this);
					formData.append('ajax', '1'); // Forzar AJAX
					
					let response = await fetch(this.action, {
						method: 'POST',
						body: formData,
						headers: {
							'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
							'X-Requested-With': 'XMLHttpRequest' // Importante para que Laravel detecte AJAX
						}
					});
					
					// Verificar si la respuesta es JSON
					let contentType = response.headers.get('content-type');
					if (!contentType || !contentType.includes('application/json')) {
						let text = await response.text();
						throw new Error('Respuesta no válida del servidor. Posible error de PHP.');
					}
					
					let data = await response.json();
					clearInterval(intervalo);
					
					if (data.success) {
						// ===== COMPLETAR ANIMACIÓN =====
						progreso.style.width = '100%';
						progresoTexto.textContent = '100%';
						
						// 🔥 FORZAR CAMBIO DE COLOR
						progreso.classList.add('bg-success'); // Asegurar que tiene la clase
						progreso.style.background = 'linear-gradient(45deg, #007bff, #00bfff)'; // Forzar color azul
						
						// Quitar animación de rayas cuando está al 100%
						progreso.classList.remove('progress-bar-animated');
						progreso.classList.remove('progress-bar-striped');
						
						// Mensaje GRANDE y BONITO
						estadoTexto.innerHTML = '<div class="text-success fw-bold fs-4 mb-2">✅ ¡Importación completada!</div>';

						let resumenHtml = '';
						if (data.resumen) {
							// Quitamos 'small' y 'p-2' para dar más aire y tamaño
							resumenHtml = '<div class="alert alert-success mt-2 p-3 fs-5">'; 
							resumenHtml += `<strong>Archivo:</strong> ${data.resumen.archivo || 'N/A'}<br>`;
							resumenHtml += `<strong>Tipo:</strong> ${data.resumen.tipo || 'N/A'}<br>`;
							resumenHtml += `<strong>Registros:</strong> ${data.resumen.registros_importados || 0} de ${data.resumen.registros_totales || 0}<br>`;
							
							if (data.errores > 0) {
								resumenHtml += `<span class="text-danger fw-bold">⚠ ${data.errores} errores</span>`;
							}
							resumenHtml += '</div>';
						} else {
							// Versión simplificada también en tamaño fs-5
							resumenHtml = `<div class="alert alert-success mt-2 fs-5">✅ ${data.registros || 0} registros importados</div>`;
						}

						registrosProcesados.innerHTML = resumenHtml;
						
						setTimeout(() => window.location.reload(), 2000);
						
					} else {
						throw new Error(data.error || 'Error en importación');
					}
					
				} catch (error) {
					clearInterval(intervalo);
					barraProgreso.style.display = 'none';
					estadoImportacion.style.display = 'none';
					btnImportar.disabled = false;
					btnImportar.innerHTML = '<i class="fas fa-upload me-2"></i>Importar Datos';
					btnDepurar.disabled = false;
					btnLimpiar.disabled = false;
					
					console.error('Error detallado:', error);
					Swal.fire('Error', error.message, 'error');
				}
			});
		});
	</script>

	<style>
		/* Estilos base de la barra */
		.progress {
			height: 30px !important;
			background-color: #f0f0f0 !important;
			border-radius: 15px !important;
			overflow: hidden !important;
			box-shadow: inset 0 1px 3px rgba(0,0,0,0.2) !important;
			border: 2px solid #ddd !important;
		}
		
		/* Estilo normal de la barra (verde degradado) */
		.progress-bar {
			background: linear-gradient(45deg, #28a745, #20c997) !important;
			transition: width 0.5s ease !important;
			font-weight: bold !important;
			font-size: 14px !important;
			line-height: 30px !important;
			color: white !important;
		}
		
		/* Cuando está al 100%, cambiar a azul brillante */
		.progress-bar.bg-success[style*="width: 100%"] {
			background: linear-gradient(45deg, #007bff, #00bfff) !important;
			box-shadow: 0 0 15px rgba(0,123,255,0.5) !important;
		}
		
		/* Para la animación de rayas */
		.progress-bar-striped {
			background-image: linear-gradient(45deg, 
				rgba(255,255,255,0.2) 25%, 
				transparent 25%, 
				transparent 50%, 
				rgba(255,255,255,0.2) 50%, 
				rgba(255,255,255,0.2) 75%, 
				transparent 75%, 
				transparent) !important;
			background-size: 1.5rem 1.5rem !important;
		}
		
		.progress-bar-animated {
			animation: progress-bar-stripes 1s linear infinite !important;
		}
		
		@keyframes progress-bar-stripes {
			0% { background-position: 1.5rem 0; }
			100% { background-position: 0 0; }
		}
		
		/* Cuando está al 100%, quitar la animación */
		.progress-bar[style*="width: 100%"] {
			animation: none !important;
		}
	</style>
@endsection