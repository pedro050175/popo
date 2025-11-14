<?php
require_once "autoloader.php";
require_once "config.php";
require_once "Funciones.php";

use lib\Router;
use controllers\EntidadController;
use controllers\VehiculoController;
use controllers\FotoController;
use controllers\GastoVehiculoController;
use controllers\CuotaVehiculoController;
use controllers\MovimientoController;
use controllers\EntregaController;
use controllers\DevolucionController;
use controllers\AlquilerController;
use controllers\AmpliacionAlquilerController;
use controllers\CobroAlquilerController;
use controllers\GastoAlquilerController;
use controllers\CompraventaController;
use controllers\CobroCompraventaController;
use controllers\PagoCompraventaController;
use controllers\GastoCompraventaController;
use controllers\MultaController;

//Cuando da error en el router "índice array no existe" y sale mensaje "función nula" es problema de rutas relativas de los href, la ruta del href que se usa como segundo índice en el array routes no coincide con la que se ha añadido a routes con add
//Rutas de Entidades
Router::add('GET', '/detalles_entidad/:id', function($entidadId) {return (new EntidadController())->detalles_entidad($entidadId);});
Router::add('GET', '/borrar/:id', function($entidadId){return (new EntidadController())->delete($entidadId);});
Router::add('GET', '/nueva_entidad/:id', function($entidadId) {return (new EntidadController())->edit($entidadId);}); 
Router::add('POST', '/nueva_entidad', function () {return (new EntidadController())->save();});
Router::add('GET', '/nueva_entidad', function() {return (new EntidadController())->add();});
Router::add('GET', '/entidades', function () {return (new EntidadController())->list();});
//file_put_contents("log.txt", $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);
//Rutas de Vehiculos
Router::add('GET', '/detalles_vehiculo/:id', function($vehiculoId) {return (new VehiculoController())->detalles_vehiculo($vehiculoId);});
Router::add('GET', '/borrar_vehiculo/:id', function($id_vehiculo){return (new VehiculoController())->delete($id_vehiculo);});
Router::add('GET', '/nuevo_vehiculo/:id', function($id_vehiculo) {return (new VehiculoController())->edit($id_vehiculo);}); 
Router::add('POST', '/nuevo_vehiculo', function () {return (new VehiculoController())->save();});
Router::add('GET', '/nuevo_vehiculo', function() {return (new VehiculoController())->add();});
Router::add('GET', '/vehiculos', function () {return (new VehiculoController())->list();});
Router::add('GET', '/gastos_cuota_vehiculo', function () {return (new VehiculoController())->gastosCuotasVehiculo();});

//Rutas de fotos vehiculo
Router::add('GET', '/borrar_foto_vehiculo/:id', function($id_foto){return (new FotoController())->delete($id_foto);});
Router::add('GET', '/editar_foto/:id', function($id_foto) {return (new FotoController())->edit($id_foto);}); 
Router::add('POST', '/nueva_foto', function () {return (new FotoController())->save();});
//Rutas de gastos vehiculo
Router::add('GET', '/borrar_gasto_vehiculo/:id', function($id_gasto){return (new GastoVehiculoController())->delete($id_gasto);});
Router::add('GET', '/editar_gasto_vehiculo/:id', function($id_gasto) {return (new GastoVehiculoController())->edit($id_gasto);}); 
Router::add('POST', '/nuevo_gasto_vehiculo', function () {return (new GastoVehiculoController())->save();});
//Rutas de cuotas vehiculo
Router::add('GET', '/borrar_cuota_vehiculo/:id', function($id_cuota){return (new CuotaVehiculoController())->delete($id_cuota);});
Router::add('GET', '/editar_cuota_vehiculo/:id', function($id_cuota) {return (new CuotaVehiculoController())->edit($id_cuota);});
Router::add('POST', '/nueva_cuota_vehiculo', function () {return (new CuotaVehiculoController())->save();});

//movimientos dinero
Router::add('GET', '/movimientos', function () {return (new MovimientoController())->list();});
Router::add('GET', '/nuevo_movimiento', function() {return (new MovimientoController())->add();});
Router::add('POST', '/nuevo_movimiento', function () {return (new MovimientoController())->save();});
Router::add('GET', '/nuevo_movimiento/:id', function($idMovimiento) {return (new MovimientoController())->edit($idMovimiento);}); 
Router::add('GET', '/detalles_movimiento/:id', function($idMovimiento) {return (new MovimientoController())->detalles_movimiento($idMovimiento);});
Router::add('GET', '/borrar_movimiento/:id', function($idMovimiento){return (new MovimientoController())->delete($idMovimiento);});
Router::add('GET', '/analisis_movimientos',function(){return (new MovimientoController())->analisis();});
Router::add('GET', '/deuda_empresas',function(){return (new MovimientoController())->deudaEmpresas();});
//Router::add('POST', '/analisis_movimientos',function(){return (new MovimientoController())->analisis();});

//entregas movimientos
Router::add('POST', '/nueva_entrega', function () {return (new EntregaController())->save();});
Router::add('GET', '/editar_entrega/:id', function($idEntrega) {return (new EntregaController())->edit($idEntrega);});
Router::add('GET', '/borrar_entrega/:id', function($idEntrega){return (new EntregaController())->delete($idEntrega);});

//devoluciones movimientos
Router::add('POST', '/nueva_devolucion', function () {return (new DevolucionController())->save();});
Router::add('GET', '/editar_devolucion/:id', function($idDevolucion) {return (new DevolucionController())->edit($idDevolucion);});
Router::add('GET', '/borrar_devolucion/:id', function($idDevolucion){return (new DevolucionController())->delete($idDevolucion);});
//alquileres 
Router::add('GET', '/alquileres', function () {return (new AlquilerController())->list();});
Router::add('GET', '/nuevo_alquiler', function() {return (new AlquilerController())->add();});
Router::add('POST', '/nuevo_alquiler', function () {return (new AlquilerController())->save();});
Router::add('GET', '/nuevo_alquiler/:id', function($id) {return (new AlquilerController())->edit($id);});
Router::add('GET', '/borrar_alquiler/:id', function($id){return (new AlquilerController())->delete($id);});
Router::add('GET', '/analisis_alquileres', function(){return (new AlquilerController())->analizar();});
Router::add('GET', '/detalles_alquiler/:id', function($id) {return (new AlquilerController())->detalles_alquiler($id);});
Router::add('POST', '/total_alquileres_vehiculo_fecha', function() {return (new AlquilerController())->totalAlquileresVehiculosFecha();});
Router::add('POST', '/total_alquileres_vehiculos', function() {return (new AlquilerController())->totalAlquileresVehiculos();});
/* actuializa el estado del alquiler con AJAX si cargar la pagina*/
Router::add('GET', '/estadoAlquiler', function(){return (new AlquilerController())->estadoAlquiler();});

//ampliaciones alquiler
Router::add('POST', '/nueva_ampliacion_alquiler', function () {return (new AmpliacionAlquilerController())->save();});
Router::add('GET', '/editar_ampliacion_alquiler/:id', function($id) {return (new AmpliacionAlquilerController())->edit($id);});
Router::add('GET', '/borrar_ampliacion_alquiler/:id', function($id){return (new AmpliacionAlquilerController())->delete($id);});
//cobros alquiler
Router::add('POST', '/nuevo_cobro_alquiler', function () {return (new CobroAlquilerController())->save();});
Router::add('GET', '/editar_cobro_alquiler/:id', function($id) {return (new CobroAlquilerController())->edit($id);});
Router::add('GET', '/borrar_cobro_alquiler/:id', function($id){return (new CobroAlquilerController())->delete($id);});
//gastos alquiler
Router::add('POST', '/nuevo_gasto_alquiler', function () {return (new GastoAlquilerController())->save();});
Router::add('GET', '/editar_gasto_alquiler/:id', function($id) {return (new GastoAlquilerController())->edit($id);});
Router::add('GET', '/borrar_gasto_alquiler/:id', function($id){return (new GastoAlquilerController())->delete($id);});
//Compra Venta
Router::add('GET', '/compraventas', function () {return (new CompraventaController())->list();});
Router::add('GET', '/nueva_compraventa', function () {return (new CompraventaController())->add();});
Router::add('POST', '/nueva_compraventa', function () {return (new CompraventaController())->save();});
Router::add('GET', '/nueva_compraventa/:id', function($id) {return (new CompraventaController())->edit($id);});
Router::add('GET', '/borrar_compraventa/:id', function($id){return (new CompraventaController())->delete($id);});
Router::add('GET', '/analisis_compraventas_tri', function(){return (new CompraventaController())->analisis();});
/* actualiza el trimestre de las compraventas seleccionadas */
Router::add('POST', '/actualizaCompraventas', function(){return (new CompraventaController())->actualizaCompraventas();});
//pagos compraventa
//pagos compraventanalisisers_tri::add('POST', '/nuevo_cobro_compraventa', function () {return (new CobroCompraventaController())->save();});
Router::add('POST', '/nuevo_cobro_compraventa', function() {return (new CobroCompraventaController())->save();});
Router::add('GET', '/editar_cobro_compraventa/:id', function($id) {return (new CobroCompraventaController())->edit($id);});
Router::add('GET', '/borrar_cobro_compraventa/:id', function($id){return (new CobroCompraventaController())->delete($id);});
//Pagos compraventa
Router::add('POST', '/nuevo_pago_compraventa', function () {return (new PagoCompraventaController())->save();});
Router::add('GET', '/editar_pago_compraventa/:id', function($id) {return (new PagoCompraventaController())->edit($id);});
Router::add('GET', '/borrar_pago_compraventa/:id', function($id){return (new PagoCompraventaController())->delete($id);});
//Gastos compraventa
Router::add('POST', '/nuevo_gasto_compraventa', function () {return (new GastoCompraventaController())->save();});
Router::add('GET', '/editar_gasto_compraventa/:id', function($id) {return (new GastoCompraventaController())->edit($id);});
Router::add('GET', '/borrar_gasto_compraventa/:id', function($id){return (new GastoCompraventaController())->delete($id);});
//multas
Router::add('GET', '/multas', function () {return (new MultaController())->list();});
Router::add('GET', '/nueva_multa', function () {return (new MultaController())->add();});
Router::add('POST', '/nueva_multa', function () {return (new MultaController())->save();});
Router::add('GET', '/nueva_multa/:id', function($id) {return (new MultaController())->edit($id);});
Router::add('GET', '/borrar_multa/:id', function($id){return (new MultaController())->delete($id);});
Router::add('GET', '/nueva_multa_multiple', function($id){return (new MultaController())->addMultiple($id);});
Router::add('GET', '/guardar_multa_multiple', function($id){return (new MultaController())->saveMultiple($id);});


Router::dispatch();

?>