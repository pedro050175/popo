<?php     setcookie("menu", "fotos");

//solo se le puede cambiar el valor reescribiendola. $_COOKIE tiene el valor de la cookie que se lo envia el navegador del cliente al servidor de PHP y la guarda en $_COOKIE, si asigno un valor a $_COOKIE no cambia la cookie porque esta esta en el equivo del cliente
//se puede borrar con setcookie("numero_pagina"). cualquier operacion con setcookie tiene que ser antes de cargar HTML, una vez cargado HTML solo se puede consultar a $_COOKIE
//la cookie creada en un php no esta disponible hasta que se carge otra pagina, ya que al crearla php envia la creacion al navegador del cliente y este la crea, pero el navegador no evia el valor 
//de la cookie al servidor PHP hasta que no hay un cambio de pagina. Despues cada vez que se carga una nueva pagina el navegdor envia al servidor el valor de la cookie

?>