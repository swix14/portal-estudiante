<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

$email = htmlspecialchars($_SESSION['student_email']);
$nombre = htmlspecialchars($_SESSION['student_name']);
$username = strtoupper(explode('@', $email)[0]);
$carrera = htmlspecialchars($_SESSION['student_carrera']);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="Dircom" />

    <!-- Stylesheets -->
    <link href="css/google_fonts.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" media="only screen and (-webkit-min-device-pixel-ratio: 2)" type="text/css" href="css/retina.css" />
    <link rel="stylesheet" href="css/colors.css" type="text/css" />
    <link rel="stylesheet" href="css/tipsy.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
    <link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" />
    <link rel="stylesheet" href="css/responsive.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- External JavaScripts -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/plugins.js"></script>
    <link rel="stylesheet" href="nav-responsive.css" type="text/css" />
    <script type="text/javascript" src="js/bootbox.min.js"></script>

    <title>Universidad Católica de Temuco</title>

    <link rel="stylesheet" type="text/css" href="css/nav_vertical.css" /> <!-- menu vertical css -->
    <script type="text/javascript" src="js/movSociales.js"></script> <!-- mueve iconos -->

    <!-- menu celular -->
    <script>
        $(function() {
            var enlace_movil = $('#nav-responsive'),
                menu = $('#responsive-menu').find('ul');
            enlace_movil.on('click', function(e) {
                e.preventDefault();
                var esto = $(this);
                esto.toggleClass('nav-active');
                menu.toggleClass('open-responsive-menu');
            })
        });
    </script>

    <script>
        // carga ajax
        function loadDynamicContent(url) {
            // sync menu movil
            if (url) {
                if (url.indexOf('get_justificativos.php') !== -1) {
                    $('#mobile-nav-select').val('opc_justificativos');
                } else {
                    var match = url.match(/section=(opc\d+)/);
                    if (match && match[1]) {
                        $('#mobile-nav-select').val(match[1]);
                    }
                }
            } else {
                $('#mobile-nav-select').val('inicio');
            }

            $('#panelDer').html("<center><img src='images/loader3.gif' style='margin-top: 250px;'/><p style='margin-top:-8px; margin-left: 10px;'> Cargando...</p></center><br><br>").show();
            setTimeout(function() {
                $('#panelDer').load(url);
            }, 450);
        }

        $(document).ready(function() {
            // guarda noticias
            var noticiasOriginales = $('#panelDer').html();

            // select movil
            $("#mobile-nav-select").change(function() {
                var val = $(this).val();
                if (!val) return;
                
                if (val === 'inicio') {
                    $("#inicio-btn").click();
                } else if (val === 'logout') {
                    window.location.href = 'logout.php';
                } else if (val === 'opc21') {
                    $("#opc21").click();
                } else if (val === 'opc_justificativos') {
                    $("#opc_justificativos").click();
                } else {
                    $("#" + val).click();
                }
            });

            // menu inicio
            $("#inicio-btn").click(function(e) {
                e.preventDefault();
                loadDynamicContent(null);
                // resetea vista
                $('#panelDer').html("<center><img src='images/loader3.gif' style='margin-top: 250px;'/><p style='margin-top:-8px; margin-left: 10px;'> Cargando...</p></center><br><br>").show();
                setTimeout(function() {
                    $('#panelDer').html(noticiasOriginales);
                }, 450);
                $("#main-menu li").removeClass("current");
                $(this).parent().addClass("current");
            });

            // clicks menu
            $("#opc2").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc2'); });
            $("#opc3").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc3'); });
            $("#opc4").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc4'); });
            $("#opc5").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc5'); });
            $("#opc6").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc6'); });
            $("#opc7").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc7'); });
            $("#opc9").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc9'); });
            $("#opc10").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc10'); });
            $("#opc13").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc13'); });
            $("#opc16").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc16'); });
            $("#opc20").click(function(e) { e.preventDefault(); loadDynamicContent('get_mock_section.php?section=opc20'); });
            
            // encuesta eodd
            $("#opc21").click(function(e) {
                alert("Redireccionando a Encuesta de Opinión al Desempeño Docente...");
            });

            // justificativos
            $("#opc_justificativos").click(function(e) { 
                e.preventDefault(); 
                loadDynamicContent('get_justificativos.php'); 
            });
        });
    </script>
    <style>
        /* estilo celular */
        @media only screen and (max-width: 767px) {
            #wrapper {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                border: none !important;
                box-sizing: border-box !important;
            }
            .container {
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
            #panelDer {
                float: none !important;
                width: 100% !important;
                margin-top: 10px !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                box-sizing: border-box !important;
                padding: 10px !important;
            }
            #footer .col_one_fourth {
                width: 100% !important;
                margin-right: 0 !important;
                margin-bottom: 20px !important;
            }
        }
        
        /* override bootstrap */
        #panelDer {
            float: none !important;
            width: 100% !important;
            margin-top: 0 !important;
        }
        .content {
            width: 100% !important;
        }
        .ca-menu {
            width: 100% !important;
            margin: 0 !important;
        }
        .ca-menu li {
            width: 100% !important;
        }
    </style>
</head>

<body>
    <!-- menu celular -->
    <nav id="responsive-menu">
        <a class="nav-responsive" id="nav-responsive" href="#"></a>
        <ul>
            <li><a href="http://www.uct.cl/i.php" TARGET="_blank">Ir a UCTEMUCO.CL</a></li>
            <li><a href="http://webmail.uct.cl/" TARGET="_blank">WEBMAIL</a></li>
            <li><a href="http://directorio.uctemuco.cl/" TARGET="_blank">DIRECTORIO</a></li>
            <li><a href="http://intranet.uctemuco.cl/" TARGET="_blank">INTRANET</a></li>
            <li><a href="http://www.uct.cl/contacto/" TARGET="_blank">CONTACTO</a></li>
            <li><a href="http://admision.uct.cl/" TARGET="_blank">ADMISION</a></li>
            <li><a href="http://acreditacion.uct.cl/" TARGET="_blank">ACREDITACION</a></li>
        </ul>
    </nav>
    <!-- fin menu -->

    <div id="wrapper" class="clearfix">
        <div id="header" class="header3">
            <div class="container clearfix">
                <div id="logo"></div>
            </div>
            <div id="primary-menu">
                <div class="container clearfix">
                    <ul id="main-menu">
                        <li class="current">
                            <a href="#" id="inicio-btn">
                                <div>INICIO</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.uctemuco.cl/calendario-academico/" TARGET="_blank">
                                <div>CALENDARIO</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://educa.uct.cl/" TARGET="_blank">
                                <div>EDUCA</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://tuct.uctemuco.cl/" TARGET="_blank">
                                <div>CREDENCIAL UNIVERSITARIA</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://dge.uct.cl/" TARGET="_blank">
                                <div>DGE</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://daas.uct.cl" TARGET="_blank">
                                <div>ACOMPAÑAMIENTO DAAS</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://dara.uct.cl/" TARGET="_blank">
                                <div>DARA</div>
                            </a>
                        </li>
                        <p id="identificacion">BUEN DIA: <?php echo $username; ?> &nbsp;&nbsp;|&nbsp;&nbsp; Carrera: <?php echo $carrera; ?></p>
                    </ul>
                </div>
            </div>
        </div>

        <!-- grilla bootstrap -->
        <div class="container-fluid" style="padding: 0;">
            <div class="row-fluid">
                <!-- menu pc -->
                <div class="span3 hidden-phone">
                    <div class="content">
                        <ul class="ca-menu">
                            <li>
                                <a href="#" id="opc16">
                                    <span class="ca-icon"><img src="./images/icons/solicitudes-estudiantes.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Solicitud Nota P</h2>
                                        <h3 class="ca-sub">Solicitud para dejar Nota Pendiente</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="https://estudiantes.uct.cl/jwt/redireccionEncuesta.php?rut=" id="opc21" TARGET="_blank">
                                    <span class="ca-icon"><img src="./images/eodd_posgrado.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">EODD Posgrado</h2>
                                        <h3 class="ca-sub">Encuesta de Opinión al Desempeño Docente</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc13">
                                    <span class="ca-icon"><img src="./images/icons/prestamos.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Préstamos Biblioteca </h2>
                                        <h3 class="ca-sub">Consulta Deuda Biblioteca.</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc2">
                                    <span class="ca-icon"><img src="./images/icons/informacion-academica.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Información Académica</h2>
                                        <h3 class="ca-sub">Historia académica, Cursos inscritos.</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc9">
                                    <span class="prueba"><img src="./images/icons/notas.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Notas Parciales</h2>
                                        <h3 class="ca-sub">Notas parciales, Asistencia.</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc3">
                                    <span class="ca-icon"><img src="./images/icons/cuenta-corriente.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Cuenta Corriente</h2>
                                        <h3 class="ca-sub">Cta. Corriente, Beneficios, Emisión Pagaré.</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc10">
                                    <span class="ca-icon"><img src="./images/icons/reserve02_128x128.png" style="margin-right:8px;"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Horas Asistente Social</h2>
                                        <h3 class="ca-sub" style="width:180px; line-height: 1.3em; margin-top:-3px;">Reserva de horas para asistentes sociales.</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc4">
                                    <span class="ca-icon"><img src="./images/icons/documentos3.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Documentos</h2>
                                        <h3 class="ca-sub">Certificado Estudiante Regular, Formularios, PAT.</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc5">
                                    <span class="ca-icon"><img src="./images/icons/solicitudes-estudiantes.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Solicitudes Estudiantes</h2>
                                        <h3 class="ca-sub">Renuncia, Suspensión y Reincorporación.</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc6">
                                    <span class="ca-icon"><img src="./images/icons/observacion-ficha.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Obs. Ficha Académica</h2>
                                        <h3 class="ca-sub">Observación y resultados ficha académica.</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc20">
                                    <span class="ca-icon"><img src="./images/icons/certificado.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Certificado Académico</h2>
                                        <h3 class="ca-sub">Información sobre certificados académicos.</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc7">
                                    <span class="ca-icon"><img src="./images/icons/datos-personales.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Información Personal</h2>
                                        <h3 class="ca-sub">Datos personales y claves de acceso.</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="opc_justificativos">
                                    <span class="ca-icon"><img src="./images/icons/justificativo.png"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Justificativos</h2>
                                        <h3 class="ca-sub">Subir certificados y marcar inasistencias</h3>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="logout.php">
                                    <span class="ca-icon"><img src="./images/icons/cerrar-sesion.png" style="margin-right:8px;"></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Cerrar sesión</h2>
                                        <h3 class="ca-sub" style="width:180px; line-height: 1.3em; margin-top:-3px;">Cerrar sesión en el sistema.</h3>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- menu celular -->
                <div class="span12 visible-phone" style="margin-bottom: 20px; box-sizing: border-box; padding: 0 10px;">
                    <div class="mobile-nav-select-container" style="background-color: #f7f9fa; border: 1px solid #2e6492; padding: 12px; border-radius: 6px;">
                        <label for="mobile-nav-select" style="font-weight: bold; color: #2e6492; display: block; margin-bottom: 8px; font-family: Arial, sans-serif; font-size: 14px;">Menú del Portal (opciones nativas):</label>
                        <select id="mobile-nav-select" style="width: 100%; font-size: 16px; padding: 10px; height: auto; border: 2px solid #2e6492; border-radius: 4px; background-color: #fff; color: #333; font-family: Arial, sans-serif; -webkit-appearance: menulist;">
                            <option value="">-- Seleccionar sección --</option>
                            <option value="inicio">Inicio / Noticias</option>
                            <option value="opc16">Solicitud Nota P</option>
                            <option value="opc21">EODD Posgrado (Encuesta Docente)</option>
                            <option value="opc13">Préstamos Biblioteca</option>
                            <option value="opc2">Información Académica</option>
                            <option value="opc9">Notas Parciales</option>
                            <option value="opc3">Cuenta Corriente</option>
                            <option value="opc10">Horas Asistente Social</option>
                            <option value="opc4">Documentos</option>
                            <option value="opc5">Solicitudes Estudiantes</option>
                            <option value="opc6">Obs. Ficha Académica</option>
                            <option value="opc20">Certificado Académico</option>
                            <option value="opc7">Información Personal</option>
                            <option value="opc_justificativos">Justificativos</option>
                            <option value="logout">Cerrar sesión</option>
                        </select>
                    </div>
                </div>

                <!-- panel derecho -->
                <div class="span9">
                    <div id="panelDer">
                        <style>
                            #cabeceraNoticias {
                                background-color: rgba(233, 239, 24, 0.5);
                                position: relative;
                                padding: 0.3em 0 0 0;
                                border-radius: 2px 2px 2px 2px;
                                margin-top: 0px;
                            }
                            #cabeceraNoticias img {
                                margin-right: 5px;
                            }
                        </style>
                        <div>
                            <center>
                                <table>
                                    <tr>
                                        <td align='justify'>
                                            <font size='5' color='#2e6492'><strong>NOTICIAS</strong></font>
                                        </td>
                                    </tr>
                                </table>
                            </center>
                        </div>
                        
                        <br>
                        <div id='cabeceraNoticias'>
                            <table>
                                <tr>
                                    <td align='justify' style="padding: 10px;">
                                        <img src='./images/icons/stop_round.png' style="vertical-align: middle;">
                                        <strong>&nbsp; Estimados y Estimadas Estudiantes, </strong>
                                        <br><br>
                                        Debido a un inconveniente de seguridad del proveedor que nos presta el servicio de firma electrónica avanzada para nuestros certificados, es que el módulo “documentos” del Portal del Estudiante se encuentra temporalmente en mantención. Agradecemos su comprensión.
                                        <br><br>
                                        Dirección de Admisión y Registro Académico<br>
                                        Universidad Católica de Temuco
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <br>
                        <div id='cabeceraNoticias' style="background-color: rgba(121, 255, 153, 0.3);">
                            <table>
                                <tr>
                                    <td align='justify' style="padding: 10px;">
                                        <font size='3' color='#2e6492'><strong>Requisitos Matrícula y Carga Académica 2026:</strong></font>
                                        <br><br>
                                        Los requisitos para inscribir cursos son los siguientes:
                                        <ol>
                                            <li>No tener deudas de años anteriores.</li>
                                            <li>No tener deuda de matrícula 2026.</li>
                                            <li>No tener deuda de pagarés de repactación, crédito complementario u otros.</li>
                                        </ol>
                                        Cualquier consulta sobre temas financieros dirigirla a <b>cuentascorrientes@uct.cl</b>.
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div> <!--panelDer-->
                </div>
            </div>
        </div>
    </div>

    <div id="footer" class="footer-dark">
        <div class="container clearfix">
            <div class="footer-widgets-wrap clearfix">
                <div class="col_one_fourth">
                    <div class="widget clearfix">
                        <h4>DIRECCIONES<span> CAMPUS</span></h4>
                        <ul style="font-size: 12px;">
                            <li>CAMPUS SAN FRANCISCO</li>
                            <li class="icon-map-marker">Manuel Montt 56</li>
                            <li class="icon-phone">Fono: +56 45 2 205 470</li>
                        </ul>
                        <ul style="font-size: 12px;">
                            <li>CAMPUS SAN JUAN PABLO II</li>
                            <li class="icon-map-marker">Rudecindo Ortega 02950</li>
                            <li class="icon-phone">Fono: +56 45 2 553 978</li>
                        </ul>
                    </div>
                </div>
                <div class="col_one_fourth">
                    <div class="widget clearfix">
                        <h4>&nbsp;</h4>
                        <ul style="font-size: 12px;">
                            <li>CAMPUS MENCHACA LIRA</li>
                            <li class="icon-map-marker">Avenida Alemania 0422</li>
                            <li class="icon-phone">Fono: +56 45 2 203 822</li>
                        </ul>
                        <ul style="font-size: 12px;">
                            <li>CAMPUS LUIS RIVAS DEL CANTO</li>
                            <li class="icon-map-marker">Callejón Las Mariposas s/n</li>
                            <li class="icon-phone">Fono: +56 45 2 205 596</li>
                        </ul>
                    </div>
                </div>
                <div class="col_one_fourth">
                    <div class="widget clearfix">
                        <h4>TELÉFONOS DE <span>UTILIDAD</span></h4>
                        <ul style="font-size: 12px;">
                            <li>PRENSA INSTITUCIONAL </li>
                            <li class="icon-map-marker">Avenida Alemania 0211</li>
                            <li class="icon-phone">Fono: +56 45 2 205 428</li>
                        </ul>
                        <ul style="font-size: 12px;">
                            <li>BIENESTAR ESTUDIANTIL </li>
                            <li class="icon-map-marker">Manuel Montt 56</li>
                            <li class="icon-phone">Fono: +56 45 2 205 424</li>
                        </ul>
                    </div>
                </div>
                <div class="col_one_fourth">
                    <div class="widget clearfix">
                        <h4>&nbsp;</h4>
                        <ul style="font-size: 12px;">
                            <li>AULA MAGNA </li>
                            <li class="icon-map-marker">Manuel Montt 56</li>
                            <li class="icon-phone">Fono: +56 45 2 205 471</li>
                        </ul>
                        <ul style="font-size: 12px;">
                            <li>MESA CENTRAL </li>
                            <li class="icon-map-marker">Prieto Norte 371</li>
                            <li class="icon-phone">Fono: +56 45 2 205 205</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
    <div id="gotoTop" class="icon-angle-up"></div>
    <script type="text/javascript" src="js/custom.js"></script>
</body>

</html>
