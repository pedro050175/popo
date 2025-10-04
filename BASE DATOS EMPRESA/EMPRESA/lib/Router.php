<?php
namespace lib;

class Router {

    private static $routes = [];
    
    public static function add(string $method, string $action, callable $controller): void {
        $action = trim($action, '/');
        self::$routes[$method][$action] = $controller;
    }

    public static function dispatch ():void{
        
        $method = $_SERVER['REQUEST_METHOD'];
        //var_dump(self::$routes);
        $action = preg_replace(DIRECTORIO,'',$_SERVER['REQUEST_URI']);
        
        //file_put_contents("log.txt", "ruta que llega a dispatch ".$action."\n" , FILE_APPEND);
        $action = trim($action, '/'); //elimina todos las / del principio y del final, si hay dos al principio quita las dos
        
        $action = preg_replace('/[?].+/','',$action); //1º elimino todo lo que hay en la url al encontrar un ? porque detras de ? vienen parametros que no puedo usar para acceder a la tabla routes
        
        //file_put_contents("log.txt", "ruta 1º limpiada: ".$action."\n" , FILE_APPEND);
        $param = null;
        preg_match('/[0-9]+$/', $action, $match);//busca la expresion regular (numeros uno o mas veces que se repiten hasta el final) en action y lo que en coincida con la expresion lo guarda en match
        if (!empty($match)) { //si hay parametro lo busca en action y lo reemplaza por :id que es lo que hay en la tabla routes, sino no encuentra la funcion que guarado con add  [GET][action]
            $param = $match[0];
            $action = preg_replace('/'.$match[0].'/',':id',$action);
        } 
        //file_put_contents("log.txt", "ruta 2º limpiada: ".$action."\n" , FILE_APPEND);       
        //para quitar de la URL los parametros ?campo=valor
        
        //file_put_contents("log.txt", "PARAMETRO: ".$param."\n" , FILE_APPEND);
        $callback = self::$routes[$method][$action];
        if (null != ($callback)) {
            $result= call_user_func($callback, $param);
            if (!is_null($result)){ 
                echo $result;            }
             
         } else { echo "Funcion nula";}    
    } 
}

