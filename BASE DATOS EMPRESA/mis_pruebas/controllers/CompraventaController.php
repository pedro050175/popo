<?php
namespace controllers;
use lib\Pages;

use repositories\VehiculoRepository;
use repositories\EntidadRepository;
use repositories\CompraventaRepository;
use repositories\CobroCompraventaRepository;
use repositories\PagoCompraventaRepository;
use repositories\GastoCompraventaRepository;
/* para PDF */
require __DIR__ . '/../vendor/autoload.php';/* en un require hay que poner toda la ruta del servidor /srv/www/api/mis_pruebas/... __DIR__ tiene toda del archivo que lo invoca 
incluida la ruta del servidor /srv/www/api/mis_pruebas/controllers*/
use Dompdf\Dompdf;
use Dompdf\Options;


class CompraventaController{
    
    private Pages $pages;
    private VehiculoRepository $vehiculoRepository;
    private EntidadRepository $entidadRepository;
    private CompraventaRepository $compraventaRepository;
    private CobroCompraventaRepository $cobroCompraventaRepository;
    private PagoCompraventaRepository $pagoCompraventaRepository;
    private GastoCompraventaRepository $gastoCompraventaRepository;
    
    function __construct(){
        $this->vehiculoRepository = new VehiculoRepository();
        $this->entidadRepository = new EntidadRepository();
        $this->pages = new Pages();
        $this->compraventaRepository = new CompraventaRepository();
        $this->cobroCompraventaRepository = new CobroCompraventaRepository();
        $this->pagoCompraventaRepository = new PagoCompraventaRepository();
        $this->gastoCompraventaRepository = new GastoCompraventaRepository();
    }
    public function list (): void{
        $compraventas = $this->compraventaRepository->findAllDinamico();
        $numPaginas = $this->compraventaRepository->getnumpaginas();
        $this->pages->render('compraventas', ['compraventas' => $compraventas, 'numPaginas' => $numPaginas]);
    }
    public function add(): void {  //despues de pinchar en nueva_entidad viene a este metodo add que carga pagina nueva:entidad con GET para meter datos y alli con boton sumit carga de nuevo la misma pagina pero con POST, con lo que se ejecuta save
        $empresas = $this->entidadRepository->empresasGrupo(); //carga solo empresas del grupo
        
        $this->pages->render('nueva_compraventa', ['empresas' => $empresas]);
    }
    public function save(): void { //se usa para guardar una nueva entidad o una entidad editada, al pulsar boton sumit de nueva_entidad se carga pagina nueva_entidad con POST y viene a este metodo
        $movimiento=$_POST['data']; //coge los datos del metodo POST, los graba y salta al listado entidades
        $idCreado = $this->compraventaRepository->save($movimiento);
        $mensaje = "El formulario se ha guardado correctamente"; 
        $tipo = "exito";
        header('Location: '.DIRECTORIO."nueva_compraventa/".$idCreado.'?mensaje='.$mensaje.'&tipo='.$tipo);   
        exit;
    }
    public function edit(int $id): void {//si se pulsa editar entidad, vendra aqui y leera esa entidad y con render cargara la pagina nueva entidad con una entidad, alli se ve que hay una entidad y se cargan los datos leidos en el formulario y al pulsar sumit se llama a save con POST
        $empresas = $this->entidadRepository->empresasGrupo(); //carga solo empresas del grupo
        $cobros = $this->cobroCompraventaRepository->cobrosCompraventa($id);
        $pagos = $this->pagoCompraventaRepository->pagosCompraventa($id);
        $gastos = $this->gastoCompraventaRepository->gastosCompraventa($id);
        $compraventa = $this->compraventaRepository->read($id);
        $this->pages->render('nueva_compraventa', ['empresas' => $empresas, 'compraventa' => $compraventa, 'pagos' => $pagos, 'cobros' => $cobros, 'gastos' => $gastos]);
    }
    public function delete(int $id): void {
        $this->compraventaRepository->delete($id);
        header('Location: '.DIRECTORIO.'compraventas?num_pagina=1');
        exit; 
    }
    public function analisis(){
        $compraventas_analisis = $this->compraventaRepository->analisis();
        $this->pages->render('analisis_compraventas_tri', ['compraventas_analisis' => $compraventas_analisis]);
    }  
    public function actualizaCompraventas(){
        $datos = $_POST['actualiza'];
        if ($_POST['accion'] == 'añadirTri'){
            $valor = 1;
        } else $valor = 0;
        $this->compraventaRepository->actualizaTri($datos, $valor);
        header('Location: '.DIRECTORIO.'compraventas?num_pagina=1&mensaje=Campos actualizados&tipo=exito');
        exit; 

    }
    public function contratoCompraventaPDF($id){
        /* leo directo de mysql si convertir en objeto */
        $compraventa = $this->compraventaRepository->readContrato($id);
        /* extract por cada elemento de la tabla 'ele' => valor crea una variable $ele=valor, 
        esto sirve para no tener que acceder a los datos con $compraventa[ele], las variables 
        creadas estan disponibles a patir de ahora para el codigo */
        extract($compraventa);
        /* para poner el fondo de cada empresa */
        if (str_contains(strtolower($nombreEmpresa),'stelar emotions')){
            $img = file_get_contents(__DIR__.'/../images/fondo_stelar.jpg');/* Lee todo el contenido del archivo de imagen y lo guarda en memoria */
        }else if (str_contains(strtolower($nombreEmpresa),'radikal world')){
                $img = file_get_contents(__DIR__.'/../images/fondo_world.png');/* Lee todo el contenido del archivo de imagen y lo guarda en memoria */
            }else if (str_contains(strtolower($nombreEmpresa),'universo radikal')){
                    $img = file_get_contents(__DIR__.'/../images/fondo_universo.png');/* Lee todo el contenido del archivo de imagen y lo guarda en memoria */
                }
         $imgBase64 = 'data:image/jpeg;base64,' . base64_encode($img);
        /* base64_encode($img): Convierte esos bytes binarios en una cadena ASCII segura, usando codificación Base64.
        Esto es necesario porque HTML no puede mostrar directamente datos binarios. 'data:image/jpeg;base64,' . ...: Crea un Data URI que HTML puede entender como imagen.
        Formato: data:[tipo_mime];base64,[datos]. En este caso: image/jpeg indica que es una imagen JPG. Resultado: $imgBase64 es una cadena de texto que contiene toda la imagen 
        codificada y que puede ponerse directamente en un src de <img>: */
        /* ob_start Activa el buffer de salida de PHP. A partir de ese momento: Todo lo que normalmente se imprimiría en pantalla
            Se guarda en memoria, no se envía al navegador  */
        ob_start();
        /* con require ejecuta el archivo de la plantilla como PHP. Se interpreta el HTML, Se evalúan los <?= $variable ?>
            Se genera contenido como si fuera una página normal. Pero como el buffer está activo, no se muestra nada aún. */
        require __DIR__.'/../templatesPDF/contratoCompraventa.php';
        /* Recupera todo lo que se generó desde ob_start() Lo guarda en una variable ($html) Limpia y cierra el buffer */
        $html = ob_get_clean();
        /* esto es para configurar el PDF */
        $options = new Options();
        $options->set('defaultFont', 'Dejavu Sans');
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf ($options);
        /* aqui se genera el PDF */
        $dompdf->loadHtml($html);
        /* con esto creo un fichero html con el contenido de $html que se puede abrir en el navegador y ver que se esta cargando para hacer el PDF
        Muy bueno para ver fallos */
        //file_put_contents('/srv/www/api/mis_pruebas/debug_html.html', $html);
        $dompdf->render();
        /* page_script es una API directa del motor de render de Dompdf. Puedes dibujar texto, líneas, imágenes, directamente sobre el PDF, incluso repetirlo automáticamente en cada 
        página, sin necesidad de que esté en el documento HTML.*/
        /* para el nº de pagina */
        $canvas = $dompdf->get_canvas();
        $canvas->page_script('
            $font = $fontMetrics->getFont("DejaVu Sans", "normal");
            $pageNumberText = "Página $PAGE_NUM de $PAGE_COUNT"; 
            $pdf->text(475, 770, $pageNumberText, $font, 8);
        ');/* $PAGE_NUM y $PAGE_COUNT son variables internas de Dompdf. 1º coordenada es la horizontal y la 2º la vertical */
        
        $w = $canvas->get_width(); /* get_width() y get_height() obtienen medidas de la página en puntos */
        $h = $canvas->get_height();
        /* hay que declarar y darle valos previamente a $PAGE_HEIGHT y $PAGE_WIDTH */
        /* para la firma y sello */
        if (str_contains(strtolower($nombreEmpresa),'stelar emotions')){
            $canvas->page_script('
                $PAGE_WIDTH = ' . $w . ';
                $PAGE_HEIGHT = ' . $h . ';
                $pdf->image("/srv/www/api/mis_pruebas/images/sello_firma_stelar.png",($PAGE_WIDTH-150)/8, $PAGE_HEIGHT-95, 120, 55);');/* $pdf->image(ruta, x, y, width, height) */
        }else if (str_contains(strtolower($nombreEmpresa),'radikal world')){
                $canvas->page_script('
                    $PAGE_WIDTH = ' . $w . ';
                    $PAGE_HEIGHT = ' . $h . ';
                    $pdf->image("/srv/www/api/mis_pruebas/images/sello_firma_world.png",($PAGE_WIDTH-150)/8, $PAGE_HEIGHT-95, 110, 35);');
            }else if (str_contains(strtolower($nombreEmpresa),'universo radikal')){
                    $canvas->page_script('
                        $PAGE_WIDTH = ' . $w . ';
                        $PAGE_HEIGHT = ' . $h . ';
                        $pdf->image("/srv/www/api/mis_pruebas/images/sello_firma_universo.png",($PAGE_WIDTH-150)/8, $PAGE_HEIGHT-105, 130, 45);');
                }

        $dompdf->stream('contratoCompraventa.php', ['Attachment' => true]); // true = descarga, false = vista previa
    } 
}
?>