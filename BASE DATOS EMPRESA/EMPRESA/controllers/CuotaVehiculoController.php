<?php
namespace controllers;

use repositories\CuotaVehiculoRepository;
use lib\Pages;

class CuotaVehiculoController{
    private CuotaVehiculoRepository $cuota_repository;
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
        $this->cuota_repository = new CuotaVehiculoRepository();

        
    }  
}