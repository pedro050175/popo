<div class = 'contenedor'>
    <div>
        <?php 
            foreach ($deudasEmpresas as $deuda) {
                if ($deuda[2] != 0) {
                    echo '<p style= "text-align: center" class= "etiqueta blue">->'. $deuda[1]. ' le debe a '. $deuda[0]. ':............... '. number_format($deuda[2], 2, ',', '.'). '€  </p>';
                }
        }
        ?>
    </div>
</div>