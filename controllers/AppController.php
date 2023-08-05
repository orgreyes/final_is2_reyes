<?php

namespace Controllers;

use MVC\Router;

class AppController {
    public static function index(Router $router){
        $router->render('pages/index', []);
    }

    //!ruta para pacientes
    public static function pacientes(Router $router){
        $router->render('pacientes');
    }

    //!ruta para citas
    public static function citas(Router $router){
        $router->render('citas');
    }

    //!ruta para medicos
    public static function medicos(Router $router){
        $router->render('medicos');
    }

     //!ruta para clinicas
     public static function clinicas(Router $router){
        $router->render('clinicas');
    }

    //!ruta para especialidades
    public static function especialidades(Router $router){
        $router->render('especialidades');
    }

    //!ruta para detalles
    public static function detalles(Router $router){
        $router->render('detalles');
    }

    
}