<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    die("<div class='alert alert-danger'>Sesión no iniciada. Por favor inicie sesión nuevamente.</div>");
}

$section = $_GET['section'] ?? '';

// Datos del estudiante en sesión
$nombre = htmlspecialchars($_SESSION['student_name']);
$rut = htmlspecialchars($_SESSION['student_rut']);
$email = htmlspecialchars($_SESSION['student_email']);
$carrera = htmlspecialchars($_SESSION['student_carrera']);

switch ($section) {
    case 'opc2': // Información Académica
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td colspan='5' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            CURSOS INSCRITOS - PRIMER SEMESTRE 2026
                        </td>
                    </tr>
                    <tr bgcolor='#e9ef18' style='font-weight: bold; text-align: center; color: #2e6492;'>
                        <td>Código</td>
                        <td>Asignatura</td>
                        <td>Sección</td>
                        <td>Tipo</td>
                        <td>Estado</td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='center'><b>INF-1101</b></td>
                        <td>PROGRAMACIÓN ORIENTADA A OBJETOS</td>
                        <td align='center'>1</td>
                        <td align='center'>Obligatorio</td>
                        <td align='center' style='color: green;'><b>Inscrito</b></td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td align='center'><b>MAT-1102</b></td>
                        <td>ÁLGEBRA LINEAL</td>
                        <td align='center'>2</td>
                        <td align='center'>Obligatorio</td>
                        <td align='center' style='color: green;'><b>Inscrito</b></td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='center'><b>INF-1103</b></td>
                        <td>ESTRUCTURAS DE DATOS</td>
                        <td align='center'>1</td>
                        <td align='center'>Obligatorio</td>
                        <td align='center' style='color: green;'><b>Inscrito</b></td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td align='center'><b>FIS-1104</b></td>
                        <td>FÍSICA GENERAL II</td>
                        <td align='center'>3</td>
                        <td align='center'>Obligatorio</td>
                        <td align='center' style='color: green;'><b>Inscrito</b></td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='center'><b>EDU-2101</b></td>
                        <td>ANTROPOLOGÍA CRISTIANA</td>
                        <td align='center'>4</td>
                        <td align='center'>Teológico</td>
                        <td align='center' style='color: green;'><b>Inscrito</b></td>
                    </tr>
                </table>
                <br><br>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            RESUMEN HISTORIA ACADÉMICA
                        </td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='justify'>
                            <ul>
                                <li><b>Año de Ingreso:</b> 2024</li>
                                <li><b>Plan de Estudios:</b> <?php echo $carrera; ?></li>
                                <li><b>Promedio Ponderado Acumulado (PPA):</b> 5.6</li>
                                <li><b>Créditos Aprobados:</b> 92 / 420 SCT</li>
                                <li><b>Situación Académica:</b> Regular</li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    case 'opc9': // Notas Parciales
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td colspan='7' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            CALIFICACIONES Y ASISTENCIA - SEMESTRE ACTUAL
                        </td>
                    </tr>
                    <tr bgcolor='#e9ef18' style='font-weight: bold; text-align: center; color: #2e6492;'>
                        <td>Asignatura</td>
                        <td>Nota 1 (25%)</td>
                        <td>Nota 2 (25%)</td>
                        <td>Nota 3 (25%)</td>
                        <td>Nota 4 (25%)</td>
                        <td>Nota Final</td>
                        <td>Asistencia</td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td><b>PROGRAMACIÓN ORIENTADA A OBJETOS</b></td>
                        <td align='center'>5.5</td>
                        <td align='center'>6.2</td>
                        <td align='center'>4.8</td>
                        <td align='center'>-</td>
                        <td align='center'><b>5.5</b></td>
                        <td align='center' style='color: green;'><b>95%</b></td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>ÁLGEBRA LINEAL</b></td>
                        <td align='center'>4.0</td>
                        <td align='center'>3.8</td>
                        <td align='center'>5.2</td>
                        <td align='center'>-</td>
                        <td align='center'><b>4.3</b></td>
                        <td align='center' style='color: green;'><b>88%</b></td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td><b>ESTRUCTURAS DE DATOS</b></td>
                        <td align='center'>6.0</td>
                        <td align='center'>5.8</td>
                        <td align='center'>6.5</td>
                        <td align='center'>-</td>
                        <td align='center'><b>6.1</b></td>
                        <td align='center' style='color: green;'><b>100%</b></td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>FÍSICA GENERAL II</b></td>
                        <td align='center'>3.5</td>
                        <td align='center'>4.2</td>
                        <td align='center'>-</td>
                        <td align='center'>-</td>
                        <td align='center' style='color: red;'><b>3.9</b></td>
                        <td align='center' style='color: green;'><b>92%</b></td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td><b>ANTROPOLOGÍA CRISTIANA</b></td>
                        <td align='center'>6.8</td>
                        <td align='center'>6.5</td>
                        <td align='center'>-</td>
                        <td align='center'>-</td>
                        <td align='center'><b>6.7</b></td>
                        <td align='center' style='color: green;'><b>90%</b></td>
                    </tr>
                </table>
                <br>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 12px; border: 1px dashed #2e6492;'>
                    <tr bgcolor='#fafafa'>
                        <td>
                            <b>Nota:</b> Las calificaciones finales se calculan ponderando cada una de las evaluaciones según el programa de curso. Para aprobar cualquier asignatura se requiere promedio final mínimo de 4.0 y una asistencia mínima reglamentaria del 75%.
                        </td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    case 'opc3': // Cuenta Corriente
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td colspan='2' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            ESTADO DE CUENTA CORRIENTE ESTUDIANTIL
                        </td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td width='40%'><b>RUT Estudiante:</b></td>
                        <td><?php echo $rut; ?></td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>Concepto de Cobro:</b></td>
                        <td>Arancel de Matrícula e Incorporación Anual</td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td><b>Arancel Anual Carrera:</b></td>
                        <td>$3.850.000</td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>Becas y Beneficios Aplicados:</b></td>
                        <td style='color: blue;'><b>GRATUIDAD UNIVERSITARIA (Penta UCT)</b></td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td><b>Saldo Pendiente de Pago:</b></td>
                        <td style='color: green;'><b>$0 (Al día)</b></td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>Estado Financiero:</b></td>
                        <td style='color: green;'><b>Habilitado para matrícula y carga académica</b></td>
                    </tr>
                </table>
                <br><br>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td colspan='4' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            DETALLE DE PAGARÉS EMITIDOS
                        </td>
                    </tr>
                    <tr bgcolor='#e9ef18' style='font-weight: bold; text-align: center; color: #2e6492;'>
                        <td>Folio</td>
                        <td>Tipo de Documento</td>
                        <td>Monto</td>
                        <td>Estado</td>
                    </tr>
                    <tr bgcolor='#f5f5f5' align='center'>
                        <td>P-88421</td>
                        <td>Pagaré de Arancel Transitorio</td>
                        <td>$3.850.000</td>
                        <td style='color: green;'><b>Legalizado / Cubierto por Gratuidad</b></td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    case 'opc4': // Documentos
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td colspan='3' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            EMISIÓN DE DOCUMENTOS Y CERTIFICADOS DIGITALES
                        </td>
                    </tr>
                    <tr bgcolor='#e9ef18' style='font-weight: bold; text-align: center; color: #2e6492;'>
                        <td>Tipo de Documento</td>
                        <td>Vigencia</td>
                        <td>Descarga</td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td><b>Certificado de Alumno Regular (Fines Académicos)</b></td>
                        <td align='center'>1er Semestre 2026</td>
                        <td align='center'>
                            <a href="#" onclick="alert('Descargando Certificado_Alumno_Regular.pdf...'); return false;">
                                <img src="./images/icons/documentos3.png" width="18" height="18" style="vertical-align: middle;"> Descargar PDF
                            </a>
                        </td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>Certificado de Alumno Regular (Asignación Familiar)</b></td>
                        <td align='center'>1er Semestre 2026</td>
                        <td align='center'>
                            <a href="#" onclick="alert('Descargando Certificado_Asignacion_Familiar.pdf...'); return false;">
                                <img src="./images/icons/documentos3.png" width="18" height="18" style="vertical-align: middle;"> Descargar PDF
                            </a>
                        </td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td><b>Ficha de Concentración de Notas Parciales</b></td>
                        <td align='center'>Histórico</td>
                        <td align='center'>
                            <a href="#" onclick="alert('Descargando Concentracion_Notas.pdf...'); return false;">
                                <img src="./images/icons/documentos3.png" width="18" height="18" style="vertical-align: middle;"> Descargar PDF
                            </a>
                        </td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>Formulario de Mandato de Pago PAT</b></td>
                        <td align='center'>Anual 2026</td>
                        <td align='center'>
                            <a href="#" onclick="alert('Descargando Mandato_PAT.pdf...'); return false;">
                                <img src="./images/icons/documentos3.png" width="18" height="18" style="vertical-align: middle;"> Descargar PDF
                            </a>
                        </td>
                    </tr>
                </table>
                <br>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 11px; color: red;'>
                    <tr>
                        <td align='justify'>
                            * Los certificados emitidos a través de este portal cuentan con firma electrónica avanzada y código de verificación institucional válido ante entidades públicas y privadas.
                        </td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    case 'opc10': // Horas Asistente Social
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            AGENDAMIENTO DE HORAS - ATENCIÓN SOCIAL
                        </td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='justify'>
                            <p>Estimado/a estudiante, a través de este módulo podrá agendar su hora de atención con la Asistente Social asignada a su carrera para postulación de becas, créditos o consultas de apoyo bienestar estudiantil.</p>
                            <hr size="1" color="#ccc">
                            <form onsubmit="alert('Su hora ha sido agendada con éxito en la base de datos (simulado). Se le enviará un correo electrónico de confirmación a su casilla institucional.'); return false;">
                                <table width='100%' border='0' cellpadding='4' style='font-size: 13px;'>
                                    <tr>
                                        <td width='35%'><b>Asistente Social asignada:</b></td>
                                        <td><b>María José González S.</b> (Carreras Área Ingeniería)</td>
                                    </tr>
                                    <tr>
                                        <td><b>Campus de Atención:</b></td>
                                        <td>Campus San Francisco (Manuel Montt 56), Edificio A, Oficina 203</td>
                                    </tr>
                                    <tr>
                                        <td><b>Seleccione Fecha:</b></td>
                                        <td><input type="date" required style="padding: 2px;"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Seleccione Horario:</b></td>
                                        <td>
                                            <select required style="padding: 2px;">
                                                <option value="">-- Seleccione Bloque --</option>
                                                <option value="1">09:00 - 09:30 hrs</option>
                                                <option value="2">10:00 - 10:30 hrs</option>
                                                <option value="3">11:30 - 12:00 hrs</option>
                                                <option value="4">15:00 - 15:30 hrs</option>
                                                <option value="5">16:00 - 16:30 hrs</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Motivo de la Cita:</b></td>
                                        <td>
                                            <textarea required rows="2" style="width: 90%; font-family: sans-serif;" placeholder="Escriba brevemente el motivo..."></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <input type="submit" value="Confirmar Cita" style="background-color: #2e6492; color: white; border: none; padding: 5px 15px; font-weight: bold; cursor: pointer;">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    case 'opc13': // Préstamos Biblioteca
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td colspan='5' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            ESTADO DE PRÉSTAMOS - BIBLIOTECA UCT
                        </td>
                    </tr>
                    <tr bgcolor='#e9ef18' style='font-weight: bold; text-align: center; color: #2e6492;'>
                        <td>Código Libro</td>
                        <td>Título del Libro</td>
                        <td>Fecha de Préstamo</td>
                        <td>Fecha de Devolución</td>
                        <td>Estado</td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='center'><b>518.1 C81i</b></td>
                        <td>Introducción a los Algoritmos (Thomas Cormen)</td>
                        <td align='center'>18/05/2026</td>
                        <td align='center'>28/05/2026</td>
                        <td align='center' style='color: green;'><b>Vigente</b></td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td align='center'><b>515 S84c</b></td>
                        <td>Cálculo de una Variable, Trascendentes Tempranas (James Stewart)</td>
                        <td align='center'>20/05/2026</td>
                        <td align='center'>30/05/2026</td>
                        <td align='center' style='color: green;'><b>Vigente</b></td>
                    </tr>
                </table>
                <br><br>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td colspan='2' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            RESUMEN DE MORAS Y DEUDAS DE BIBLIOTECA
                        </td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td width='50%'><b>Libros con Retraso:</b></td>
                        <td style='color: green;'><b>0</b></td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>Multa Pendiente de Pago:</b></td>
                        <td style='color: green;'><b>$0</b></td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td><b>Bloqueo por Deuda Biblioteca:</b></td>
                        <td style='color: green;'><b>No (Habilitado para préstamos)</b></td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    case 'opc16': // Solicitud Nota P
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            SOLICITUD DE NOTA PENDIENTE (NOTA P)
                        </td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='justify'>
                            <p>La Nota Pendiente (Nota P) permite aplazar el registro de la calificación final de una asignatura cuando existan razones de fuerza mayor debidamente justificadas ante la Dirección de Carrera.</p>
                            <hr size="1" color="#ccc">
                            <form onsubmit="alert('Su solicitud de Nota Pendiente ha sido registrada en el sistema y enviada a su Jefatura de Carrera para evaluación.'); return false;">
                                <table width='100%' border='0' cellpadding='4' style='font-size: 13px;'>
                                    <tr>
                                        <td width='30%'><b>Seleccione Asignatura:</b></td>
                                        <td>
                                            <select required style="width: 90%; padding: 2px;">
                                                <option value="">-- Seleccionar ramo --</option>
                                                <option value="1">INF-1101 PROGRAMACIÓN ORIENTADA A OBJETOS</option>
                                                <option value="2">MAT-1102 ÁLGEBRA LINEAL</option>
                                                <option value="3">INF-1103 ESTRUCTURAS DE DATOS</option>
                                                <option value="4">FIS-1104 FÍSICA GENERAL II</option>
                                                <option value="5">EDU-2101 ANTROPOLOGÍA CRISTIANA</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Motivo de Solicitud:</b></td>
                                        <td>
                                            <select required style="padding: 2px;">
                                                <option value="">-- Seleccione causa --</option>
                                                <option value="1">Médico (Licencia médica adjunta)</option>
                                                <option value="2">Familiar grave</option>
                                                <option value="3">Representación Institucional UCT</option>
                                                <option value="4">Otro motivo de fuerza mayor</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Comentarios / Justificación:</b></td>
                                        <td>
                                            <textarea required rows="4" style="width: 90%; font-family: sans-serif;" placeholder="Escriba en detalle los argumentos de su solicitud..."></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Adjuntar Documento (.pdf / .jpg):</b></td>
                                        <td>
                                            <input type="file" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <input type="submit" value="Enviar Solicitud" style="background-color: #2e6492; color: white; border: none; padding: 5px 15px; font-weight: bold; cursor: pointer;">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    case 'opc5': // Solicitudes Estudiantes
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            SOLICITUDES ACADÉMICAS GENERALES
                        </td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='justify'>
                            <p>Seleccione el tipo de trámite académico que desea realizar. Toda solicitud será remitida a la Dirección de Registro Académico (DARA) y Jefatura de Carrera:</p>
                            <ul>
                                <li><b>Suspensión de Semestre:</b> Interrupción temporal de estudios por razones personales, de salud o financieras.</li>
                                <li><b>Renuncia de Carrera:</b> Término voluntario del vínculo estudiantil con la Universidad Católica de Temuco.</li>
                                <li><b>Reincorporación:</b> Retorno regular de estudios tras un periodo de suspensión autorizada.</li>
                            </ul>
                            <hr size="1" color="#ccc">
                            <form onsubmit="alert('Solicitud enviada con éxito. Podrá hacer seguimiento de este trámite a través de este mismo módulo o en su correo institucional.'); return false;">
                                <table width='100%' border='0' cellpadding='4' style='font-size: 13px;'>
                                    <tr>
                                        <td width='30%'><b>Tipo de Trámite:</b></td>
                                        <td>
                                            <select required style="padding: 2px;">
                                                <option value="">-- Seleccionar trámite --</option>
                                                <option value="1">Suspensión Temporal de Estudios (1er Semestre 2026)</option>
                                                <option value="2">Renuncia Definitiva a la Carrera</option>
                                                <option value="3">Reincorporación Académica (2do Semestre 2026)</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Justificación:</b></td>
                                        <td>
                                            <textarea required rows="4" style="width: 90%; font-family: sans-serif;" placeholder="Exponga los motivos de su solicitud..."></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <input type="submit" value="Enviar Solicitud" style="background-color: #2e6492; color: white; border: none; padding: 5px 15px; font-weight: bold; cursor: pointer;">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    case 'opc6': // Obs. Ficha Académica
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td colspan='4' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            OBSERVACIONES Y ALERTAS DE FICHA ACADÉMICA
                        </td>
                    </tr>
                    <tr bgcolor='#e9ef18' style='font-weight: bold; text-align: center; color: #2e6492;'>
                        <td>Fecha</td>
                        <td>Tipo de Observación</td>
                        <td>Descripción / Detalle</td>
                        <td>Emisor</td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='center'>10/03/2026</td>
                        <td align='center' style='color: green;'><b>Inscripción Regular</b></td>
                        <td>Carga académica autorizada sin observaciones en bloque DARA.</td>
                        <td align='center'>DARA - Registro</td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td align='center'>15/12/2025</td>
                        <td align='center' style='color: blue;'><b>Felicitación Académica</b></td>
                        <td>Alumno destaca en rendimiento con promedio superior a 5.5 en el periodo.</td>
                        <td align='center'>Decanato Ingeniería</td>
                    </tr>
                </table>
                <br>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 12px; border: 1px dashed green;'>
                    <tr bgcolor='#f0fff0'>
                        <td align='justify' style='color: green;'>
                            <b>Estado de la Ficha:</b> Sin bloqueos académicos activos. Cumple con los requisitos del Reglamento de Estudiantes para la permanencia en el plan de estudios.
                        </td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    case 'opc20': // Certificado Académico
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            INFORMACIÓN SOBRE CERTIFICADOS ACADÉMICOS
                        </td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='justify'>
                            <p><b>Dirección de Admisión y Registro Académico (DARA)</b></p>
                            <p>La emisión de certificados oficiales legalizados por la Universidad Católica de Temuco se gestiona directamente a través del menú <b>"Documentos"</b> en este portal o presencialmente en las oficinas de DARA.</p>
                            <p>Los certificados disponibles son:</p>
                            <ol>
                                <li>Certificado de Alumno Regular.</li>
                                <li>Certificado de Concentración de Notas Histórica.</li>
                                <li>Certificado de Egreso o Titulación (para alumnos egresados).</li>
                                <li>Certificado de Ranking de Egreso.</li>
                            </ol>
                            <p>En caso de requerir un certificado con formato especial no disponible en el portal web, por favor envíe su solicitud al correo oficial: <font color="blue"><b>dara@uct.cl</b></font> o acérquese a la oficina de atención en el <b>Campus San Juan Pablo II</b>, edificio Biblioteca.</p>
                        </td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    case 'opc7': // Información Personal & Cambio de Clave
        // Procesar cambio de clave vía AJAX
        ?>
        <div>
            <center>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td colspan='2' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            INFORMACIÓN PERSONAL DEL ESTUDIANTE
                        </td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td width='40%'><b>Nombre Completo:</b></td>
                        <td><?php echo $nombre; ?></td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>RUT:</b></td>
                        <td><?php echo $rut; ?></td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td><b>Correo Institucional:</b></td>
                        <td><?php echo $email; ?></td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>Carrera:</b></td>
                        <td><?php echo $carrera; ?></td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td><b>Teléfono Celular:</b></td>
                        <td>+56 9 1234 5678</td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td><b>Dirección Registrada:</b></td>
                        <td>Avenida Alemania 0122, Temuco</td>
                    </tr>
                </table>
                <br><br>
                <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                    <tr>
                        <td align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                            CAMBIO DE CONTRASEÑA PORTAL
                        </td>
                    </tr>
                    <tr bgcolor='#f5f5f5'>
                        <td align='justify'>
                            <div id="pwd_status_msg" style="margin-bottom: 10px; font-weight: bold; text-align: center;"></div>
                            <form id="form_cambio_clave" onsubmit="cambiarClaveLocal(event)">
                                <table width='100%' border='0' cellpadding='4' style='font-size: 13px;'>
                                    <tr>
                                        <td width='35%'><b>Contraseña Actual:</b></td>
                                        <td><input type="password" id="pass_actual" required style="padding: 2px;"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Nueva Contraseña:</b></td>
                                        <td><input type="password" id="pass_nueva" required style="padding: 2px;"></td>
                                    </tr>
                                    <tr>
                                        <td><b>Repetir Contraseña:</b></td>
                                        <td><input type="password" id="pass_repetir" required style="padding: 2px;"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <input type="submit" value="Actualizar Clave" style="background-color: #2e6492; color: white; border: none; padding: 5px 15px; font-weight: bold; cursor: pointer;">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <script>
                                function cambiarClaveLocal(e) {
                                    e.preventDefault();
                                    var current = document.getElementById('pass_actual').value;
                                    var nueva = document.getElementById('pass_nueva').value;
                                    var repetir = document.getElementById('pass_repetir').value;
                                    var msgDiv = document.getElementById('pwd_status_msg');

                                    if (nueva !== repetir) {
                                        msgDiv.style.color = 'red';
                                        msgDiv.innerText = 'Las nuevas contraseñas no coinciden.';
                                        return false;
                                    }

                                    $.post('cambiar_contrasena.php', {
                                        pass_actual: current,
                                        pass_nueva: nueva
                                    }, function(response) {
                                        if (response.success) {
                                            msgDiv.style.color = 'green';
                                            msgDiv.innerText = response.message;
                                            document.getElementById('form_cambio_clave').reset();
                                            setTimeout(function() {
                                                window.location.href = 'logout.php';
                                            }, 2000);
                                        } else {
                                            msgDiv.style.color = 'red';
                                            msgDiv.innerText = response.message;
                                        }
                                    }, 'json').fail(function() {
                                        msgDiv.style.color = 'red';
                                        msgDiv.innerText = 'Error de comunicación con el servidor.';
                                    });
                                }
                            </script>
                        </td>
                    </tr>
                </table>
            </center>
        </div>
        <?php
        break;

    default:
        echo "<div class='alert alert-warning'>Sección no encontrada.</div>";
        break;
}
?>
