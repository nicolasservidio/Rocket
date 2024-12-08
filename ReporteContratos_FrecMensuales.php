<?php

session_start();

require_once 'funciones/corroborar_usuario.php'; 
Corroborar_Usuario(); 

ob_start();

require_once "conn/conexion.php";
$conexion = ConexionBD();

// Generación del listado de contratos
require_once 'funciones/CRUD-Contratos.php';
$ListadoContratos = Listar_Contratos($conexion);
$CantidadContratos = count($ListadoContratos);


// PROCEDIMIENTO PARA EL CONTEO DE NÚMERO DE CONTRATOS POR MES Y AÑO
// arrays
$contratos = array();

// 2024
$acumulado2024_Total = 0; $acumulado_ENE2024_Total = 0; $acumulado_FEB2024_Total = 0; $acumulado_MAR2024_Total = 0; $acumulado_ABR2024_Total = 0; 
$acumulado_MAY2024_Total = 0; $acumulado_JUN2024_Total = 0; $acumulado_JUL2024_Total = 0; $acumulado_AGO2024_Total = 0; $acumulado_SEP2024_Total = 0; 
$acumulado_OCT2024_Total = 0; $acumulado_NOV2024_Total = 0; $acumulado_DIC2024_Total = 0;

$acumulado2024_Firmados = 0; $acumulado_ENE2024_Firmados = 0; $acumulado_FEB2024_Firmados = 0; $acumulado_MAR2024_Firmados = 0; $acumulado_ABR2024_Firmados = 0; 
$acumulado_MAY2024_Firmados = 0; $acumulado_JUN2024_Firmados = 0; $acumulado_JUL2024_Firmados = 0; $acumulado_AGO2024_Firmados = 0; $acumulado_SEP2024_Firmados = 0; 
$acumulado_OCT2024_Firmados = 0; $acumulado_NOV2024_Firmados = 0; $acumulado_DIC2024_Firmados = 0;

$acumulado2024_Cancelados = 0; $acumulado_ENE2024_Cancelados = 0; $acumulado_FEB2024_Cancelados = 0; $acumulado_MAR2024_Cancelados = 0; $acumulado_ABR2024_Cancelados = 0; 
$acumulado_MAY2024_Cancelados = 0; $acumulado_JUN2024_Cancelados = 0; $acumulado_JUL2024_Cancelados = 0; $acumulado_AGO2024_Cancelados = 0; $acumulado_SEP2024_Cancelados = 0; 
$acumulado_OCT2024_Cancelados = 0; $acumulado_NOV2024_Cancelados = 0; $acumulado_DIC2024_Cancelados = 0;

$acumulado2024_Finalizados = 0; $acumulado_ENE2024_Finalizados = 0; $acumulado_FEB2024_Finalizados = 0; $acumulado_MAR2024_Finalizados = 0; $acumulado_ABR2024_Finalizados = 0; 
$acumulado_MAY2024_Finalizados = 0; $acumulado_JUN2024_Finalizados = 0; $acumulado_JUL2024_Finalizados = 0; $acumulado_AGO2024_Finalizados = 0; $acumulado_SEP2024_Finalizados = 0; 
$acumulado_OCT2024_Finalizados = 0; $acumulado_NOV2024_Finalizados = 0; $acumulado_DIC2024_Finalizados = 0;

// 2025
$acumulado2025_Total = 0; $acumulado_ENE2025_Total = 0; $acumulado_FEB2025_Total = 0; $acumulado_MAR2025_Total = 0; $acumulado_ABR2025_Total = 0; 
$acumulado_MAY2025_Total = 0; $acumulado_JUN2025_Total = 0; $acumulado_JUL2025_Total = 0; $acumulado_AGO2025_Total = 0; $acumulado_SEP2025_Total = 0; 
$acumulado_OCT2025_Total = 0; $acumulado_NOV2025_Total = 0; $acumulado_DIC2025_Total = 0;

$acumulado2025_Firmados = 0; $acumulado_ENE2025_Firmados = 0; $acumulado_FEB2025_Firmados = 0; $acumulado_MAR2025_Firmados = 0; 
$acumulado_ABR2025_Firmados = 0; $acumulado_MAY2025_Firmados = 0; $acumulado_JUN2025_Firmados = 0; $acumulado_JUL2025_Firmados = 0; 
$acumulado_AGO2025_Firmados = 0; $acumulado_SEP2025_Firmados = 0; $acumulado_OCT2025_Firmados = 0; $acumulado_NOV2025_Firmados = 0; $acumulado_DIC2025_Firmados = 0;

$acumulado2025_Cancelados = 0; $acumulado_ENE2025_Cancelados = 0; $acumulado_FEB2025_Cancelados = 0; $acumulado_MAR2025_Cancelados = 0; 
$acumulado_ABR2025_Cancelados = 0; $acumulado_MAY2025_Cancelados = 0; $acumulado_JUN2025_Cancelados = 0; $acumulado_JUL2025_Cancelados = 0; 
$acumulado_AGO2025_Cancelados = 0; $acumulado_SEP2025_Cancelados = 0; $acumulado_OCT2025_Cancelados = 0; $acumulado_NOV2025_Cancelados = 0; $acumulado_DIC2025_Cancelados = 0;

$acumulado2025_Finalizados = 0; $acumulado_ENE2025_Finalizados = 0; $acumulado_FEB2025_Finalizados = 0; $acumulado_MAR2025_Finalizados = 0; 
$acumulado_ABR2025_Finalizados = 0; $acumulado_MAY2025_Finalizados = 0; $acumulado_JUN2025_Finalizados = 0; $acumulado_JUL2025_Finalizados = 0; 
$acumulado_AGO2025_Finalizados = 0; $acumulado_SEP2025_Finalizados = 0; $acumulado_OCT2025_Finalizados = 0; $acumulado_NOV2025_Finalizados = 0; $acumulado_DIC2025_Finalizados = 0;

for ($i = 0; $i < $CantidadContratos; $i++) {

    $fechaContrato = $ListadoContratos[$i]['FechaInicioContrato'];
    $fecha = date_parse($fechaContrato);

    $contratos[$i]['fechaContrato'] = $ListadoContratos[$i]['FechaInicioContrato'];
    $contratos[$i]['anioContrato'] = $fecha['year'];
    $contratos[$i]['mesContrato'] = $fecha['month'];
    $contratos[$i]['diaContrato'] = $fecha['day'];
    $contratos[$i]["Estado"] = $ListadoContratos[$i]['EstadoContrato'];

    // 2024

    if ($contratos[$i]['anioContrato'] == "2024") {

        $acumulado2024_Total ++;

        if ($contratos[$i]['mesContrato'] == "01") {
            
            $acumulado_ENE2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_ENE2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_ENE2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_ENE2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "02") {
            
            $acumulado_FEB2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_FEB2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_FEB2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_FEB2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "03") {
            
            $acumulado_MAR2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_MAR2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_MAR2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_MAR2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "04") {
            
            $acumulado_ABR2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_ABR2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_ABR2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_ABR2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "05") {
            
            $acumulado_MAY2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_MAY2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_MAY2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_MAY2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "06") {
            
            $acumulado_JUN2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_JUN2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_JUN2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_JUN2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "07") {
            
            $acumulado_JUL2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_JUL2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_JUL2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_JUL2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "08") {
            
            $acumulado_AGO2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_AGO2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_AGO2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_AGO2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "09") {
            
            $acumulado_SEP2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_SEP2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_SEP2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_SEP2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "10") {
            
            $acumulado_OCT2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_OCT2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_OCT2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_OCT2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "11") {
            
            $acumulado_NOV2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_NOV2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_NOV2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_NOV2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
        if ($contratos[$i]['mesContrato'] == "12") {
            
            $acumulado_DIC2024_Total ++;

            if ($contratos[$i]["Estado"] == "Firmado") {
                $acumulado_DIC2024_Firmados ++;
                $acumulado2024_Firmados ++;
            }
            if ($contratos[$i]["Estado"] == "Cancelado") {
                $acumulado_DIC2024_Cancelados ++;
                $acumulado2024_Cancelados ++;
            }
            if ($contratos[$i]["Estado"] == "Finalizado") {
                $acumulado_DIC2024_Finalizados ++;
                $acumulado2024_Finalizados ++;
            }
        }
    }

    // 2025
    
}



include('head.php');

?>

<body>

    <style type="text/css">
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 1200px;            
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

    </style>

    <!-- JS Gráfico principal -->
    <script src="administrador/highcharts/code/highcharts.js"></script>
    <script src="administrador/highcharts/code/modules/exporting.js"></script>
    <script src="administrador/highcharts/code/modules/export-data.js"></script>
    <script src="administrador/highcharts/code/modules/accessibility.js"></script>

    <!-- JS Gráfico de pastel -->
    <script src="administrador/highcharts/code/modules/variable-pie.js"></script>

    <!-- Título -->
    <div style="margin: auto; max-width: 95%; padding: 70px 0 5px 0;">
        <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
            <h3 class="mb-1 " style="padding: 0; margin: 5px 0 0 0;" >
                <strong style="color: #a80a0a;">Reporte Estadístico:</strong> Contratos por mes segmentados por estado 
            </h3>
        </div>
    </div>

    <!-- Gráfico principal -->
    <figure class="highcharts-figure">
        <div id="first" style="padding: 50px 0 0 0; min-height: 700px !important;"></div>
        <p class="highcharts-description" style="padding: 40px 20px 0 20px; text-align: justify;">
            El gráfico muestra etiquetas asociadas a una serie de tiempo en el eje de abscisas y frecuencias absolutas en el eje de ordenadas. 
            Esto incrementa notablemente la comprensión y legibilidad de los diferentes datasets incluidos en el diagrama. 
            Se incluyen cuatro (4) datasets, correspondiendo tres de ellos a datos segmentados en función del estado del contrato, y el restante al acumulado total de contratos por mes.
        </p>
    </figure>


	<script type="text/javascript">
        Highcharts.chart('first', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Cantidad de contratos mensuales'
            },
            subtitle: {
                text: 'Source: Rocket'
            },
            xAxis: {
                categories: ['Ene 2024', 'Feb ', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
            },
            yAxis: {
                title: {
                    text: 'Cantidad de contratos realizados'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'Total',
                data: [<?php echo $acumulado_ENE2024_Total; ?>, 
                       <?php echo $acumulado_FEB2024_Total; ?>, 
                       <?php echo $acumulado_MAR2024_Total;?>, 
                       <?php echo $acumulado_ABR2024_Total;?>, 
                       <?php echo $acumulado_MAY2024_Total;?>, 
                       <?php echo $acumulado_JUN2024_Total;?>, 
                       <?php echo $acumulado_JUL2024_Total;?>, 
                       <?php echo $acumulado_AGO2024_Total;?>, 
                       <?php echo $acumulado_SEP2024_Total;?>, 
                       <?php echo $acumulado_OCT2024_Total;?>, 
                       <?php echo $acumulado_NOV2024_Total;?>, 
                       <?php echo $acumulado_DIC2024_Total;?>]
            }, {
                name: 'Firmados',
                data: [<?php echo $acumulado_ENE2024_Firmados; ?>, 
                       <?php echo $acumulado_FEB2024_Firmados; ?>, 
                       <?php echo $acumulado_MAR2024_Firmados; ?>, 
                       <?php echo $acumulado_ABR2024_Firmados; ?>, 
                       <?php echo $acumulado_MAY2024_Firmados; ?>, 
                       <?php echo $acumulado_JUN2024_Firmados; ?>, 
                       <?php echo $acumulado_JUL2024_Firmados; ?>, 
                       <?php echo $acumulado_AGO2024_Firmados; ?>, 
                       <?php echo $acumulado_SEP2024_Firmados; ?>, 
                       <?php echo $acumulado_OCT2024_Firmados; ?>, 
                       <?php echo $acumulado_NOV2024_Firmados; ?>, 
                       <?php echo $acumulado_DIC2024_Firmados; ?>]
            }, {
                name: 'Cancelados',
                data: [<?php echo $acumulado_ENE2024_Cancelados; ?>, 
                       <?php echo $acumulado_FEB2024_Cancelados; ?>, 
                       <?php echo $acumulado_MAR2024_Cancelados; ?>, 
                       <?php echo $acumulado_ABR2024_Cancelados; ?>, 
                       <?php echo $acumulado_MAY2024_Cancelados; ?>, 
                       <?php echo $acumulado_JUN2024_Cancelados; ?>, 
                       <?php echo $acumulado_JUL2024_Cancelados; ?>, 
                       <?php echo $acumulado_AGO2024_Cancelados; ?>, 
                       <?php echo $acumulado_SEP2024_Cancelados; ?>, 
                       <?php echo $acumulado_OCT2024_Cancelados; ?>, 
                       <?php echo $acumulado_NOV2024_Cancelados; ?>, 
                       <?php echo $acumulado_DIC2024_Cancelados; ?>]
            }, {
                name: 'Finalizados',
                data: [<?php echo $acumulado_ENE2024_Finalizados; ?>, 
                       <?php echo $acumulado_FEB2024_Finalizados; ?>, 
                       <?php echo $acumulado_MAR2024_Finalizados; ?>, 
                       <?php echo $acumulado_ABR2024_Finalizados; ?>, 
                       <?php echo $acumulado_MAY2024_Finalizados; ?>, 
                       <?php echo $acumulado_JUN2024_Finalizados; ?>, 
                       <?php echo $acumulado_JUL2024_Finalizados; ?>, 
                       <?php echo $acumulado_AGO2024_Finalizados; ?>, 
                       <?php echo $acumulado_SEP2024_Finalizados; ?>, 
                       <?php echo $acumulado_OCT2024_Finalizados; ?>, 
                       <?php echo $acumulado_NOV2024_Finalizados; ?>, 
                       <?php echo $acumulado_DIC2024_Finalizados; ?>]
            } 
            ]
        });
	</script>

    <div style="margin: 0 auto; padding: 50px;"> </div>

    <!-- Gráfico de pastel -->
    <figure class="highcharts-figure">
        <div id="second"></div>
        <p class="highcharts-description" style="padding: 40px 20px 0 20px; text-align: justify;">
            Los <b>gráficos circulares de radio variable</b> son utilizados para visualizar una segunda dimensión en un gráfico de pastel. 
            En este gráfico, los meses con mayor cantidad de contratos en estado «Finalizado» sobresalen hacia el observador, 
            mientras que el ancho de cada porción corresponde a la cantidad total de contratos en el mes.
        </p>
    </figure>

    <script type="text/javascript">
        
        Highcharts.chart('second', {
            chart: {
                type: 'variablepie'
            },
            title: {
                text: 'Meses comparados por cantidad total de contratos y contratos finalizados.'
            },
            subtitle: {
                text: 'Source: Rocket'
            },
            tooltip: {
                headerFormat: '',
                pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                    'Total de contratos: <b>{point.y}</b><br/>' +
                    'Contratos finalizados: <b>{point.z}</b><br/>'
            },
            series: [{
                minPointSize: 10,
                innerSize: '20%',
                zMin: 0,
                name: 'countries',
                data: [{
                    name: 'Ene',
                    y: <?php echo $acumulado_ENE2024_Total;?>,
                    z: <?php echo $acumulado_ENE2024_Finalizados;?>
                }, {
                    name: 'Feb',
                    y: <?php echo $acumulado_FEB2024_Total;?>,
                    z: <?php echo $acumulado_FEB2024_Finalizados;?>
                }, {
                    name: 'Mar',
                    y: <?php echo $acumulado_MAR2024_Total;?>,
                    z: <?php echo $acumulado_MAR2024_Finalizados;?>
                }, {
                    name: 'Abr',
                    y: <?php echo $acumulado_ABR2024_Total;?>,
                    z: <?php echo $acumulado_ABR2024_Finalizados;?>
                }, {
                    name: 'May',
                    y: <?php echo $acumulado_MAY2024_Total;?>,
                    z: <?php echo $acumulado_MAY2024_Finalizados;?>
                }, {
                    name: 'Jun',
                    y: <?php echo $acumulado_JUN2024_Total;?>,
                    z: <?php echo $acumulado_JUN2024_Finalizados;?>
                }, {
                    name: 'Jul',
                    y: <?php echo $acumulado_JUL2024_Total;?>,
                    z: <?php echo $acumulado_JUL2024_Finalizados;?>
                }, {
                    name: 'Ago',
                    y: <?php echo $acumulado_AGO2024_Total;?>,
                    z: <?php echo $acumulado_AGO2024_Finalizados;?>
                }, {
                    name: 'Sep',
                    y: <?php echo $acumulado_SEP2024_Total;?>,
                    z: <?php echo $acumulado_SEP2024_Finalizados;?>
                }, {
                    name: 'Oct',
                    y: <?php echo $acumulado_OCT2024_Total;?>,
                    z: <?php echo $acumulado_OCT2024_Finalizados;?>
                }, {
                    name: 'Nov',
                    y: <?php echo $acumulado_NOV2024_Total;?>,
                    z: <?php echo $acumulado_NOV2024_Finalizados;?>
                }, {
                    name: 'Dic',
                    y: <?php echo $acumulado_DIC2024_Total;?>,
                    z: <?php echo $acumulado_DIC2024_Finalizados;?>
                }
                ]
            }]
        });

	</script>



    <!-- MEDIDAS ESTADÍSTICAS DESCRIPTIVAS -->
    <?php 

    require_once "administrador/statistics-main/src/Stat.php";
    use HiFolks\Statistics\Stat;

    require_once "administrador/statistics-main/src/Freq.php";
    use HiFolks\Statistics\Freq;

    require_once "administrador/statistics-main/src/Math.php";
    use HiFolks\Statistics\Math;

    // Array para medidas de posición
    $stat_contratosTotales = array();
    $stat_contratosTotales[] = $acumulado_ENE2024_Total;
    $stat_contratosTotales[] = $acumulado_FEB2024_Total;
    $stat_contratosTotales[] = $acumulado_MAR2024_Total;
    $stat_contratosTotales[] = $acumulado_ABR2024_Total;
    $stat_contratosTotales[] = $acumulado_MAY2024_Total;
    $stat_contratosTotales[] = $acumulado_JUN2024_Total;
    $stat_contratosTotales[] = $acumulado_JUL2024_Total;
    $stat_contratosTotales[] = $acumulado_AGO2024_Total;
    $stat_contratosTotales[] = $acumulado_SEP2024_Total;
    $stat_contratosTotales[] = $acumulado_OCT2024_Total;
    $stat_contratosTotales[] = $acumulado_NOV2024_Total;
    $stat_contratosTotales[] = $acumulado_DIC2024_Total;

    ?>

    <div style="margin: auto; max-width: 35%; padding: 120px 0 0px 0;">
        <div class="p-4 mb-4 bg-white shadow-sm" style="border-radius: 14px; margin: 0; padding: 0;">
            <h4 class="mb-1 " style="padding: 0; margin: 5px 0 0 0;" >
                <strong style="color: #a80a0a;">Medidas descriptivas</strong> 
            </h4>

            <!-- POSICIÓN -->
            <h5 class="mb-1 " style="padding: 0; margin: 25px 0 0 0;" >
                <strong>Posición</strong> (contratos totales)
            </h5>

            <div style="padding: 20px 0 0 40px;">
                <p style="font-family: Cambria Math; font-size: 18px; color: #6b6767;"> 
                    <i style="font-size:15px; color: #a80a0a;" class="fa" 
                       title="La media aritmética es la suma de los datos dividida por el número de puntos de datos. Se la suele llamar “promedio”, aunque es solo uno de los muchos promedios matemáticos. Es una medida de la ubicación central de los datos.">
                        &#xf059;
                    </i> 
                    <strong>Media aritmética:</strong> 

                    <?php 
                    $mean = Stat::mean($stat_contratosTotales); 
                    echo $mean; 
                    ?>
                </p> 

                <p style="font-family: Cambria Math; font-size: 18px; color: #6b6767;"> 
                    <i style="font-size:15px; color: #a80a0a;" class="fa" 
                       title="Mediana (valor medio) de los datos numéricos, utilizando el conocido método “mean of middle two”: la mediana de un conjunto de números cuando el número de valores es par.">
                        &#xf059;
                    </i>
                    <strong>Mediana:</strong> 

                    <?php 
                    $median = Stat::median($stat_contratosTotales); 
                    echo $median; 
                    ?>
                </p>

                <p style="font-family: Cambria Math; font-size: 18px; color: #6b6767;"> 
                    <i style="font-size:15px; color: #a80a0a;" class="fa" 
                       title="La moda simple (i.e., el valor más común o frecuente) para un conjunto de datos discretos o nominales. De no existir valores o datos repetidos, la moda no existirá.">
                        &#xf059;
                    </i> 
                    <strong>Moda:</strong> 

                    <?php                     
                    $mode = Stat::mode($stat_contratosTotales); 

                    if (empty($mode)) {
                        $mode = "No existente";
                    }
                    echo $mode; 
                    ?>
                </p>

                <p style="font-family: Cambria Math; font-size: 18px; color: #6b6767; padding: 20px 0 0 0;"> 
                    <i style="font-size:15px; color: #a80a0a;" class="fa" 
                       title="El cuartil inferior, o primer cuartil (Q1), es el valor por debajo del cual se encuentran el 25% de los data points cuando estos se organizan en orden creciente. Por ejemplo, un Q1=10 significa que el 25% de los datos presentan un valor menor a 10.">
                        &#xf059;
                    </i>
                    <strong>Q1 (primer cuartil):</strong> 

                    <?php                     
                    $percentile = Stat::firstQuartile($stat_contratosTotales); 
                    echo $percentile; 
                    ?>
                </p>

                <p style="font-family: Cambria Math; font-size: 18px; color: #6b6767;"> 
                    <i style="font-size:15px; color: #a80a0a;" class="fa" 
                       title="El cuartil superior, o tercer cuartil (Q3), es el valor por debajo del cual se encuentran el 75% de los data points cuando estos se organizan en orden creciente. Por ejemplo, un Q3=10 significa que el 75% de los datos presentan un valor menor a 10.">
                        &#xf059;
                    </i>
                    <strong>Q3 (tercer cuartil):</strong> 

                    <?php                     
                    $percentile = Stat::thirdQuartile($stat_contratosTotales); 
                    echo $percentile; 
                    ?>
                </p>
            </div>

            <!-- DISPERSIÓN -->
            <h5 class="mb-1 " style="padding: 0; margin: 25px 0 0 0;" >
                <strong>Dispersión</strong> (contratos totales)
            </h5>

            <div style="padding: 20px 0 0 40px;">
                <p style="font-family: Cambria Math; font-size: 18px; color: #6b6767;"> 
                    <i style="font-size:15px; color: #a80a0a;" class="fa" 
                       title="La desviación estándar de la población, es decir, del conjunto total de los datos y no de una muestra. Es una medida de la cantidad de variación o dispersión de un conjunto de valores. Una desviación estándar baja indica que los valores tienden a estar cerca de la media del conjunto, mientras que una desviación estándar alta indica que los valores están distribuidos en un rango más amplio.">
                        &#xf059;
                    </i>
                    <strong>Desviación estándar:</strong> 

                    <?php 
                    $stdev = Stat::pstdev($stat_contratosTotales); 
                    echo $stdev; 
                    ?>
                </p> 

                <p style="font-family: Cambria Math; font-size: 18px; color: #6b6767;"> 
                    <i style="font-size:15px; color: #a80a0a;" class="fa" 
                       title="La varianza es una medida de dispersión de los puntos de datos con respecto a la media. Una varianza baja indica que los puntos de datos son generalmente similares y no varían mucho con respecto a la media. Una alta varianza indica que los valores de los datos tienen mayor variabilidad y están más dispersos respecto de la media. Aquí se muestra la varianza de toda la población de datos y no sólo de una muestra.">
                        &#xf059;
                    </i>
                    <strong>Varianza:</strong> 

                    <?php 
                    $variance = Stat::pvariance($stat_contratosTotales); 
                    echo $variance; 
                    ?>
                </p>
            </div>

        </div>
    </div>
    

    <!-- Tabla de datos -->
    <div style="margin: auto; max-width: 95%;">
        <div class="" style="margin-bottom: 120px;">
            
            <div class="p-5 mb-4 bg-white shadow-sm" style="margin-top: 10%; border: 2px solid #a80a0a; border-radius: 14px;">

                <h3 class="mb-4 " style="color: #a80a0a; padding: 0 0 20px 0;" ><strong>Tabla de datos:</strong>  Cantidad de Contratos por mes según estado </h3>
                
                <!-- Tabla con reporte de contratos -->

                <table class="table table-striped table-hover" id="tablaContratosPorMesSegunEstado">
                    <thead>
                        <tr>
                            <th style='color: #c7240e;'><h4>Categoría</h4></th>
                            <th style="text-align: center;">Total</th>
                            <th style="text-align: center;">Firmados</th>
                            <th style="text-align: center;">Cancelados</th>
                            <th style="text-align: center;">Finalizados</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td><span style='color: black;'><h4> 2024 </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Ene </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_ENE2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_ENE2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_ENE2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_ENE2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Feb </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_FEB2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_FEB2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_FEB2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_FEB2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Mar </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_MAR2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_MAR2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_MAR2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_MAR2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Abr </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_ABR2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_ABR2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_ABR2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_ABR2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> May </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_MAY2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_MAY2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_MAY2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_MAY2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Jun </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_JUN2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_JUN2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_JUN2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_JUN2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Jul </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_JUL2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_JUL2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_JUL2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_JUL2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Ago </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_AGO2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_AGO2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_AGO2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_AGO2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Sep </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_SEP2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_SEP2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_SEP2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_SEP2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Oct </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_OCT2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_OCT2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_OCT2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_OCT2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Nov </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_NOV2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_NOV2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_NOV2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_NOV2024_Finalizados; ?> </td>
                        </tr>
                        <tr>
                            <td><span style='color: black;'><h4> Dic </h4></span></td>
                            <td style="text-align: center;"> <?php echo $acumulado_DIC2024_Total; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_DIC2024_Firmados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_DIC2024_Cancelados; ?> </td>
                            <td style="text-align: center;"> <?php echo $acumulado_DIC2024_Finalizados; ?> </td>
                        </tr>

                    </tbody>
                </table>                    

                <!-- Botón de acción -->
                <div style="margin-top: 5%; margin-bottom: 3%;">
                    <div class="container d-flex justify-content-center">
                        <span style=""> <!-- margin-right: 10%; -->
                            <a href="contratosAlquiler.php"> 
                                <button class="btn" style="color: white; background-color: #a80a0a;" >
                                    Volver
                                </button>
                            </a>
                        </span>

                        <!-- 
                        <a href="ReporteContratos_FrecMensuales_pdf.php"> 
                            <button class="btn btn-warning" >
                                Imprimir
                            </button>
                        </a>
                        -->
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div style="">
        <?php require_once "foot.php"; ?>
    </div>

</body>
</html>

<?php
$html = ob_get_clean();
echo $html; // La variable $html ahora contiene la totalidad de la página. Imprimo en pantalla para que se continue viendo la página web

?>