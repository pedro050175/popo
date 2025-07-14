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
        
        $action = preg_replace(DIRECTORIO,'',$_SERVER['REQUEST_URI']);
        
        //file_put_contents("log.txt", "ruta que llega a dispacth ".$action."\n" , FILE_APPEND);
        $action = trim($action, '/'); //elimina todos las / del principio y del final, si hay dos al principio quita las dos
        
        $param = null;
        preg_match('/[0-9]+$/', $action, $match);//busca la expresion regular (numeros unas o mas veces que se repiten hasta el final) en action y lo que en coincida con la empresion lo guarda en match
        if (!empty($match)) { //si hay parametros. esto no se para que es. si le añada a action el txto id, en la tabla routes no encontrara la funcion que guardo en add que usaba el indice [GET][action]
            $param = $match[0];
            $action = preg_replace('/'.$match[0].'/',':id',$action);
        }
        $action = preg_replace('/[?].+/','',$action); //elimino todo lo que hay en la url al encontrar un ? porque detras de ? vienen parametros que no puedo usar para acceder a la tabla routes
        //file_put_contents("log.txt", "ruta que limpiada: ".$action."\n" , FILE_APPEND);
        $callback = self::$routes[$method][$action];
        if (null != ($callback)) {
            $result= call_user_func($callback, $param);
            if (!is_null($result)){ 
                echo $result;            }
             
         } else { echo "Funcion nula";}    
    } 
}
