<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['student_id'])) {
    die("<div class='alert alert-danger'>Sesión no iniciada. Por favor inicie sesión nuevamente.</div>");
}

$student_id = $_SESSION['student_id'];

// busca tramites
try {
    $stmt = $pdo->prepare("
        SELECT j.*, GROUP_CONCAT(CONCAT(d.fecha, ' - ', d.curso) SEPARATOR '||') as detalles
        FROM justificativos j
        LEFT JOIN justificativo_detalles d ON j.id = d.justificativo_id
        WHERE j.estudiante_id = :estudiante_id
        GROUP BY j.id
        ORDER BY j.fecha_envio DESC, j.id DESC
    ");
    $stmt->execute([':estudiante_id' => $student_id]);
    $justificativos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("<div class='alert alert-danger'>Error al obtener justificativos: " . htmlspecialchars($e->getMessage()) . "</div>");
}
?>
<style>
    .just-tabs {
        margin-bottom: 15px;
        border-bottom: 2px solid #2e6492;
        padding-bottom: 0px;
    }
    .just-tab-btn {
        background: #f1f1f1;
        border: 1px solid #ccc;
        border-bottom: none;
        padding: 8px 16px;
        cursor: pointer;
        font-weight: bold;
        font-family: Arial, sans-serif;
        color: #2e6492;
        margin-right: 5px;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }
    .just-tab-btn.active {
        background: #2e6492;
        color: white;
        border-color: #2e6492;
    }
    .just-section {
        display: none;
    }
    .just-section.active {
        display: block;
    }
    .calendar-table {
        border-collapse: collapse;
        width: 100%;
        font-family: Arial, sans-serif;
        font-size: 13px;
    }
    .calendar-table th {
        background-color: #2e6492;
        color: white;
        padding: 6px;
        text-align: center;
    }
    .calendar-table td {
        border: 1px solid #ccc;
        width: 14.28%;
        height: 40px;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
    }
    .calendar-table td.empty {
        background-color: #fdfdfd;
        cursor: default;
    }
    .calendar-table td.selected {
        background-color: #e9ef18 !important;
        color: #2e6492 !important;
        font-weight: bold;
        border: 2px solid #2e6492;
    }
    .calendar-table td:not(.empty):hover {
        background-color: #e9ef18;
        color: #2e6492;
    }
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
        color: white;
    }
    .badge-pending {
        background-color: #f0ad4e;
    }
    .badge-approved {
        background-color: #5cb85c;
    }
    .badge-rejected {
        background-color: #d9534f;
    }
</style>

<div>
    <center>
        <table width='100%'>
            <tr>
                <td align='left'>
                    <font size='5' color='#2e6492'><strong>JUSTIFICATIVOS DE INASISTENCIA</strong></font>
                </td>
            </tr>
        </table>
    </center>
    <br>

    <div class="just-tabs">
        <button class="just-tab-btn active" onclick="switchJustTab('nueva_solicitud')">Nueva Solicitud</button>
        <button class="just-tab-btn" onclick="switchJustTab('mis_tramites')">Mis Trámites</button>
        <button class="just-tab-btn" onclick="switchJustTab('como_funciona')">Cómo Funciona</button>
    </div>

    <!-- SECCION: COMO FUNCIONA -->
    <div id="sec_como_funciona" class="just-section">
        <table width='100%' border='0' cellspacing='1' cellpadding='10' style='font-family: Arial, sans-serif; font-size: 13px; border: 1px solid #ccc;'>
            <tr bgcolor='#f9f9f9'>
                <td>
                    <font size='4' color='#2e6492'><b>Guía del Proceso de Justificación de Inasistencias</b></font>
                    <br><br>
                    <p align="justify">
                        De acuerdo con el Reglamento de Estudiantes de la Universidad Católica de Temuco, si no asistes a una evaluación o clase obligatoria por razones de fuerza mayor, debes realizar el proceso de justificación formal para tener derecho a una evaluación recuperativa.
                    </p>
                    <hr size="1" color="#ccc">
                    <b>Pasos a seguir:</b>
                    <ol style="margin-top: 5px; line-height: 1.5em;">
                        <li>Ir a la pestaña <b>"Nueva Solicitud"</b>.</li>
                        <li><b>Hacer clic en las fechas del calendario</b> en las que faltaste. Al hacer clic en un día, se abrirá un cuadro para que selecciones a qué ramos específicos faltaste ese día.</li>
                        <li>Adjuntar el documento que respalde tu inasistencia (licencia médica, certificado de salud, documento legal o laboral). El documento debe estar en formato PDF o imagen.</li>
                        <li>Hacer clic en <b>"Enviar Trámite"</b>.</li>
                    </ol>
                    <hr size="1" color="#ccc">
                    <b>Consideraciones Importantes:</b>
                    <ul>
                        <li>El plazo máximo para subir un justificativo es de <b>5 días hábiles</b> contados desde la fecha de inicio de la inasistencia.</li>
                        <li>Las licencias médicas y certificados de salud serán visados por el área de Salud de Bienestar Estudiantil.</li>
                        <li>Una vez aprobado, se notificará automáticamente al docente del ramo para que coordine la fecha de la evaluación pendiente.</li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>

    <!-- SECCION: NUEVA SOLICITUD -->
    <div id="sec_nueva_solicitud" class="just-section active">
        <form id="form_justificativo" onsubmit="submitJustificativoLocal(event)">
            <table width='100%' border='0' cellspacing='1' cellpadding='6' style='font-family: Arial, sans-serif; font-size: 13px; border: 1px solid #ccc;'>
                <tr bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                    <td colspan='2'>Formulario de Ingreso de Justificación</td>
                </tr>
                <tr bgcolor='#ffffff'>
                    <td colspan="2">
                        <!-- Selector de Mes -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-family: Arial, sans-serif;">
                            <button type="button" onclick="prevMonth()" style="background: #2e6492; color: white; border: none; padding: 4px 12px; cursor: pointer; font-weight: bold; border-radius: 3px;">&larr;</button>
                            <span id="calendar_month_year" style="font-weight: bold; font-size: 14px; color: #2e6492; text-transform: uppercase;">MAYO 2026</span>
                            <button type="button" onclick="nextMonth()" style="background: #2e6492; color: white; border: none; padding: 4px 12px; cursor: pointer; font-weight: bold; border-radius: 3px;">&rarr;</button>
                        </div>
                        <!-- Calendario interactivo -->
                        <table class="calendar-table">
                            <thead>
                                <tr>
                                    <th>Lu</th><th>Ma</th><th>Mi</th><th>Ju</th><th>Vi</th><th>Sá</th><th>Do</th>
                                </tr>
                            </thead>
                            <tbody id="calendar_tbody">
                                <!-- Se renderiza dinámicamente -->
                            </tbody>
                        </table>
                        
                        <div style="margin-top: 15px;">
                            <b style="color: #2e6492; font-size: 13px;">Días e inasistencias marcados:</b>
                            <div id="selected_days_container" style="margin-top: 6px;">
                                <span style="color: #666; font-style: italic;">Ningún día seleccionado. Haz clic en el calendario para marcar días.</span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr bgcolor='#f5f5f5'>
                    <td><b>Adjuntar Justificativo:</b><br><small style="color: #666;">(PDF o imagen)</small></td>
                    <td>
                        <input type="file" id="just_file" required accept="application/pdf, image/*" style="padding: 4px;">
                    </td>
                </tr>
                <tr bgcolor='#ffffff'>
                    <td valign="top"><b>Motivo / Observaciones:</b></td>
                    <td>
                        <textarea id="just_motivo" style="width: 100%; height: 60px; font-family: Arial, sans-serif; padding: 4px;" placeholder="Explique brevemente el motivo general de su inasistencia... (opcional)"></textarea>
                    </td>
                </tr>
                <tr bgcolor='#f5f5f5'>
                    <td>&nbsp;</td>
                    <td>
                        <input type="submit" value="Enviar Trámite" style="background-color: #2e6492; color: white; border: none; padding: 6px 16px; font-weight: bold; cursor: pointer; border-radius: 2px;">
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <!-- SECCION: MIS TRAMITES -->
    <div id="sec_mis_tramites" class="just-section">
        <table width='100%' border='0' cellspacing='1' cellpadding='6' id="just_list_table" style='font-family: Arial, sans-serif; font-size: 13px; border: 1px solid #ccc;'>
            <thead>
                <tr bgcolor='#2e6492' style='color: white; font-weight: bold; text-align: center;'>
                    <td>ID</td>
                    <td>Fecha Envío</td>
                    <td>Asignatura / Días</td>
                    <td>Documento</td>
                    <td>Estado</td>
                </tr>
            </thead>
            <tbody id="just_list_body">
                <?php if (count($justificativos) === 0): ?>
                    <tr bgcolor='#ffffff'>
                        <td colspan='5' align='center'>No registra trámites de justificativos.</td>
                    </tr>
                <?php else: ?>
                    <?php 
                    $i = 0;
                    foreach ($justificativos as $tr): 
                        $bg = ($i % 2 === 0) ? '#f5f5f5' : '#ffffff';
                        $badgeClass = 'badge-pending';
                        if ($tr['estado'] === 'Aprobado') {
                            $badgeClass = 'badge-approved';
                        } elseif ($tr['estado'] === 'Rechazado') {
                            $badgeClass = 'badge-rejected';
                        }
                        
                        // parsea detalles
                        $detalles_arr = [];
                        $fechas_arr = [];
                        if (!empty($tr['detalles'])) {
                            $parts = explode('||', $tr['detalles']);
                            foreach ($parts as $p) {
                                $p_parts = explode(' - ', $p, 2);
                                if (count($p_parts) === 2) {
                                    $fechas_arr[] = date('d/m/Y', strtotime($p_parts[0]));
                                    $detalles_arr[] = $p_parts[1];
                                }
                            }
                        }
                        $distinct_courses = array_unique($detalles_arr);
                        $distinct_dates = array_unique($fechas_arr);
                        
                        $i++;
                    ?>
                        <tr bgcolor='<?php echo $bg; ?>' style='font-family: Arial, sans-serif;'>
                            <td align='center'><b><?php echo htmlspecialchars($tr['codigo_tramite']); ?></b></td>
                            <td align='center'><?php echo date('d/m/Y', strtotime($tr['fecha_envio'])); ?></td>
                            <td>
                                <b>Asignatura(s) afectada(s):</b><br>
                                <span style="font-size: 11px; line-height: 1.3em; display: block; margin: 2px 0;">
                                    <?php 
                                    if (count($distinct_courses) > 0) {
                                        foreach ($distinct_courses as $c) {
                                            echo "• " . htmlspecialchars($c) . "<br>";
                                        }
                                    } else {
                                        echo "Asignatura no especificada";
                                    }
                                    ?>
                                </span>
                                <small>Días inasistencia: <?php echo implode(', ', $distinct_dates); ?></small><br>
                                <small style="color: #666; display: block; margin-top: 2px;"><b>Obs:</b> <?php echo htmlspecialchars($tr['comentarios']); ?></small>
                            </td>
                            <td align='center'>
                                <?php if (!empty($tr['documento'])): ?>
                                    <a href="#" onclick="alert('Visualizando archivo: <?php echo htmlspecialchars($tr['documento']); ?>'); return false;">
                                        <img src="./images/icons/documentos3.png" width="14" height="14" style="vertical-align: middle;"> <?php echo htmlspecialchars($tr['documento']); ?>
                                    </a>
                                <?php else: ?>
                                    <span style="color:#888;">Sin archivo</span>
                                <?php endif; ?>
                            </td>
                            <td align='center'>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($tr['estado']); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- MODAL DE SELECCIÓN DE RAMOS POR DÍA -->
    <div id="just_modal_ramos" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
        <div style="background: white; border: 3px solid #2e6492; border-radius: 4px; width: 420px; padding: 15px; font-family: Arial, sans-serif; box-shadow: 0px 4px 15px rgba(0,0,0,0.3); text-align: left;">
            <h3 style="margin-top: 0; color: #2e6492; border-bottom: 2px solid #2e6492; padding-bottom: 5px; font-size: 16px;">Selección de Inasistencias</h3>
            <p style="font-size: 12px; color: #444; margin-bottom: 12px;">
                Seleccione las asignaturas a las que faltó el día <b id="modal_date_span" style="color: #2e6492;"></b>:
            </p>
            
            <div style="margin: 15px 0; background-color: #fafafa; border: 1px solid #ddd; padding: 10px; border-radius: 3px;">
                <label style="display: block; margin-bottom: 8px; cursor: pointer; font-weight: normal;">
                    <input type="checkbox" class="modal_curso_chk" value="INF-1101 PROGRAMACIÓN ORIENTADA A OBJETOS" style="margin-right: 8px; vertical-align: middle;">
                    <span style="vertical-align: middle; font-size: 12px;">INF-1101 PROGRAMACIÓN ORIENTADA A OBJETOS</span>
                </label>
                <label style="display: block; margin-bottom: 8px; cursor: pointer; font-weight: normal;">
                    <input type="checkbox" class="modal_curso_chk" value="MAT-1102 ÁLGEBRA LINEAL" style="margin-right: 8px; vertical-align: middle;">
                    <span style="vertical-align: middle; font-size: 12px;">MAT-1102 ÁLGEBRA LINEAL</span>
                </label>
                <label style="display: block; margin-bottom: 8px; cursor: pointer; font-weight: normal;">
                    <input type="checkbox" class="modal_curso_chk" value="INF-1103 ESTRUCTURAS DE DATOS" style="margin-right: 8px; vertical-align: middle;">
                    <span style="vertical-align: middle; font-size: 12px;">INF-1103 ESTRUCTURAS DE DATOS</span>
                </label>
                <label style="display: block; margin-bottom: 8px; cursor: pointer; font-weight: normal;">
                    <input type="checkbox" class="modal_curso_chk" value="FIS-1104 FÍSICA GENERAL II" style="margin-right: 8px; vertical-align: middle;">
                    <span style="vertical-align: middle; font-size: 12px;">FIS-1104 FÍSICA GENERAL II</span>
                </label>
                <label style="display: block; margin-bottom: 0px; cursor: pointer; font-weight: normal;">
                    <input type="checkbox" class="modal_curso_chk" value="EDU-2101 ANTROPOLOGÍA CRISTIANA" style="margin-right: 8px; vertical-align: middle;">
                    <span style="vertical-align: middle; font-size: 12px;">EDU-2101 ANTROPOLOGÍA CRISTIANA</span>
                </label>
            </div>
            
            <div style="text-align: right; border-top: 1px solid #eee; padding-top: 10px; margin-top: 15px;">
                <button type="button" onclick="closeJustModal(false)" style="background: #e0e0e0; border: 1px solid #ccc; padding: 5px 12px; cursor: pointer; font-weight: bold; font-size: 12px; border-radius: 2px;">Cancelar</button>
                <button type="button" onclick="closeJustModal(true)" style="background: #2e6492; color: white; border: 1px solid #2e6492; padding: 5px 15px; cursor: pointer; font-weight: bold; font-size: 12px; margin-left: 8px; border-radius: 2px;">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // init mapa
    window.selectedDaysMap = {};
    var today = new Date();
    window.currentYear = today.getFullYear();
    window.currentMonth = today.getMonth(); // mes actual

    // dibuja calendario
    window.renderCalendar = function(year, month) {
        var monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        var headerSpan = document.getElementById('calendar_month_year');
        if (headerSpan) {
            headerSpan.innerText = monthNames[month] + " " + year;
        }

        var totalDays = new Date(year, month + 1, 0).getDate();
        var firstDayIndex = new Date(year, month, 1).getDay();
        // semana inicia lunes
        var startDay = (firstDayIndex === 0) ? 6 : firstDayIndex - 1;

        var tbody = '';
        var day = 1;
        var row = '<tr>';

        // vacios inicio
        for (var i = 0; i < startDay; i++) {
            row += '<td class="empty"></td>';
        }

        var currentCell = startDay;
        while (day <= totalDays) {
            if (currentCell === 7) {
                row += '</tr>';
                tbody += row;
                row = '<tr>';
                currentCell = 0;
            }

            var dateStr = day + "/" + String(month + 1).padStart(2, '0') + "/" + year;
            var isSelected = window.selectedDaysMap[dateStr] ? 'selected' : '';

            row += '<td class="' + isSelected + '" onclick="toggleCalDay(this, ' + day + ', ' + month + ', ' + year + ')">' + day + '</td>';
            day++;
            currentCell++;
        }

        // vacios fin
        while (currentCell < 7) {
            row += '<td class="empty"></td>';
            currentCell++;
        }
        row += '</tr>';
        tbody += row;

        var tbodyEl = document.getElementById('calendar_tbody');
        if (tbodyEl) {
            tbodyEl.innerHTML = tbody;
        }
    };

    window.prevMonth = function() {
        window.currentMonth--;
        if (window.currentMonth < 0) {
            window.currentMonth = 11;
            window.currentYear--;
        }
        window.renderCalendar(window.currentYear, window.currentMonth);
    };

    window.nextMonth = function() {
        window.currentMonth++;
        if (window.currentMonth > 11) {
            window.currentMonth = 0;
            window.currentYear++;
        }
        window.renderCalendar(window.currentYear, window.currentMonth);
    };

    // calendar inicial
    setTimeout(function() {
        window.renderCalendar(window.currentYear, window.currentMonth);
    }, 50);

    window.switchJustTab = function(tabName) {
        document.querySelectorAll('.just-tab-btn').forEach(function(btn) {
            btn.classList.remove('active');
        });
        
        var activeBtn = document.querySelector('button[onclick="switchJustTab(\'' + tabName + '\')"]');
        if (activeBtn) activeBtn.classList.add('active');

        document.querySelectorAll('.just-section').forEach(function(sec) {
            sec.classList.remove('active');
        });
        
        var activeSec = document.getElementById('sec_' + tabName);
        if (activeSec) activeSec.classList.add('active');

        if (tabName === 'mis_tramites') {
            // recarga vista
            $('#panelDer').html("<center><img src='images/loader3.gif' style='margin-top: 250px;'/><p style='margin-top:-8px; margin-left: 10px;'> Cargando...</p></center><br><br>").show();
            setTimeout(function() {
                $('#panelDer').load('get_justificativos.php', function() {
                    // activa pestaña
                    document.querySelectorAll('.just-tab-btn').forEach(function(btn) {
                        btn.classList.remove('active');
                    });
                    var btn = document.querySelector('button[onclick="switchJustTab(\'mis_tramites\')"]');
                    if (btn) btn.classList.add('active');

                    document.querySelectorAll('.just-section').forEach(function(sec) {
                        sec.classList.remove('active');
                    });
                    var sec = document.getElementById('sec_mis_tramites');
                    if (sec) sec.classList.add('active');
                });
            }, 300);
        }
    };

    window.toggleCalDay = function(element, dayNumber, month, year) {
        var dateString = dayNumber + "/" + String(month + 1).padStart(2, '0') + "/" + year;
        window.activeModalDate = dateString;
        window.activeModalElement = element;
        
        document.getElementById('modal_date_span').innerText = dateString;
        
        var currentCursos = window.selectedDaysMap[dateString] || [];
        document.querySelectorAll('.modal_curso_chk').forEach(function(chk) {
            chk.checked = currentCursos.indexOf(chk.value) !== -1;
        });

        document.getElementById('just_modal_ramos').style.display = 'flex';
    };

    window.closeJustModal = function(isAccepted) {
        if (isAccepted) {
            var checked = [];
            document.querySelectorAll('.modal_curso_chk:checked').forEach(function(chk) {
                checked.push(chk.value);
            });

            if (checked.length === 0) {
                alert('Por favor seleccione al menos una asignatura a la que faltó para este día.');
                return;
            }

            window.selectedDaysMap[window.activeModalDate] = checked;
            window.activeModalElement.classList.add('selected');
        }
        
        document.getElementById('just_modal_ramos').style.display = 'none';
        window.updateSelectedDaysDisplay();
    };

    window.removeSelectedDay = function(date) {
        delete window.selectedDaysMap[date];
        
        var parts = date.split('/');
        var dayNum = parseInt(parts[0]);
        var monthNum = parseInt(parts[1]) - 1;
        var yearNum = parseInt(parts[2]);
        
        if (monthNum === window.currentMonth && yearNum === window.currentYear) {
            document.querySelectorAll('#calendar_tbody td').forEach(function(td) {
                if (td.innerText == dayNum && !td.classList.contains('empty')) {
                    td.classList.remove('selected');
                }
            });
        }

        window.updateSelectedDaysDisplay();
    };

    window.updateSelectedDaysDisplay = function() {
        var container = document.getElementById('selected_days_container');
        if (!container) return;

        var keys = Object.keys(window.selectedDaysMap);
        keys.sort(function(a, b) {
            return parseInt(a.split('/')[0]) - parseInt(b.split('/')[0]);
        });

        if (keys.length === 0) {
            container.innerHTML = `<span style="color: #666; font-style: italic;">Ningún día seleccionado. Haz clic en el calendario para marcar días.</span>`;
            return;
        }

        var html = '<table width="100%" border="0" cellspacing="1" cellpadding="4" style="font-size: 12px; margin-top: 5px; border: 1px dashed #2e6492; background-color: #fcfcfc;">';
        html += '<tr bgcolor="#2e6492" style="color: white; font-weight: bold;"><td width="25%">Fecha</td><td>Asignaturas Faltadas</td><td width="15%" align="center">Acción</td></tr>';
        for (var i = 0; i < keys.length; i++) {
            var date = keys[i];
            var courses = window.selectedDaysMap[date];
            var bg = (i % 2 === 0) ? '#f5f5f5' : '#ffffff';
            
            var coursesList = courses.map(function(c) {
                return `<span style="display:inline-block; background-color:#2e6492; color:white; padding: 2px 6px; border-radius:3px; margin:2px; font-size:11px;">${c}</span>`;
            }).join(' ');

            html += `
            <tr bgcolor="${bg}">
                <td><b>${date}</b></td>
                <td>${coursesList}</td>
                <td align="center">
                    <a href="#" onclick="removeSelectedDay('${date}'); return false;" style="color: red; font-weight: bold; text-decoration: none;">Eliminar</a>
                </td>
            </tr>
            `;
        }
        html += '</table>';
        container.innerHTML = html;
    };

    window.submitJustificativoLocal = function(event) {
        event.preventDefault();
        var allDays = Object.keys(window.selectedDaysMap);
        if (allDays.length === 0) {
            alert('Por favor seleccione al menos un día de inasistencia en el calendario.');
            return;
        }
        
        // envia datos
        var formData = new FormData();
        var fileInput = document.getElementById('just_file');
        if (fileInput.files[0]) {
            formData.append('documento', fileInput.files[0]);
        }
        formData.append('motivo', document.getElementById('just_motivo').value);
        formData.append('selected_days', JSON.stringify(window.selectedDaysMap));
        
        var submitBtn = document.querySelector('#form_justificativo input[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.value = "Enviando...";

        $.ajax({
            url: 'guardar_justificativo.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                submitBtn.disabled = false;
                submitBtn.value = "Enviar Trámite";
                if (response.success) {
                    document.getElementById('form_justificativo').reset();
                    window.selectedDaysMap = {};
                    window.updateSelectedDaysDisplay();
                    document.querySelectorAll('.calendar-table td').forEach(function(td) {
                        td.classList.remove('selected');
                    });
                    alert('Trámite guardado exitosamente con ID: ' + response.codigo_tramite);
                    window.switchJustTab('mis_tramites');
                } else {
                    alert('Error del servidor: ' + response.message);
                }
            },
            error: function() {
                submitBtn.disabled = false;
                submitBtn.value = "Enviar Trámite";
                alert('Ocurrió un error al enviar el trámite.');
            }
        });
    };
</script>
