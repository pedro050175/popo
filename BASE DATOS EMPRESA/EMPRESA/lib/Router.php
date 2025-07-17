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
        //si uso alguna ruta mas que lleve : o = ejecutaria dos if y el 2º if machacaria los datos del 1º, :id lo puede cambiar por :algo por eso en ordenar uso =. Tmb podria hacerlo arreglado con un else despues del 1º if
        preg_match('/=[a-zA-Z]+/', $action, $match);//busca la expresion regular :texto en action y lo que en coincida con la empresion lo guarda en match ya que es un parametro para la funcion
        if (!empty($match)) { //le quita los : al parametro y sustituye el paramentro de la URL por :campo_ord que es lo que se puso en add para encontrar la funcion [GET][action]
            $param = $match[0];
            $param = trim($param, '=');
            $action = preg_replace('/'.$match[0].'/','=campo_ord',$action);
        }
        
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
