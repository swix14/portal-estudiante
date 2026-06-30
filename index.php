<?php
session_start();
require_once 'conexion.php';

// redirect si logueado
if (isset($_SESSION['student_id'])) {
    header("Location: index2.php");
    exit();
}

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $pass = $_POST['pass'] ?? '';

    if (empty($correo) || empty($pass)) {
        $error_msg = "Por favor ingrese un correo y una contraseña.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM estudiantes WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $correo]);
            $student = $stmt->fetch();

            if ($student && password_verify($pass, $student['password'])) {
                // guarda sesion
                $_SESSION['student_id'] = $student['id'];
                $_SESSION['student_email'] = $student['email'];
                $_SESSION['student_name'] = $student['nombre'];
                $_SESSION['student_carrera'] = $student['carrera'];
                $_SESSION['student_rut'] = $student['rut'];
                
                header("Location: index2.php");
                exit();
            } else {
                $error_msg = "El correo o la contraseña son incorrectos.";
            }
        } catch (PDOException $e) {
            $error_msg = "Error en la base de datos: " . $e->getMessage();
        }
    }
}
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
    <script type="text/javascript" src="js/movSociales.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LfYv_4kAAAAAIyE84RsQkbGzjVnQspic9N5dhgq"></script>
    <link rel="stylesheet" href="nav-responsive.css" type="text/css" />
    <title>Universidad Católica de Temuco</title>

    <script type="text/javascript">
        function asignar() {
            var x = document.getElementById("correo");
            x.value = x.value.toUpperCase();
        }
    </script>

    <SCRIPT LANGUAGE="JavaScript">
        function popUp(URL) {
            day = new Date();
            id = day.getTime();
            eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=300,height=300,left = 533,top = 234');");
        }
    </script>

    <script type="text/javascript" src="js/validacion_login.js"></script>

    <script type="text/javascript">
        $(window).load(function() {
            $('#validar_correo').show();
            try {
                $('#slider').nivoSlider();
            } catch(e) {}
        });
    </script>

    <!-- menu movil -->
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
        $(document).ready(function() {
            try {
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LfYv_4kAAAAAIyE84RsQkbGzjVnQspic9N5dhgq', {
                        action: 'registro'
                    }).then(function(token) {
                        $('#hongkiat-form').prepend('<input type="hidden" name="token" value="' + token + '">');
                        $('#hongkiat-form').prepend('<input type="hidden" name="action" value="registro">');
                    }).catch(function(e){ console.log(e); }); 
                });
            } catch(e) {
                console.log("reCAPTCHA not loaded:", e);
            }

            document.getElementById('correo').focus();

            var move = -15;
            var zoom = 1.2;

            $('.zitem').hover(function() {
                width = $('.zitem').width() * zoom;
                height = $('.zitem').height() * zoom;
                $(this).find('img').stop(false, true).animate({
                    'width': width,
                    'height': height,
                    'top': move,
                    'left': move
                }, {
                    duration: 200
                });
                $(this).find('div.caption').stop(false, true).fadeIn(200);
            },
            function() {
                $(this).find('img').stop(false, true).animate({
                    'width': $('.zitem').width(),
                    'height': $('.zitem').height(),
                    'top': '0',
                    'left': '0'
                }, {
                    duration: 100
                });
                $(this).find('div.caption').stop(false, true).fadeOut(200);
            });
        });

        function handleLoginLocal(e) {
            var correo = document.getElementById('correo').value;
            var pass = document.getElementById('pass').value;
            if(correo == '') {
                alert('Por favor ingrese un correo ');
                document.getElementById('correo').focus();
                e.preventDefault();
                return false;
            }
            if(pass == '') {
                alert('La contraseña no puede quedar vacia');
                document.getElementById('pass').focus();
                e.preventDefault();
                return false;
            }
            return true;
        }
    </script>
    <style>
        /* estilo celular */
        @media only screen and (max-width: 767px) {
            #header {
                background: #01568e url(images/bg-header2.png) no-repeat center center !important;
                background-size: contain !important;
                height: 0 !important;
                padding-bottom: 12.745% !important;
                width: 100% !important;
            }
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
            #content {
                width: 100% !important;
                box-sizing: border-box !important;
                padding: 10px !important;
            }
            #fondo {
                background: none !important;
                height: auto !important;
            }
            #derecha {
                width: 100% !important;
                float: none !important;
                margin: 0 0 20px 0 !important;
            }
            #izquierda {
                width: 100% !important;
                float: none !important;
                margin: 0 !important;
            }
            #validar_correo {
                width: 100% !important;
                margin: 0 !important;
            }
            #containers {
                width: 100% !important;
                position: static !important;
                margin: 0 auto !important;
                box-sizing: border-box !important;
                height: auto !important;
                padding: 15px !important;
            }
            #hongkiat-form .txtinput {
                width: 100% !important;
                box-sizing: border-box !important;
                margin-bottom: 12px !important;
                font-size: 1.1em !important;
                height: auto !important;
                padding: 8px 15px 8px 45px !important;
            }
            #aligned {
                width: 100% !important;
                float: none !important;
                margin: 0 !important;
            }
            #buttons {
                width: 100% !important;
                margin: 10px 0 0 0 !important;
            }
            #submitbtn {
                width: 100% !important;
                height: 40px !important;
                font-size: 1.2em !important;
            }
            #adirectos {
                width: 100% !important;
                margin-left: 0 !important;
                box-sizing: border-box !important;
                padding: 0 10px !important;
            }
            #adirectos img {
                max-width: 22% !important;
                height: auto !important;
                margin: 5px !important;
            }
            #pensamiento {
                width: 100% !important;
                margin-left: 0 !important;
                box-sizing: border-box !important;
                padding: 10px !important;
            }
            #footer .col_one_fourth {
                width: 100% !important;
                margin-right: 0 !important;
                margin-bottom: 20px !important;
            }
        }
    </style>
</head>

<body>
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

    <div id="wrapper" class="clearfix">
        <div id="header" class="header3">
            <div class="container clearfix">
                <div id="logo"></div>
            </div>
            <div id="primary-menu">
                <div class="container clearfix">
                    <ul id="main-menu">
                        <li class="current">
                            <a href="index.php"><div>INICIO</div></a>
                        </li>
                        <li>
                            <a href="http://www.uctemuco.cl/calendario-academico/" TARGET="_blank"><div>CALENDARIO</div></a>
                        </li>
                        <li>
                            <a href="http://educa.uct.cl/" TARGET="_blank"><div>EDUCA</div></a>
                        </li>
                        <li>
                            <a href="http://dge.uct.cl/" TARGET="_blank"><div>DGE</div></a>
                        </li>
                        <li>
                            <a href="https://daas.uct.cl" TARGET="_blank"><div>ACOMPAÑAMIENTO DAAS</div> </a>
                        </li>
                        <li>
                            <a href="https://dara.uct.cl/" TARGET="_blank"><div>DARA</div></a>
                        </li>
                    </ul>
                </div>
            </div>
            <br style="clear:both;">
        </div>

        <div id="content">
            <div class="container clearfix">
                <div id="fondo">
                    <div id="derecha">
                    <!-- banners -->
                    <div id='cargaBanner'>
                        <div class="wmuSlider example1">
                            <div class="wmuSliderWrapper">
                                <article><a href="https://www.youtube.com/shorts/0WW8_aA43ds" target="_blank"><img src="images/slider/banner_2fa.jpg" alt="" /></a></article>
                                <article><a href="https://escuchaactiva.uct.cl/" target="_blank"><img src="images/slider/slider-escuchaactiva.jpg" alt="" /></a></article>
                                <article><a href="https://www.youtube.com/watch?v=yEKcUeLFcPU" target="_blank"><img src="images/slider/seguridad_informacion_1.jpg" alt="" /></a></article>
                                <article><img src="images/slider/seguridad_informacion_2.jpg" alt="" /></article>
                                <article><a href="https://dara.uct.cl/credencial/" target="_blank"><img src="images/slider/banner_credencial.jpg" alt="" /></a></article>
                                <article><a href="https://pagosweb.uct.cl" target="_blank"><img src="images/slider/BANNER_PAGOS_WEB.jpg" alt="" /></a></article>
                                <article><a href="https://dfhc.uct.cl/certificado-academico/" target="_blank"><img src="images/slider/BANNER_CERTIFICADOS_MAYO_2023.jpg" alt="" /></a></article>
                                <article><a href="https://pdi.uct.cl/" target="_blank"><img src="images/slider/banners_720x360-23.png" alt="" /></a></article> 
                                <article><a href="https://pdi.uct.cl/" target="_blank"><img src="images/slider/banners_720x360-24.png" alt="" /></a></article>
                                <article><a href="https://pdi.uct.cl/" target="_blank"><img src="images/slider/banners_720x360-25.png" alt="" /></a></article>
                                <article><a href="https://pdi.uct.cl/" target="_blank"><img src="images/slider/banners_720x360-26.png" alt="" /></a></article>
                                <article><img src="images/slider/slider-felipe.jpg" alt="" /></article>
                                <article><img src="images/slider/slider-gabriela.jpg" alt="" /></article>
                                <article><img src="images/slider/slider-mauricio.jpg" alt="" /></article>
                                <article><img src="images/slider/slider-paula.jpg" alt="" /></article>
                            </div>
                        </div>
                        <script src="js/jquery.wmuSlider.js"></script>
                        <script type="text/javascript" src="js/modernizr.custom.min.js"></script>
                        <script>
                            try {
                                $('.example1').wmuSlider();
                            } catch(e) {}
                        </script>
                        <ul id="flechas">
                            <li id="izq"></li>
                            <li id="der"></li>
                        </ul>
                    </div>
                </div> <!-- fin barra -->
            </div>

            <div id="izquierda">
                <div id='validar_correo' style="line-height: 6px;letter-spacing: 0.027em;font-size: 12px;">
                    <!-- login -->
                    <section id="containers">
                        <h2 style="color:white">Iniciar sesión</h2>
                        <form name="hongkiat" id="hongkiat-form" method="post" action="index.php" onsubmit="return handleLoginLocal(event)">
                            <div id="wrapping" class="clearfix">
                                <section id="aligned">
                                    <input type="text" onblur="asignar()" name="correo" id="correo" placeholder="correo@alu.uct.cl" autocomplete="off" tabindex="1" class="txtinput">
                                    <input type="password" name="pass" id="pass" placeholder="Contraseña" autocomplete="off" tabindex="2" class="txtinput">
                                </section>
                            </div>
                            <br style="clear:both;">
                            <br style="clear:both;">
                            <section id="buttons">
                                <center>
                                    <input type="submit" name="submit" id="submitbtn" class="submitbtn" tabindex="7" value="Entrar">
                                </center>
                                <br style="clear:both;">
                                <br style="clear:both;">
                                <center>
                                    <br style="clear:both;">
                                    <a href="https://estudiantes.uct.cl/cambio_contrasena_campusid.php" target="_blank" style="display:  inline-block; font-size:15px; color:white; " onclick="window.open(this.href,this.target,'width=1100,height=650,toolbar=no,location=no,status=no,menubar=no');return false;">Cambiar contraseña</a>
                                    <br style="clear:both;">
                                     <br style="clear:both;">
                                     <div style="line-height: 1.8em; margin-top: 15px; margin-bottom: 5px;">
                                         <a href="jefe_carrera.php" style="display: inline-block; font-size:13px; color:#e9ef18; text-decoration: underline; font-weight: bold;">Ingreso Jefe de Carrera</a>
                                         <span style="color: white; margin: 0 8px;">|</span>
                                         <a href="profesor.php" style="display: inline-block; font-size:13px; color:#e9ef18; text-decoration: underline; font-weight: bold;">Ingreso Profesores</a>
                                     </div>
                                </center>
                            </section>
                        </form>
                    </section>
                    <!-- fin login -->
                </div>
            </div>
            <!-- fin barra b -->
            <br>
            <?php if (!empty($error_msg)): ?>
                <p style="color: red; font-family: 'Open Sans', serif; font-size:17px; text-shadow: -1px -1px 1px #000, 1px 1px 1px #000, -1px 1px 1px #000, 1px -1px 1px #000; text-align: center; font-weight: bold; margin-top: 15px;">
                    <?php echo htmlspecialchars($error_msg); ?>
                </p>
            <?php endif; ?>
            </div>
        </div>    
    </div>

    <div class="content-wrap">
        <div id="pie">
            <div id="adirectos" style="margin-left: 0px !important">
                <ul style="margin-left: 0px !important; text-align: center;">
                    <li>Accesos</li>
                    <li style="color: #045FB4;">Directos</li>
                </ul>
                <center>
                    <a href="http://www.uct.cl/galeria/" TARGET="_blank"><img src="images/galeria.jpg"></a>
                    <a href="http://repositoriodigital.uct.cl/xmlui" TARGET="_blank"><img src="images/repositorio.jpg"></a>
                    <a href="http://www.dcu.uctemuco.cl/" TARGET="_blank"><img src="images/credito.jpg"></a>
                    <a href="http://biblioteca.uct.cl/" TARGET="_blank"><img src="images/bibliotecas.jpg"></a>
                </center>
                <center>
                    <a href="https://dirinf.uct.cl/" TARGET="_blank"><img src="images/direccion_informatica.jpg"></a>
                    <a href="http://uct.cl/destacados/" TARGET="_blank"><img src="images/trabaja.jpg"></a>
                    <a href="https://vicegrancancilleria.uct.cl/pastoral/" TARGET="_blank"><img src="images/pastoral.jpg"></a>
                    <a href="https://vicegrancancilleria.uct.cl/voluntariado/" TARGET="_blank"><img src="images/voluntariado.jpg"></a>
                </center>
                <hr>
            </div><br>

            <div id="adirectos">
                <ul>
                    <li>Tips de </li>
                    <li style="color: #045FB4;">Seguridad</li>
                </ul>
            </div>

            <div id="pensamiento">
                <ul>
                    <li style='font-size:13px;'>Jamás te enviaremos, ni a nombre de la Universidad Católica de Temuco ni de nuestros administrativos,
                        correos electrónicos, mensajes de texto, u otro tipo de mensajes electrónicos que soliciten información personal
                        acerca de tu cuenta.
                    </li><br>
                    <li style='font-size:13px;'>El entregar sus contraseñas a terceras personas permite el envío de correo masivo no deseado (SPAM), provocando
                        que nuestro dominio internet ingrese a los registros de listas negras nacionales e internacionales, lo que afecta la
                        imagen corporativa de la Universidad Católica de Temuco. Además, impide el flujo normal de información con entidades
                        educacionales, centros de investigación y empresas en general.
                    </li>
                </ul>
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
    <div id="copyrights" class="copyrights-dark">
        <div class="container clearfix">
            <div class="col_half">
                <center>
                    Portal del Estudiante es un proyecto realizado por la Dirección de Desarrollo de Sistemas UCTemuco.
                    <br>
                    Soporte, comentarios, errores reportarlos al correo: soportesistemas@uct.cl.
                </center>
            </div>
            <div class="col_half col_last tright"></div>
        </div>
    </div>
    <div id="gotoTop" class="icon-angle-up"></div>
    <script type="text/javascript" src="js/custom.js"></script>
</body>
</html>
