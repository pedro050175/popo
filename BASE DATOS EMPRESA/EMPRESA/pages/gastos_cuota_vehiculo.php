<?php
header("Content-Type: text/plain; charset=UTF-8");
?>
 
<table class = "mi_tabla w400">
    <caption>Gatos y Cuotas del vehiculo: <?=$nombreCoche['Marca_modelo']?></caption>
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Importe</th>
            <th>Fecha</th>
            <th>Paga otro</th>
        </tr>
    </thead>
    <tbody>
        <?php $totalGastos = 0; ?>
        <?php foreach ($gastos as $gasto) :?>
            <?php $totalGastos += $gasto->getImporte();?>
            <tr>
                <td class="tooltip-cell" data-tooltip="Observaciones: <?=quitaEspecialChar($gasto->getComentarios())?>">
                        <?=$gasto->getTipo()?>
                </td>
                <td><?=number_format($gasto->getImporte(), 2, ',', '.');?>€</td>
                <td><?=formatea_fecha($gasto->getFecha())?></td>
                <td><?=$gasto->getPaga_otro() ? 'SI' : 'NO'?></td>
            </tr>
        <?php endforeach ;?>
        <tr>
            <td>Total</td>
            <td><?=number_format($totalGastos, 2, ',', '.');?>€</td>
        </tr>
        <?php if (!empty($cuotas)) :?>
            <tr>
                    <th colspan="4">Cuota</th>
            </tr>
            <tr>
                <th>Fecha inicio</th>
                <th>Importe</th>
                <th>Entrada</th>
                <th>Total pagado cuotas+entrada</th>
            </tr>
            <tr><!-- aunque solo debe haber una cuota pero la consulta me devuelve una tabla de objetos cuota asi que tengo que hacer el for  -->
                <?php foreach ($cuotas as $cuota) :?>
                    <td class="tooltip-cell" data-tooltip="Observaciones: <?=quitaEspecialChar($cuota->getobservaciones())?>">
                            <?=formatea_fecha($cuota->getinicio())?>
                    </td>
                    <td><?=number_format($cuota->getcuota(), 2, ',', '.');?>€</td>
                    <td><?=number_format($cuota->getentrada(), 2, ',', '.');?>€</td>
                <?php endforeach ;?>
                <td>
                    <?php
                    /*calculo el total de cuotas pagadas, sacando los meses que se esta pagando x la cuota + entrada*/
                        $meses = diferenciaMeses($cuota->getinicio());
                        $inversion = $cuota->getcuota() * $meses + $cuota->getentrada();
                    ?>
                    <?= number_format($inversion, 2, ',', '.')?>
                </td>
            </tr>
        <?php endif ;?>
    </tbody>
</table>
