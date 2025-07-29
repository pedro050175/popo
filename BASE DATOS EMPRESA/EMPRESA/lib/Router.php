<?php
namespace lib;

class Router {

    private static $routes = [];
    
    public static function add(string $method, string $action, callable $controller): void {
        $action = trim($action, '/');
        self::$routes[$method][$action] = $controller;
    }

    public static function dispatch ():void{
        //no se puede usar echo dara un warning ver mi WORLD
        $method = $_SERVER['REQUEST_METHOD'];
        //var_dump(self::$routes);
        $action = preg_replace(DIRECTORIO,'',$_SERVER['REQUEST_URI']);
        
        //file_put_contents("log.txt", "ruta que llega a dispacth ".$action."\n" , FILE_APPEND);
        $action = trim($action, '/'); //elimina todos las / del principio y del final, si hay dos al principio quita las dos
        
        $param = null;
        preg_match('/[0-9]+$/', $action, $match);//busca la expresion regular (numeros unas o mas veces que se repiten hasta el final) en action y lo que en coincida con la empresion lo guarda en match
        if (!empty($match)) { //si hay parametro lo busca en action y lo reemplaza por :id que es lo que hay en la tabla routes, sino no encuentra la funcion que guarado con add  [GET][action]
            $param = $match[0];
            $action = preg_replace('/'.$match[0].'/',':id',$action);
        } 
               
        //para quitar de la URL los parametros ?campo=valor
        $action = preg_replace('/[?].+/','',$action); //elimino todo lo que hay en la url al encontrar un ? porque detras de ? vienen parametros que no puedo usar para acceder a la tabla routes
        //file_put_contents("log.txt", "ruta limpiada: ".$action."\n" , FILE_APPEND);
        //file_put_contents("log.txt", "PARAMETRO: ".$param."\n" , FILE_APPEND);
        $callback = self::$routes[$method][$action];
        if (null != ($callback)) {
            $result= call_user_func($callback, $param);
            if (!is_null($result)){ 
                echo $result;            }
             
         } else { echo "Funcion nula";}    
    } 
}
class duplicar_tabla {
    
    public static function duplica (array $modelo, array $data): array{   
        $resultado = $modelo;
        foreach ($data as $indice => $valor){ //paso los datos de data a modelo, si falta algun campo en data, modelo lo tiene creado
            $resultado[$indice] = $data[$indice];
        } 
        return $resultado;
    }
}   
class Limpiar_parametros {
     public static function limpiar(array $datos): array {
        $limpios = [];
        foreach ($datos as $clave => $valor) {
            $limpios[$clave] = (is_string($valor) && trim($valor) === '') ? null : $valor;
        }
        return $limpios;
    }
}