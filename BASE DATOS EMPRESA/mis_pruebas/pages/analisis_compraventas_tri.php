<div class = "bloque-movimiento"> 
    <table class = "tabla_resumen fina noultima">
        <!-- compraventas empresas-->
        <caption>Total </caption>
        <thead>
            <tr>
                <th class="etiqueta">Empresa</th>
                <th class="etiqueta">Vehiculo</th>
                <th class="etiqueta">Impu.</th>
                <th class="etiqueta">Precio comp.</th>
                <th class="etiqueta">Precio declar.</th>
                <th class="etiqueta">Precio vent.</th>
                <th class="etiqueta">Precio declar.</th>
                <th class="etiqueta">Gastos</th>
                <th class="etiqueta">Iva</th>
                <th class="etiqueta">Beneficio-Gast</th>
                <th class="etiqueta">Beneficio-Gast-Iva</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalIVA = 0;
                $totalBeneficio = 0;
                $totalGastos = 0;
                $idEmpresa = $compraventas_analisis[0]->getempresa();

                foreach ($compraventas_analisis as $compraventa){
                    echo "<tr>";
                    
                    if ($compraventa->getempresa()!=$idEmpresa){
                        echo "<tr>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td><strong>TOTALES</strong></td>";
                            echo "<td>".number_format($totalGastos, 2, ',', '.')."€</td>";
                            echo "<td>".number_format($totalIVA, 2, ',', '.')."€</td>";
                            echo "<td>".number_format($totalBeneficio, 2, ',', '.')."€</td>";
                            echo "<td>".number_format($totalBeneficio-$totalIVA, 2, ',', '.')."€</td>";
                            $totalIVA = 0;
                            $totalBeneficio = 0;
                            $totalGastos = 0;
                        echo "</tr>";
                    } 
                    $totalIVA += $compraventa->IVA();
                    $totalBeneficio += $compraventa->beneficio();
                    $totalGastos += $compraventa->getsumaGastos(); 
                    echo "<td>{$compraventa->getempresaInfo()->getNombre()}</td>";   
                    echo "<td class=\"tooltip-cell info\" data-tooltip=\"{$compraventa->getvehiculoInfo()->getMarca_modelo()}\">{$compraventa->getvehiculoInfo()->getMarca_modelo()}</td>";
                    echo "<td>{$compraventa->getimpuestoCompra()}</td>";
                    echo "<td><strong>".number_format($compraventa->getprecioCompraReal(), 2, ',', '.')."€</strong></td>";
                    echo "<td>".number_format($compraventa->getprecioCompraDeclarado(), 2, ',', '.')."€</td>";
                    echo "<td><strong>".number_format($compraventa->getprecioVentaReal(), 2, ',', '.')."€</strong></td>";
                    echo "<td>".number_format($compraventa->getprecioVentaDeclarado(), 2, ',', '.')."€</td>";
                    echo "<td>".number_format($compraventa->getsumaGastos(), 2, ',', '.')."€</td>";
                    echo "<td>".number_format($compraventa->IVA(), 2, ',', '.')."€</td>";
                    echo "<td>".number_format($compraventa->beneficio(), 2, ',', '.')."€</td>";
                    echo "<td>".number_format($compraventa->beneficioMenosIVA(), 2, ',', '.')."€</td>";
                    $idEmpresa = $compraventa->getempresa();
                    
                    echo "</tr>";
                }
                echo "<tr>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td><strong>TOTALES</strong></td>";
                    echo "<td>".number_format($totalGastos, 2, ',', '.')."€</td>";
                    echo "<td>".number_format($totalIVA, 2, ',', '.')."€</td>";
                    echo "<td>".number_format($totalBeneficio, 2, ',', '.')."€</td>";
                    echo "<td>".number_format($totalBeneficio-$totalIVA, 2, ',', '.')."€</td>";
                    $totalIVA = 0;
                    $totalBeneficio = 0;
                    $totalGastos = 0;
                echo "</tr>";            
            ?>
        </tbody>
    </table>
</div>
<script> 
    tooltip();
</script>