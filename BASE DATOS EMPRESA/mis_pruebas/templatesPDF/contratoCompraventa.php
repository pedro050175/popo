<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        h3 {
            text-align: center;
            margin-bottom: 10px;
            margin-top: 5px;
            color: #ee9003ff;
        }
        .clausula {
            margin-top: 5px;
            padding: 0px 1px ;
            margin-bottom: 5px;
            text-align: justify;
        }
        .clausula.gris{
            background-color: #e9e9e9ff;
            font-size: 11px;
        }
        pre {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .marco {
            border: 1px solid #ee9003ff;   
            padding: 0px 10px ;            /* arriba y abajo cero, dere izq 10 */
            border-radius: 8px 8px 8px 8px; /* borde redondeado sup izq y sup dere */
            margin-bottom: 5px;       
            margin-top: 5px;       
        }
        .tabla {
            position: relative;
            left: 25px;
            caption-side: top; 
            background: #fff;
            border-collapse: collapse; /* collapse no permite ver el redondeo */
            border: 1px solid #ee9003ff;/*si no le pongo borde en la parte inferior en la zona de las esquinas no sale linea*/
            padding: 0px;
            margin: 0px;
            margin-bottom: 10px;  
        }
        /* los bordes  */
        .tabla th {
            font-weight: bold;
            border: 1px solid #ee9003ff; 
            padding: 3px;             
            text-align: center;  
            font-size: 12px;  
            background-color: #f8f4e6; 
        }
        .tabla td {
            border: 1px solid #ee9003ff;             
            text-align: center;
            font-size: 12px;  
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin-top: 90; /* con estos margenes ajusto el margen del contenido, (no incluye footer, header, ni la imagen de fondo), 
            no afecta a la imagen de fondo, si le pongo mas el texto baja*/
            margin-left: 20;
            margin-right: 30;
            margin-bottom: 5;
        }
        @page {/* para aplicar a todas las paginas. controla los margenes mas externos, los de la pagina, (equivale a los margenes de Microsoft World)
            al modificar aqui afecta a todo el contenido */
            margin-top: 5;
            margin-left: 20;
            margin-right: 20;
            margin-bottom: 5;
        }
        .header { /* Encabezado fijo */
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 20px; /* alto */
            text-align: right;
            padding-top: 70px;
            padding-bottom: 5px;
            padding-right: 20px;
            font-size: 12px;
            z-index: 2;
        }
        .footer {/* Pie de página fijo */
            position: fixed;
            bottom: 0; left: 0; right: 0; 
            height: 20px; /* alto */
            text-align: left;
            font-size: 9px;
            z-index: 2;
            border-top: 1px solid #ee9003ff;
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header"><!-- ENCABEZADO -->
        <strong>CONTRATO DE COMPRAVENTA DE VEHICULO</strong><br>
    </div>
    <div class="footer"><!-- PIE DE PÁGINA -->
        <?= $nombreEmpresa ?> - CIF: <?= $CIF_DNIEmpresa ?>, <?= $DireccionEmpresa ?>
    </div>
    <!-- CONTENIDO PRINCIPAL -->
    <div style="position: fixed; top: 0; left: 10; width: 100%; height: 100%; background-image: url('<?= $imgBase64 ?>');
                background-size: contain; background-repeat: no-repeat; background-position: center top; opacity: 1; z-index: -1;">
    </div>
    <div style="position: relative; z-index: 2;">
        <!-- imagen de Fondo -->
        <p class="clausula">
            En <?= CIUDAD_CONTRATOS?>, a <?= formatea_fecha($fechaVenta) ?>, se celebra el presente contrato de compraventa de vehiculo entre:
        </p>
        <div class = "marco">
            <p class="clausula">
                <strong>Vendedor: <?= $nombreEmpresa ?>, DNI <?= $CIF_DNIEmpresa ?>,</strong> con domicilio en <strong><?=  $DireccionEmpresa?> </strong>, cuyo representante es: <?= $ObservacionesEmpresa ?> y
            </p>
            <p class="clausula">
                <strong>Comprador: <?= $nombreVende ?>, DNI <?= $CIF_DNIVende ?>, </strong>con domicilio en <strong><?=  $DireccionVende?> </strong>cuyo representante es: <?= $ObservacionesVende ?>
            </p>
        </div>
        <table class = "tabla">
            <caption>Datos del Vehiculo</caption>
            <thead>
                <tr>
                    <th>Marca y modelo</th>
                    <th>Matricula</th>
                    <th>Bastidor</th>
                    <th>Estado</th>
                    <th>1º matrícula</th>
                    <th>Combustible</th>
                    <th>Kilometros</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $Marca_modelo ?></td>
                    <td><?= $Matricula ?></td>
                    <td><?= $Bastidor?></td>
                    <td><?= $Estado ?></td>
                    <td><?= $Fecha_matricula ?></td>
                    <td><?= $Combustible ?></td>
                    <td><?= $kmVenta ?></td>
                </tr>
            </tbody>
        </table>
        <div class = "marco">
            <p class="clausula gris">
                1. El vendedor declara que dicho vehículo es de su legítima propiedad y lo vende y lo entrega en este acto al comprador, recibiéndolo éste a su entera satisfacción. O de no ser de su propiedad, declara que tiene autorización sobre el vehículo de su legítimo propietario para su venta, actuando de intermediario.
            </p>
            <p class="clausula gris">
                2. El precio de la compraventa, teniendo en cuenta las características del vehículo, a su naturaleza de bien usado, al estado que presentan sus componentes, a su antigüedad y kilómetros recorridos, se pacta de común acuerdo en:
            </p>
            <p class="clausula marco">
                <strong><?= number_format($precioVentaDeclarado, 2, ',', '.') ?></strong>€ (impuestos incluidos). Tipo de Impuesto: <strong><?= $impuestoVenta ?></strong>
            </p>
            <p class="clausula gris">
                3. Forma de pago: <strong><?= $formaPagoVenta ?></strong> 
            </p>
            <p class="clausula gris">
                4. El vendedor manifiesta que sobre el vehículo no pesa ningún gravamen, impuesto ni débito de clase alguna pendiente de liquidación a fecha de este contrato, obligándose a estar de entera indemnidad a favor del comprador de cualquier reclamación.
            </p>
            <p class="clausula gris">    
                5. El vendedor facilita al comprador en este acto, todos aquellos documentos que son necesarios para que el vehículo quede inscrito a su nombre en la Dirección General de Tráfico. El vendedor se compromete también a facilitar y firmar al comprador, con posterioridad a la firma del contrato, cuantos documentos sean necesarios para la inscripción en todos los organismos públicos.
            </p>
            <p class="clausula gris">    
                6. El comprador se hace cargo desde la fecha de la recogida del vehículo, de todas las responsabilidades que se puedan contraer como consecuencia de la propiedad del vehículo descrito que acepta, para su tenencia o uso 
            </p>
        </div>
        <div class = "marco">
            <p class="clausula gris">
                Otras clausulas:
                <?= nl2br(htmlspecialchars($clausulasVenta)) ?><!-- con nl2br(htmlspecialchars se respentan los retornos de carro que hay en el texarea, convierte \n en <br> -->
            </p>
        </div>
        <p class="clausula">
            Y para que conste y donde convenga, se extiende el presente contrato por duplicado a un solo efecto, 
            quedando un ejemplar en cada una de las partes interesadas.
        </p>
        <p>
            <pre> Firma y sello del Vendedor                                                             Firma y sello del Comprador </pre>
        </p>
    </div>
</body>
</html>