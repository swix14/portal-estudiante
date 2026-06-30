<?php
session_start();
require_once 'conexion.php';

// Cerrar sesión
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['jefe_logged_in']);
    unset($_SESSION['jefe_name']);
    header("Location: jefe_carrera.php");
    exit();
}

$login_error = "";

// Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jefe_login'])) {
    $email = trim($_POST['correo'] ?? '');
    $pass = $_POST['pass'] ?? '';

    if (!empty($email) && !empty($pass)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM jefes_carrera WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $jefe = $stmt->fetch();

            if ($jefe && password_verify($pass, $jefe['password'])) {
                $_SESSION['jefe_logged_in'] = true;
                $_SESSION['jefe_name'] = $jefe['nombre'];
                $_SESSION['jefe_carrera'] = $jefe['carrera'];
                header("Location: jefe_carrera.php");
                exit();
            }
        } catch (PDOException $e) {
            $login_error = "Error de base de datos: " . $e->getMessage();
        }
    }
    if (empty($login_error)) {
        $login_error = "El correo o la contraseña son incorrectos.";
    }
}

// Obtener datos si está logueado
$justificativos = [];
$stats = [
    'total' => 0,
    'pendiente' => 0,
    'aprobado' => 0,
    'rechazado' => 0
];

if (isset($_SESSION['jefe_logged_in']) && $_SESSION['jefe_logged_in'] === true) {
    try {
        $stmt = $pdo->query("
            SELECT j.*, e.nombre as est_nombre, e.rut as est_rut, e.email as est_email, e.carrera as est_carrera,
                   GROUP_CONCAT(CONCAT(d.fecha, ' - ', d.curso) SEPARATOR '||') as detalles
            FROM justificativos j
            JOIN estudiantes e ON j.estudiante_id = e.id
            LEFT JOIN justificativo_detalles d ON j.id = d.justificativo_id
            GROUP BY j.id
            ORDER BY j.fecha_envio DESC, j.id DESC
        ");
        $justificativos = $stmt->fetchAll();

        // Calcular estadísticas
        foreach ($justificativos as $j) {
            $stats['total']++;
            $est = strtolower($j['estado']);
            if ($est === 'pendiente') $stats['pendiente']++;
            elseif ($est === 'aprobado') $stats['aprobado']++;
            elseif ($est === 'rechazado') $stats['rechazado']++;
        }
    } catch (PDOException $e) {
        die("Error al consultar la base de datos: " . $e->getMessage());
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
    <link rel="stylesheet" href="nav-responsive.css" type="text/css" />
    
    <?php if (isset($_SESSION['jefe_logged_in'])): ?>
        <link rel="stylesheet" type="text/css" href="css/nav_vertical.css" />
    <?php endif; ?>

    <title>Portal Jefe de Carrera - Universidad Católica de Temuco</title>

    <script type="text/javascript">
        function asignar() {
            var x = document.getElementById("correo");
            if (x) x.value = x.value.toUpperCase();
        }
    </script>
    
    <style>
        /* Estilos de tarjetas de estadísticas */
        .jefe-stats-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .jefe-stat-card {
            flex: 1;
            min-width: 120px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 12px;
            text-align: center;
            font-family: Arial, sans-serif;
            box-shadow: 0px 1px 3px rgba(0,0,0,0.1);
            background: white;
        }
        .jefe-stat-title {
            font-size: 11px;
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }
        .jefe-stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #2e6492;
        }
        
        /* Badges de estado */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }
        .badge-pendiente {
            background-color: #f0ad4e;
        }
        .badge-approved {
            background-color: #5cb85c;
        }
        .badge-rejected {
            background-color: #d9534f;
        }

        .filter-btn {
            background-color: #f1f1f1;
            color: #2e6492;
            border: 1px solid #ccc;
            padding: 5px 12px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 3px;
            margin-left: 5px;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .filter-btn.active {
            background-color: #2e6492;
            color: white;
            border-color: #2e6492;
        }

        /* Estilo general del panel */
        #panelDer {
            float: none !important;
            width: 100% !important;
            margin-top: 0 !important;
            margin-left: 0 !important;
            box-sizing: border-box;
            background: white;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        /* Celular */
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
        }
    </style>
    
    <script>
        $(function() {
            var enlace_movil = $('#nav-responsive'),
                menu = $('#responsive-menu').find('ul');
            enlace_movil.on('click', function(e) {
                e.preventDefault();
                var esto = $(this);
                esto.toggleClass('nav-active');
                menu.toggleClass('open-responsive-menu');
            });
        });
    </script>
</head>
<body>

    <!-- MENÚ MÓVIL SUPERIOR -->
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

    <?php if (!isset($_SESSION['jefe_logged_in']) || $_SESSION['jefe_logged_in'] !== true): ?>
        <!-- ==================== ESTADO: NO LOGUEADO (LOGIN IDÉNTICO A UCT) ==================== -->
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
                            <!-- carrusel banners -->
                            <div id='cargaBanner'>
                                <div class="wmuSlider example1">
                                    <div class="wmuSliderWrapper">
                                        <article><a href="https://www.youtube.com/shorts/0WW8_aA43ds" target="_blank"><img src="images/slider/banner_2fa.jpg" alt="" /></a></article>
                                        <article><a href="https://escuchaactiva.uct.cl/" target="_blank"><img src="images/slider/slider-escuchaactiva.jpg" alt="" /></a></article>
                                        <article><a href="https://www.youtube.com/watch?v=yEKcUeLFcPU" target="_blank"><img src="images/slider/seguridad_informacion_1.jpg" alt="" /></a></article>
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
                        </div>

                        <div id="izquierda">
                            <div id='validar_correo' style="line-height: 6px;letter-spacing: 0.027em;font-size: 12px;">
                                <section id="containers">
                                    <h2 style="color:white">Acceso Jefatura</h2>
                                    <form name="jefe_form" id="hongkiat-form" method="post" action="jefe_carrera.php">
                                        <input type="hidden" name="jefe_login" value="1">
                                        <div id="wrapping" class="clearfix">
                                            <section id="aligned">
                                                <input type="text" onblur="asignar()" name="correo" id="correo" placeholder="correo@uct.cl" autocomplete="off" tabindex="1" class="txtinput" required>
                                                <input type="password" name="pass" id="pass" placeholder="Contraseña" autocomplete="off" tabindex="2" class="txtinput" required>
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
                                                <a href="index.php" style="display: inline-block; font-size:14px; color:white; font-weight: bold; text-decoration: underline;">Volver a Portal Estudiante</a>
                                                <br style="clear:both;">
                                            </center>
                                        </section>
                                    </form>
                                </section>
                            </div>
                        </div>
                        <br>
                        <?php if (!empty($login_error)): ?>
                            <p style="color: red; font-family: 'Open Sans', serif; font-size:17px; text-shadow: -1px -1px 1px #000, 1px 1px 1px #000, -1px 1px 1px #000, 1px -1px 1px #000; text-align: center; font-weight: bold; margin-top: 15px;">
                                <?php echo htmlspecialchars($login_error); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- ==================== ESTADO: LOGUEADO (DASHBOARD IDÉNTICO A UCT) ==================== -->
        <div id="wrapper" class="clearfix">
            <div id="header" class="header3">
                <div class="container clearfix">
                    <div id="logo"></div>
                </div>
                <div id="primary-menu">
                    <div class="container clearfix">
                        <ul id="main-menu">
                            <li class="current">
                                <a href="#"><div>INICIO</div></a>
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
                            <p id="identificacion">BUEN DIA: <?php echo $_SESSION['jefe_name']; ?> &nbsp;&nbsp;|&nbsp;&nbsp; ROL: JEFE DE CARRERA</p>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Grilla Principal -->
            <div class="container" style="padding: 0;">
                <div class="row-fluid">
                    <!-- Menú Lateral PC -->
                    <div class="span3 hidden-phone">
                        <div class="content">
                            <ul class="ca-menu">
                                <li>
                                    <a href="#" onclick="window.location.reload(); return false;">
                                        <span class="ca-icon"><img src="./images/icons/justificativo.png"></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Justificativos</h2>
                                            <h3 class="ca-sub">Recibidos y Pendientes</h3>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="alert('Estadísticas: Pendientes (<?php echo $stats['pendiente']; ?>) | Aprobados (<?php echo $stats['aprobado']; ?>) | Rechazados (<?php echo $stats['rechazado']; ?>)'); return false;">
                                        <span class="ca-icon"><img src="./images/icons/informacion-academica.png"></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Estadísticas</h2>
                                            <h3 class="ca-sub">Resumen de solicitudes</h3>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php">
                                        <span class="ca-icon"><img src="./images/icons/datos-personales.png"></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Portal Alumnos</h2>
                                            <h3 class="ca-sub">Ir a la vista principal</h3>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="jefe_carrera.php?action=logout">
                                        <span class="ca-icon"><img src="./images/icons/cerrar-sesion.png" style="margin-right:8px;"></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Cerrar sesión</h2>
                                            <h3 class="ca-sub" style="width:180px; line-height: 1.3em; margin-top:-3px;">Cerrar sesión administrativa</h3>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Panel de Contenido Derecho -->
                    <div class="span9">
                        <div id="panelDer">
                            <center>
                                <table width='100%'>
                                    <tr>
                                        <td align='left'>
                                            <font size='5' color='#2e6492'><strong>JUSTIFICATIVOS DE INASISTENCIA RECIBIDOS</strong></font>
                                        </td>
                                    </tr>
                                </table>
                            </center>
                            <br>

                            <!-- Tarjetas de Estadísticas -->
                            <div class="jefe-stats-container">
                                <div class="jefe-stat-card">
                                    <span class="jefe-stat-title">Total Solicitudes</span>
                                    <span class="jefe-stat-value" id="stat_total"><?php echo $stats['total']; ?></span>
                                </div>
                                <div class="jefe-stat-card" style="border-left: 4px solid #f0ad4e;">
                                    <span class="jefe-stat-title">Pendientes</span>
                                    <span class="jefe-stat-value" id="stat_pending" style="color: #f0ad4e;"><?php echo $stats['pendiente']; ?></span>
                                </div>
                                <div class="jefe-stat-card" style="border-left: 4px solid #5cb85c;">
                                    <span class="jefe-stat-title">Aprobados</span>
                                    <span class="jefe-stat-value" id="stat_approved" style="color: #5cb85c;"><?php echo $stats['aprobado']; ?></span>
                                </div>
                                <div class="jefe-stat-card" style="border-left: 4px solid #d9534f;">
                                    <span class="jefe-stat-title">Rechazados</span>
                                    <span class="jefe-stat-value" id="stat_rejected" style="color: #d9534f;"><?php echo $stats['rechazado']; ?></span>
                                </div>
                            </div>

                            <!-- Filtros y Búsqueda -->
                            <table width='100%' border='0' cellspacing='1' cellpadding='10' style='font-family: Arial, sans-serif; font-size: 13px; border: 1px solid #ccc; background-color: #f9f9f9; margin-bottom: 15px;'>
                                <tr>
                                    <td>
                                        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 10px;">
                                            <div>
                                                <b>Buscar:</b> 
                                                <input type="text" id="search_input" placeholder="Nombre, RUT o Trámite..." style="padding: 6px; width: 220px; font-size: 13px; border: 1px solid #ccc; border-radius: 3px;">
                                            </div>
                                            <div>
                                                <b>Filtrar por Estado:</b>
                                                <button class="filter-btn active" data-filter="all">Todos</button>
                                                <button class="filter-btn" data-filter="Pendiente">Pendientes</button>
                                                <button class="filter-btn" data-filter="Aprobado">Aprobados</button>
                                                <button class="filter-btn" data-filter="Rechazado">Rechazados</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Tabla de Justificativos -->
                            <div style="width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                                <table width='100%' border='0' cellspacing='1' cellpadding='6' id="justificativos_table" style='font-family: Arial, sans-serif; font-size: 13px; border: 1px solid #ccc; min-width: 600px;'>
                                    <thead>
                                        <tr bgcolor='#2e6492' style='color: white; font-weight: bold; text-align: center;'>
                                            <td>Código</td>
                                            <td>Estudiante</td>
                                            <td>Fecha Envío</td>
                                            <td>Inasistencias Solicitadas</td>
                                            <td>Estado</td>
                                            <td>Acción</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($justificativos)): ?>
                                            <tr bgcolor='#ffffff'>
                                                <td colspan='6' align='center' style="padding:20px; font-style:italic;">No se registran solicitudes en el sistema.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php 
                                            $i = 0;
                                            foreach ($justificativos as $j): 
                                                $bg = ($i % 2 === 0) ? '#f5f5f5' : '#ffffff';
                                                
                                                // Parsear detalles de cursos
                                                $cursos_arr = [];
                                                if (!empty($j['detalles'])) {
                                                    $parts = explode('||', $j['detalles']);
                                                    foreach ($parts as $p) {
                                                        $p_parts = explode(' - ', $p, 2);
                                                        if (count($p_parts) === 2) {
                                                            $fecha_formato = date('d/m/Y', strtotime($p_parts[0]));
                                                            $cursos_arr[] = "• <b>{$fecha_formato}</b>: " . htmlspecialchars($p_parts[1]);
                                                        }
                                                    }
                                                }
                                                
                                                // Clase del badge
                                                $badge_class = 'badge-pendiente';
                                                if ($j['estado'] === 'Aprobado') $badge_class = 'badge-approved';
                                                elseif ($j['estado'] === 'Rechazado') $badge_class = 'badge-rejected';
                                                
                                                $i++;
                                            ?>
                                                <tr bgcolor='<?php echo $bg; ?>' data-status="<?php echo htmlspecialchars($j['estado']); ?>" data-search="<?php echo htmlspecialchars(strtolower($j['codigo_tramite'] . ' ' . $j['est_nombre'] . ' ' . $j['est_rut'])); ?>">
                                                    <td align='center'><b><?php echo htmlspecialchars($j['codigo_tramite']); ?></b></td>
                                                    <td>
                                                        <b><?php echo htmlspecialchars($j['est_nombre']); ?></b><br>
                                                        <small style="color: #666;"><?php echo htmlspecialchars($j['est_rut']); ?></small>
                                                    </td>
                                                    <td align='center'><?php echo date('d/m/Y', strtotime($j['fecha_envio'])); ?></td>
                                                    <td style="font-size: 11px; line-height: 1.3em;">
                                                        <?php 
                                                        if (count($cursos_arr) > 0) {
                                                            echo implode('<br>', array_slice($cursos_arr, 0, 2));
                                                            if (count($cursos_arr) > 2) {
                                                                echo "<br><span style='color:#777; font-style:italic;'>y " . (count($cursos_arr) - 2) . " más...</span>";
                                                            }
                                                        } else {
                                                            echo "No especificado";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align='center'>
                                                        <span class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($j['estado']); ?></span>
                                                    </td>
                                                    <td align='center'>
                                                        <button onclick="openDetailsModal(<?php echo htmlspecialchars(json_encode($j)); ?>)" style="background-color: #2e6492; color: white; border: none; padding: 4px 10px; font-weight: bold; cursor: pointer; border-radius: 3px; font-size: 11px;">Revisar</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== MODAL DE DETALLE / REVISIÓN (IDÉNTICO A MODAL UCT) ==================== -->
        <div id="jefe_modal_detalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center; overflow-y: auto;">
            <div style="background: white; border: 3px solid #2e6492; border-radius: 4px; width: 95%; max-width: 620px; box-sizing: border-box; padding: 20px; font-family: Arial, sans-serif; box-shadow: 0px 4px 15px rgba(0,0,0,0.3); text-align: left; position: relative;">
                <h3 style="margin-top: 0; color: #2e6492; border-bottom: 2px solid #2e6492; padding-bottom: 5px; font-size: 16px;">
                    Revisión de Justificativo: <span id="modal_codigo_titulo" style="font-weight: bold; color: #333;">TR-0000</span>
                </h3>
                
                <div style="margin-top: 15px; max-height: 480px; overflow-y: auto; padding-right: 5px;">
                    <!-- Ficha Estudiante -->
                    <table width="100%" border="0" cellspacing="1" cellpadding="5" style="font-size: 12px; border: 1px solid #ccc; background-color: #fafafa; margin-bottom: 15px;">
                        <tr bgcolor="#2e6492" style="color: white; font-weight: bold;">
                            <td colspan="2">Ficha del Estudiante</td>
                        </tr>
                        <tr>
                            <td width="30%"><b>Nombre:</b></td>
                            <td id="modal_est_nombre">-</td>
                        </tr>
                        <tr>
                            <td><b>RUT:</b></td>
                            <td id="modal_est_rut">-</td>
                        </tr>
                        <tr>
                            <td><b>Carrera:</b></td>
                            <td id="modal_est_carrera">-</td>
                        </tr>
                        <tr>
                            <td><b>Correo:</b></td>
                            <td id="modal_est_email">-</td>
                        </tr>
                    </table>

                    <!-- Ramos y Fechas Justificadas -->
                    <b style="color: #2e6492; font-size: 13px;">Inasistencias Solicitadas:</b>
                    <table width="100%" border="0" cellspacing="1" cellpadding="5" style="font-size: 12px; border: 1px solid #ccc; margin-top: 5px; margin-bottom: 15px;">
                        <thead>
                            <tr bgcolor="#f1f1f1">
                                <th width="30%" align="left">Fecha</th>
                                <th width="70%" align="left">Asignatura</th>
                            </tr>
                        </thead>
                        <tbody id="modal_detalles_tbody">
                            <!-- dinámico -->
                        </tbody>
                    </table>

                    <!-- Motivo Alumno -->
                    <b style="color: #2e6492; font-size: 13px;">Comentario / Motivo del Estudiante:</b>
                    <div id="modal_est_comentario" style="padding: 8px; border: 1px solid #ccc; border-radius: 3px; background-color: #fdfdfd; font-size: 12px; margin-top: 5px; margin-bottom: 15px; font-style: italic; color:#333;">
                        -
                    </div>

                    <!-- Documento -->
                    <b style="color: #2e6492; font-size: 13px;">Documento Adjunto:</b>
                    <div style="padding: 10px; border: 1px dashed #2e6492; border-radius: 3px; background-color: #fdfdfd; font-size: 12px; margin-top: 5px; margin-bottom: 15px; text-align: center;">
                        <span id="modal_doc_filename" style="font-weight: bold; display: block; margin-bottom: 5px;">-</span>
                        <div id="doc_preview_container" style="display:none; margin-bottom: 10px;">
                            <img id="doc_image_preview" src="" style="max-width: 100%; max-height: 180px; border: 1px solid #ccc; border-radius: 3px;">
                        </div>
                        <a id="modal_doc_link" href="#" target="_blank" style="background-color: #f1f1f1; border: 1px solid #ccc; padding: 4px 10px; text-decoration: none; color: #2e6492; font-weight: bold; border-radius: 3px; display: inline-block;">
                            <img src="./images/icons/documentos3.png" width="12" style="vertical-align: middle; margin-right: 3px;"> Abrir Documento Completo
                        </a>
                    </div>

                    <!-- Formulario de Resolución -->
                    <form id="jefe_resolution_form">
                        <input type="hidden" id="modal_justificativo_id">
                        
                        <table width="100%" border="0" cellspacing="1" cellpadding="8" style="font-size: 12px; border: 1px solid #ccc; background-color: #f5f5f5;">
                            <tr bgcolor="#2e6492" style="color: white; font-weight: bold;">
                                <td colspan="2">Resolución del Jefe de Carrera</td>
                            </tr>
                            <tr>
                                <td width="30%"><b>Estado Trámite:</b></td>
                                <td>
                                    <label style="margin-right: 15px; font-weight: normal; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="nuevo_estado" id="opt_pend" value="Pendiente" style="vertical-align: middle; margin-right: 4px;"> 
                                        <span style="vertical-align: middle; color: #f0ad4e; font-weight: bold;">Pendiente</span>
                                    </label>
                                    <label style="margin-right: 15px; font-weight: normal; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="nuevo_estado" id="opt_aprob" value="Aprobado" style="vertical-align: middle; margin-right: 4px;"> 
                                        <span style="vertical-align: middle; color: #5cb85c; font-weight: bold;">Aprobado</span>
                                    </label>
                                    <label style="font-weight: normal; cursor: pointer; display: inline-block;">
                                        <input type="radio" name="nuevo_estado" id="opt_rech" value="Rechazado" style="vertical-align: middle; margin-right: 4px;"> 
                                        <span style="vertical-align: middle; color: #d9534f; font-weight: bold;">Rechazado</span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top"><b>Comentarios de Resolución:</b><br><small style="color: #666;">(Se enviará al alumno)</small></td>
                                <td>
                                    <textarea id="modal_observaciones_jefe" style="width: 100%; height: 50px; font-family: Arial, sans-serif; padding: 4px;" placeholder="Escriba los motivos de la resolución..."></textarea>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                
                <div style="text-align: right; border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                    <button type="button" onclick="closeDetailsModal()" style="background: #e0e0e0; border: 1px solid #ccc; padding: 5px 12px; cursor: pointer; font-weight: bold; font-size: 12px; border-radius: 2px;">Cancelar</button>
                    <button type="button" onclick="saveResolution()" style="background: #2e6492; color: white; border: 1px solid #2e6492; padding: 5px 15px; cursor: pointer; font-weight: bold; font-size: 12px; margin-left: 8px; border-radius: 2px;">Guardar Resolución</button>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT DEL DASHBOARD -->
        <script>
            // Búsqueda y Filtrado
            $(document).ready(function() {
                var currentFilter = 'all';

                // Búsqueda en vivo
                $('#search_input').on('keyup', function() {
                    applyFilters();
                });

                // Botones de filtro de estado
                $('.filter-btn').click(function(e) {
                    e.preventDefault();
                    $('.filter-btn').removeClass('active');
                    $(this).addClass('active');
                    currentFilter = $(this).attr('data-filter');
                    applyFilters();
                });

                function applyFilters() {
                    var searchVal = $('#search_input').val().toLowerCase().trim();
                    
                    $('#justificativos_table tbody tr').each(function() {
                        // Omitir fila vacía
                        if ($(this).find('td').length === 1) return;
                        
                        var status = $(this).attr('data-status');
                        var searchText = $(this).attr('data-search');
                        
                        var matchesSearch = searchText.indexOf(searchVal) !== -1;
                        var matchesFilter = currentFilter === 'all' || status === currentFilter;
                        
                        if (matchesSearch && matchesFilter) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });

            // Modal funciones
            function openDetailsModal(j) {
                // Rellenar datos estudiante
                $('#modal_justificativo_id').val(j.id);
                $('#modal_codigo_titulo').text(j.codigo_tramite);
                $('#modal_est_nombre').text(j.est_nombre);
                $('#modal_est_rut').text(j.est_rut);
                $('#modal_est_carrera').text(j.est_carrera);
                $('#modal_est_email').text(j.est_email);
                
                // Comentario alumno
                var obsEst = j.comentarios || "Sin comentarios adicionales.";
                $('#modal_est_comentario').text(obsEst);
                
                // Cursos
                var tbody = '';
                if (j.detalles) {
                    var rows = j.detalles.split('||');
                    rows.forEach(function(row) {
                        var p = row.split(' - ');
                        if (p.length === 2) {
                            var rawDate = p[0];
                            var parts = rawDate.split('-');
                            var formattedDate = rawDate;
                            if (parts.length === 3) {
                                formattedDate = parts[2] + '/' + parts[1] + '/' + parts[0];
                            }
                            tbody += '<tr><td><b>' + formattedDate + '</b></td><td>' + p[1] + '</td></tr>';
                        }
                    });
                } else {
                    tbody = '<tr><td colspan="2" style="text-align:center; color:#888;">No registra asignaturas.</td></tr>';
                }
                $('#modal_detalles_tbody').html(tbody);

                // Documento
                var filename = j.documento;
                $('#modal_doc_filename').text(filename || 'Sin archivo');
                if (filename) {
                    $('#modal_doc_link').attr('href', 'uploads/' + filename).show();
                    
                    // Previsualización si es imagen
                    var ext = filename.split('.').pop().toLowerCase();
                    var imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    if (imageExtensions.indexOf(ext) !== -1) {
                        $('#doc_image_preview').attr('src', 'uploads/' + filename);
                        $('#doc_preview_container').show();
                    } else {
                        $('#doc_preview_container').hide();
                    }
                } else {
                    $('#modal_doc_link').hide();
                    $('#doc_preview_container').hide();
                }

                // Selección del estado
                $('input[name="nuevo_estado"]').prop('checked', false);
                if (j.estado === 'Pendiente') $('#opt_pend').prop('checked', true);
                else if (j.estado === 'Aprobado') $('#opt_aprob').prop('checked', true);
                else if (j.estado === 'Rechazado') $('#opt_rech').prop('checked', true);

                // Comentarios del Jefe
                $('#modal_observaciones_jefe').val(j.comentarios || '');

                // Abrir modal
                $('#jefe_modal_detalle').css('display', 'flex');
            }

            function closeDetailsModal() {
                $('#jefe_modal_detalle').css('display', 'none');
            }

            function saveResolution() {
                var justId = $('#modal_justificativo_id').val();
                var estado = $('input[name="nuevo_estado"]:checked').val();
                var comentarios = $('#modal_observaciones_jefe').val();

                $.ajax({
                    url: 'update_justificativo.php',
                    type: 'POST',
                    data: {
                        id: justId,
                        estado: estado,
                        comentarios: comentarios
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            closeDetailsModal();
                            window.location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error al comunicarse con el servidor.');
                    }
                });
            }
        </script>
    <?php endif; ?>

    <!-- PIE DE PAGINA IDENTICO A UCT -->
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
