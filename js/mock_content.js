// Inicializar justificativos en localStorage si no existen (Persistencia local)
if (!localStorage.getItem('justificativos_list')) {
    var initialList = [
        {
            id: "TR-1024",
            fechaEnvio: "12/04/2026",
            dias: ["10/04/2026"],
            curso: "INF-1101 PROGRAMACIÓN ORIENTADA A OBJETOS",
            documento: "certificado_dental.pdf",
            estado: "Aprobado por Bienestar",
            comentarios: "Aprobado. Se justifica inasistencia a clases."
        },
        {
            id: "TR-1055",
            fechaEnvio: "05/05/2026",
            dias: ["02/05/2026", "03/05/2026"],
            curso: "MAT-1102 ÁLGEBRA LINEAL",
            documento: "licencia_medica_gripe.pdf",
            estado: "En revisión DARA",
            comentarios: "En proceso de validación con Jefatura de Carrera."
        }
    ];
    localStorage.setItem('justificativos_list', JSON.stringify(initialList));
}

function getMockOpc2() {
    return `<div>
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
                            <li><b>Plan de Estudios:</b> INGENIERÍA CIVIL EN INFORMÁTICA (Versión 3)</li>
                            <li><b>Promedio Ponderado Acumulado (PPA):</b> 5.6</li>
                            <li><b>Créditos Aprobados:</b> 92 / 420 SCT</li>
                            <li><b>Situación Académica:</b> Regular</li>
                        </ul>
                    </td>
                </tr>
            </table>
        </center>
    </div>`;
}

function getMockOpc9() {
    return `<div>
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
    </div>`;
}

function getMockOpc3() {
    return `<div>
        <center>
            <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                <tr>
                    <td colspan='2' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                        ESTADO DE CUENTA CORRIENTE ESTUDIANTIL
                    </td>
                </tr>
                <tr bgcolor='#f5f5f5'>
                    <td width='40%'><b>RUT Estudiante:</b></td>
                    <td>12.345.678-9</td>
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
    </div>`;
}

function getMockOpc4() {
    return `<div>
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
    </div>`;
}

function getMockOpc10() {
    return `<div>
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
                        <form onsubmit="alert('Su hora ha sido agendada con éxito. Se le enviará un correo electrónico de confirmación a su casilla institucional.'); return false;">
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
    </div>`;
}

function getMockOpc13() {
    return `<div>
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
    </div>`;
}

function getMockOpc16() {
    return `<div>
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
    </div>`;
}

function getMockOpc5() {
    return `<div>
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
    </div>`;
}

function getMockOpc6() {
    return `<div>
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
    </div>`;
}

function getMockOpc7() {
    return `<div>
        <center>
            <table width='100%' border='0' cellspacing='1' cellpadding='4' style='font-family: Arial, sans-serif; font-size: 13px;'>
                <tr>
                    <td colspan='2' align='center' bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                        INFORMACIÓN PERSONAL DEL ESTUDIANTE
                    </td>
                </tr>
                <tr bgcolor='#f5f5f5'>
                    <td width='40%'><b>Nombre Completo:</b></td>
                    <td>JUAN PABLO PÉREZ GONZÁLEZ</td>
                </tr>
                <tr bgcolor='#ffffff'>
                    <td><b>RUT:</b></td>
                    <td>12.345.678-9</td>
                </tr>
                <tr bgcolor='#f5f5f5'>
                    <td><b>Correo Institucional:</b></td>
                    <td>juan.perez@alu.uct.cl</td>
                </tr>
                <tr bgcolor='#ffffff'>
                    <td><b>Carrera:</b></td>
                    <td>INGENIERÍA CIVIL EN INFORMÁTICA</td>
                </tr>
                <tr bgcolor='#f5f5f5'>
                    <td><b>Teléfono Celular:</b></td>
                    <td>+56 9 8765 4321</td>
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
                        <form onsubmit="alert('Su contraseña ha sido modificada con éxito. Deberá iniciar sesión nuevamente en su próximo ingreso.'); return false;">
                            <table width='100%' border='0' cellpadding='4' style='font-size: 13px;'>
                                <tr>
                                    <td width='35%'><b>Contraseña Actual:</b></td>
                                    <td><input type="password" required style="padding: 2px;"></td>
                                </tr>
                                <tr>
                                    <td><b>Nueva Contraseña:</b></td>
                                    <td><input type="password" required style="padding: 2px;"></td>
                                </tr>
                                <tr>
                                    <td><b>Repetir Contraseña:</b></td>
                                    <td><input type="password" required style="padding: 2px;"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input type="submit" value="Actualizar Clave" style="background-color: #2e6492; color: white; border: none; padding: 5px 15px; font-weight: bold; cursor: pointer;">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            </table>
        </center>
    </div>`;
}

function getMockOpc20() {
    return `<div>
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
    </div>`;
}

// ==========================================
// MÓDULO DE JUSTIFICATIVOS DE INASISTENCIA (MoSCoW)
// ==========================================

window.selectedDaysMap = {};

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
        window.renderJustificativosTable();
    }
};

window.toggleCalDay = function(element, dayNumber) {
    var dateString = dayNumber + "/05/2026";
    window.activeModalDate = dateString;
    window.activeModalElement = element;
    
    // Set titles
    document.getElementById('modal_date_span').innerText = dateString;
    
    // Clear/prefill checkboxes
    var currentCursos = window.selectedDaysMap[dateString] || [];
    document.querySelectorAll('.modal_curso_chk').forEach(function(chk) {
        chk.checked = currentCursos.indexOf(chk.value) !== -1;
    });

    // Display modal
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
    } else {
        // Cancelled
    }
    
    document.getElementById('just_modal_ramos').style.display = 'none';
    window.updateSelectedDaysDisplay();
};

window.removeSelectedDay = function(date) {
    delete window.selectedDaysMap[date];
    
    // Find calendar cell with this day and remove selected class
    var dayNum = parseInt(date.split('/')[0]);
    document.querySelectorAll('.calendar-table td').forEach(function(td) {
        if (td.innerText == dayNum && !td.classList.contains('empty')) {
            td.classList.remove('selected');
        }
    });

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
    
    var allCourses = {};
    var details = [];
    
    allDays.forEach(function(d) {
        window.selectedDaysMap[d].forEach(function(c) {
            allCourses[c] = true;
        });
        details.push(d + " (" + window.selectedDaysMap[d].map(function(c) { return c.split(' ')[0]; }).join(', ') + ")");
    });

    var coursesArray = Object.keys(allCourses);
    var fileInput = document.getElementById('just_file');
    var fileName = fileInput.files[0] ? fileInput.files[0].name : 'documento.pdf';
    var motivo = document.getElementById('just_motivo').value;

    var nuevoTramite = {
        id: "TR-" + (1000 + Math.floor(Math.random() * 9000)),
        fechaEnvio: new Date().toLocaleDateString('es-ES'),
        dias: allDays,
        cursos: coursesArray,
        curso: coursesArray.join(', '),
        documento: fileName,
        estado: "En revisión DARA",
        comentarios: motivo + " | Detalle: " + details.join('; ')
    };

    var list = JSON.parse(localStorage.getItem('justificativos_list') || '[]');
    list.unshift(nuevoTramite);
    localStorage.setItem('justificativos_list', JSON.stringify(list));

    document.getElementById('form_justificativo').reset();
    window.selectedDaysMap = {};
    window.updateSelectedDaysDisplay();
    document.querySelectorAll('.calendar-table td').forEach(function(td) {
        td.classList.remove('selected');
    });

    alert('Trámite enviado exitosamente. Ha sido registrado en el listado de "Mis Trámites".');
    window.switchJustTab('mis_tramites');
};

window.renderJustificativosTable = function() {
    var list = JSON.parse(localStorage.getItem('justificativos_list') || '[]');
    var tbody = document.getElementById('just_list_body');
    if (!tbody) return;

    if (list.length === 0) {
        tbody.innerHTML = `<tr bgcolor='#ffffff'><td colspan='5' align='center'>No registra trámites de justificativos.</td></tr>`;
        return;
    }

    var html = '';
    for (var i = 0; i < list.length; i++) {
        var tr = list[i];
        var bg = (i % 2 === 0) ? '#f5f5f5' : '#ffffff';
        
        var badgeClass = 'badge-pending';
        if (tr.estado.indexOf('Aprobado') !== -1) {
            badgeClass = 'badge-approved';
        } else if (tr.estado.indexOf('Rechazado') !== -1) {
            badgeClass = 'badge-rejected';
        }

        html += `
        <tr bgcolor='${bg}' style='font-family: Arial, sans-serif;'>
            <td align='center'><b>${tr.id}</b></td>
            <td align='center'>${tr.fechaEnvio}</td>
            <td>
                <b>Asignatura(s) afectada(s):</b><br>
                <span style="font-size: 11px; line-height: 1.3em; display: block; margin: 2px 0;">
                    ${tr.cursos && tr.cursos.length > 0 ? tr.cursos.map(function(c) { return '• ' + c; }).join('<br>') : (tr.curso || 'Asignatura no especificada')}
                </span>
                <small>Días inasistencia: ${tr.dias.join(', ')}</small><br>
                <small style="color: #666; display: block; margin-top: 2px;"><b>Obs:</b> ${tr.comentarios}</small>
            </td>
            <td align='center'>
                <a href="#" onclick="alert('Visualizando archivo: ${tr.documento}'); return false;">
                    <img src="./images/icons/documentos3.png" width="14" height="14" style="vertical-align: middle;"> ${tr.documento}
                </a>
            </td>
            <td align='center'>
                <span class="badge ${badgeClass}">${tr.estado}</span>
            </td>
        </tr>
        `;
    }
    tbody.innerHTML = html;
};

function getMockJustificativos() {
    return `
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
            <button class="just-tab-btn active" onclick="switchJustTab('como_funciona')">Cómo Funciona</button>
            <button class="just-tab-btn" onclick="switchJustTab('nueva_solicitud')">Nueva Solicitud</button>
            <button class="just-tab-btn" onclick="switchJustTab('mis_tramites')">Mis Trámites</button>
        </div>

        <!-- SECCION: COMO FUNCIONA -->
        <div id="sec_como_funciona" class="just-section active">
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
        <div id="sec_nueva_solicitud" class="just-section">
            <form id="form_justificativo" onsubmit="submitJustificativoLocal(event)">
                <table width='100%' border='0' cellspacing='1' cellpadding='6' style='font-family: Arial, sans-serif; font-size: 13px; border: 1px solid #ccc;'>
                    <tr bgcolor='#2e6492' style='color: white; font-weight: bold;'>
                        <td colspan='2'>Formulario de Ingreso de Justificación</td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td valign="top" width="30%">
                            <b>Marcar Días que Faltaste:</b><br><br>
                            <small style="color: #666; display: block; line-height: 1.3em;">
                                Haz clic sobre las fechas en el calendario (Mayo 2026) para abrir el selector de asignaturas por cada día de inasistencia.
                            </small>
                        </td>
                        <td>
                            <!-- Calendario interactivo -->
                            <table class="calendar-table">
                                <thead>
                                    <tr>
                                        <th>Lu</th><th>Ma</th><th>Mi</th><th>Ju</th><th>Vi</th><th>Sá</th><th>Do</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="empty"></td><td class="empty"></td><td class="empty"></td><td class="empty"></td>
                                        <td onclick="toggleCalDay(this, 1)">1</td>
                                        <td onclick="toggleCalDay(this, 2)">2</td>
                                        <td onclick="toggleCalDay(this, 3)">3</td>
                                    </tr>
                                    <tr>
                                        <td onclick="toggleCalDay(this, 4)">4</td>
                                        <td onclick="toggleCalDay(this, 5)">5</td>
                                        <td onclick="toggleCalDay(this, 6)">6</td>
                                        <td onclick="toggleCalDay(this, 7)">7</td>
                                        <td onclick="toggleCalDay(this, 8)">8</td>
                                        <td onclick="toggleCalDay(this, 9)">9</td>
                                        <td onclick="toggleCalDay(this, 10)">10</td>
                                    </tr>
                                    <tr>
                                        <td onclick="toggleCalDay(this, 11)">11</td>
                                        <td onclick="toggleCalDay(this, 12)">12</td>
                                        <td onclick="toggleCalDay(this, 13)">13</td>
                                        <td onclick="toggleCalDay(this, 14)">14</td>
                                        <td onclick="toggleCalDay(this, 15)">15</td>
                                        <td onclick="toggleCalDay(this, 16)">16</td>
                                        <td onclick="toggleCalDay(this, 17)">17</td>
                                    </tr>
                                    <tr>
                                        <td onclick="toggleCalDay(this, 18)">18</td>
                                        <td onclick="toggleCalDay(this, 19)">19</td>
                                        <td onclick="toggleCalDay(this, 20)">20</td>
                                        <td onclick="toggleCalDay(this, 21)">21</td>
                                        <td onclick="toggleCalDay(this, 22)">22</td>
                                        <td onclick="toggleCalDay(this, 23)">23</td>
                                        <td onclick="toggleCalDay(this, 24)">24</td>
                                    </tr>
                                    <tr>
                                        <td onclick="toggleCalDay(this, 25)">25</td>
                                        <td onclick="toggleCalDay(this, 26)">26</td>
                                        <td onclick="toggleCalDay(this, 27)">27</td>
                                        <td onclick="toggleCalDay(this, 28)">28</td>
                                        <td onclick="toggleCalDay(this, 29)">29</td>
                                        <td onclick="toggleCalDay(this, 30)">30</td>
                                        <td onclick="toggleCalDay(this, 31)">31</td>
                                    </tr>
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
                            <input type="file" id="just_file" required style="padding: 4px;">
                        </td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td valign="top"><b>Motivo / Observaciones:</b></td>
                        <td>
                            <textarea id="just_motivo" required style="width: 100%; height: 60px; font-family: Arial, sans-serif; padding: 4px;" placeholder="Explique brevemente el motivo general de su inasistencia..."></textarea>
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
                    <!-- Dinámico -->
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
    `;
}
