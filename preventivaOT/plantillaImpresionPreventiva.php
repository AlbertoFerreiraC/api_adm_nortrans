<!DOCTYPE html>
<html>

<head>

    <title>Orden de Trabajo Preventiva</title>

    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            margin: 0;
            padding: 30px;

            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Contenedor documento */

        .documento {
            background: white;
            width: 900px;
            margin: 40px auto;
            /* CENTRA EL DOCUMENTO */
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Encabezado */

        .header {
            background: #f57c00;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            border-radius: 5px;
        }

        .subtitulo {
            text-align: center;
            margin-top: 5px;
            font-size: 16px;
            color: #666;
        }

        /* Bloques */

        .bloque {
            margin-top: 25px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }

        .bloque h3 {
            background: #f57c00;
            color: white;
            padding: 8px;
            margin: -15px -15px 15px -15px;
        }

        /* Información */

        .info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            font-size: 14px;
        }

        .info div {
            width: 30%;
        }

        /* Tabla */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #ffa040;
            color: white;
            padding: 8px;
            font-size: 13px;
        }

        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            font-size: 13px;
        }

        /* Footer */

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
        }

        /* IMPRESIÓN */

        @page {
            margin: 15mm;
            /* elimina márgenes grandes del navegador */
        }

        @media print {

            body {
                background: white;
            }

            .documento {
                margin: auto;
                width: 95%;
                box-shadow: none;
            }

            .header {
                background: #f57c00 !important;
                color: white !important;
            }

            .bloque h3 {
                background: #f57c00 !important;
            }

            th {
                background: #ffa040 !important;
            }

        }
    </style>

</head>

<body onload="window.print()">

    <div class="documento">

        <div class="header">
            NORTRANS S.A
        </div>

        <div class="subtitulo">
            Orden de Trabajo Preventiva
        </div>


        <div class="bloque">

            <h3>Datos de la Orden</h3>

            <div class="info">

                <div><b>N° OT:</b> <?php echo $cabecera['idot_interna']; ?></div>

                <div><b>Usuario:</b> <?php echo $cabecera['usuario']; ?></div>

                <div><b>Máquina:</b> <?php echo $cabecera['maquina']; ?></div>

                <div><b>Centro de Costo:</b> <?php echo $cabecera['centro_de_costo']; ?></div>

                <div><b>Fecha:</b> <?php echo $cabecera['fecha']; ?></div>

                <div><b>Km Actual:</b> <?php echo $cabecera['km_actual']; ?></div>

                <div><b>Estado:</b> <?php echo $cabecera['estado']; ?></div>

            </div>

        </div>


        <div class="bloque">

            <h3>Tareas de Mantención</h3>

            <table>

                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Técnico</th>
                    <th>Tipo tarea</th>
                    <th>Sistema</th>
                    <th>Sub sistema</th>
                    <th>Observación</th>
                    <th>Estado</th>
                </tr>

                <?php
                $i = 1;

                if (!empty($tareas)) {

                    foreach ($tareas as $t) {
                ?>

                        <tr>

                            <td><?php echo $i++; ?></td>
                            <td><?php echo $t['fecha']; ?></td>
                            <td><?php echo $t['tecnico']; ?></td>
                            <td><?php echo $t['tipo_tarea']; ?></td>
                            <td><?php echo $t['sistema']; ?></td>
                            <td><?php echo $t['sub_sistema']; ?></td>
                            <td><?php echo $t['observacion']; ?></td>
                            <td><?php echo $t['estado']; ?></td>

                        </tr>

                    <?php
                    }
                } else {
                    ?>

                    <tr>
                        <td colspan="8">Sin tareas registradas</td>
                    </tr>

                <?php
                }
                ?>

            </table>

        </div>


        <div class="footer">

            <div>Generado por Sistema NORTRANS</div>

            <div>Fecha impresión: <?php echo date("d/m/Y"); ?></div>

        </div>

    </div>

</body>

</html>