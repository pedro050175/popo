<div class = "bloque-movimiento"> 
    <table class = "tabla_resumen noultima" id = "compraventasTri">
        <!-- compraventas empresas-->
        <caption contentEditable>Resumen trimestre compra ventas</caption>
        <thead>
            <tr>
                <th contentEditable class="etiqueta">Empresa</th>
                <th contentEditable class="etiqueta">Vehiculo</th>
                <th contentEditable class="etiqueta">Impu.</th>
                <th contentEditable class="etiqueta">Precio comp.</th>
                <th contentEditable class="etiqueta">Precio declar.</th>
                <th contentEditable class="etiqueta">Precio vent.</th>
                <th contentEditable class="etiqueta">Precio declar.</th>
                <th contentEditable class="etiqueta">Iva</th>
                <th contentEditable class="etiqueta">Gastos</th>
                <th contentEditable class="etiqueta">Beneficio</th>
                <th contentEditable class="etiqueta">Beneficio-Iva</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalIVA = 0;
                $totalBeneficio = 0;
                $totalGastos = 0;
                $idEmpresa = $compraventas_analisis[0]->getempresa();/* 1º empresa */
                foreach ($compraventas_analisis as $compraventa){
                    if ($compraventa->getempresa()!=$idEmpresa){/*empresa leida diferente a la anterior => imprimo totales y los pongo a cero */
                        echo "<tr class = \"suma\">";
                            echo "<td contentEditable></td>";
                            echo "<td contentEditable></td>";
                            echo "<td contentEditable></td>";
                            echo "<td contentEditable></td>";
                            echo "<td contentEditable></td>";
                            echo "<td contentEditable></td>";
                            echo "<td contentEditable>TOTALES</td>";
                            echo "<td contentEditable>".number_format($totalIVA, 2, ',', '.')."€</td>";
                            echo "<td contentEditable>".number_format($totalGastos, 2, ',', '.')."€</td>";
                            echo "<td contentEditable>".number_format($totalBeneficio, 2, ',', '.')."€</td>";
                            echo "<td contentEditable>".number_format($totalBeneficio-$totalIVA, 2, ',', '.')."€</td>";
                            $totalIVA = 0;
                            $totalBeneficio = 0;
                            $totalGastos = 0;
                        echo "</tr>";
                    }
                    echo "<tr>"; /* misma empresa => imprimo datos de esa compraventa */
                    $totalIVA += $compraventa->IVA();
                    $totalBeneficio += $compraventa->beneficio();
                    $totalGastos += $compraventa->getsumaGastos(); 
                    echo "<td contentEditable>{$compraventa->getempresaInfo()->getNombre()}</td>";   
                    echo "<td contentEditable class=\"tooltip-cell info\" data-tooltip=\"{$compraventa->getvehiculoInfo()->getMarca_modelo()}--{$compraventa->getvehiculoInfo()->getMatricula()}\">{$compraventa->getvehiculoInfo()->getMarca_modelo()}</td>";
                    echo "<td contentEditable>{$compraventa->getimpuestoCompra()}</td>";
                    echo "<td contentEditable><strong>".number_format($compraventa->getprecioCompraReal(), 2, ',', '.')."€</strong></td>";
                    echo "<td contentEditable>".number_format($compraventa->getprecioCompraDeclarado(), 2, ',', '.')."€</td>";
                    echo "<td contentEditable><strong>".number_format($compraventa->getprecioVentaReal(), 2, ',', '.')."€</strong></td>";
                    echo "<td contentEditable>".number_format($compraventa->getprecioVentaDeclarado(), 2, ',', '.')."€</td>";
                    echo "<td contentEditable>".number_format($compraventa->IVA(), 2, ',', '.')."€</td>";
                    echo "<td contentEditable>".number_format($compraventa->getsumaGastos(), 2, ',', '.')."€</td>";
                    echo "<td contentEditable>".number_format($compraventa->beneficio(), 2, ',', '.')."€</td>";
                    echo "<td contentEditable>".number_format($compraventa->beneficioMenosIVA(), 2, ',', '.')."€</td>";
                    $idEmpresa = $compraventa->getempresa();
                    echo "</tr>";
                }
                /* al terminar el foreach me quedan por imprimir los totales de la ultima empresa leida */
                echo "<tr class = \"suma\">";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td>TOTALES</td>";
                    echo "<td contentEditable>".number_format($totalIVA, 2, ',', '.')."€</td>";
                    echo "<td contentEditable>".number_format($totalGastos, 2, ',', '.')."€</td>";
                    echo "<td contentEditable>".number_format($totalBeneficio, 2, ',', '.')."€</td>";
                    echo "<td contentEditable>".number_format($totalBeneficio-$totalIVA, 2, ',', '.')."€</td>";
                echo "</tr>";            
            ?>
        </tbody>
    </table>
</div>
<div class="col-md-1">
    <button type="button" class="boton_link" onclick = "exportarTablaExcel('compraventasTri', 'compraventasTrimestre')" title="Exportar a Excel"><i class="bi bi-file-earmark-spreadsheet"></i></button> 
    <input type="button" class="boton_link" id = "cerrar" value = "Cerrar" onclick="window.close()">
</div>
<h6 class = "etiqueta_mini">Puede editar cualquier campo pinchando sobre el</h6>
<script>
$(document).ready(function(){
    tooltip();
})
</script>