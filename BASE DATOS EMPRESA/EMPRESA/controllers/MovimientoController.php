<?php

namespace controllers;

use repositories\MovimientoRepository;
use lib\Pages;


class MovimientoController{

    private MovimientoRepository $movimientoRepository;
    private Pages $pages;

    function __construct(){
        $this->movimientoRepository = new MovimientoRepository();
        $this->pages = new Pages();
    }

    public function list(): void {
        $movimientos = $this->movimientoRepository->findAll();
        $numeroPaginas = $this->movimientoRepository->getnumpaginas();
        $error = $_GET['error'] ?? null; //a $error le asigna $_GET['error'] si esta existe, variable pasada en la URL, sino le asigna null  
        //file_put_contents("log.txt", "Variable: ". $error. " \n" , FILE_APPEND);
        $this->pages->render('movimientos', ['movimientos' => $movimientos, 'error' => $error, 'num_paginas' => $numeroPaginas]);
    }





}