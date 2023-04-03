<?php

namespace App\Core;

/**
 *
 * Controller-Basisklasse, die essentielle Funktionen zum Laden der Views und Models, entsprechend der URL, beinhaltet
 * 
 * Alle Controller erben von dieser Klasse
 */

 class Controller{
    
    /**
     * Ladet das Modal in den jeweiligen Controller
     *
     * @param  string $category
     * @param  string $name
     * @return void
     */
    
    protected function loadModel(string $category, string $name){
      if($category){
         $model = "App\Model\\$category\\$name";
         $model = new $model();
         return $model;
      }

      $model = "App\Model\\$name";
      $model = new $model;
      return $model;
      
    }
    
    /**
     * Ladet die View und übergibt dieser dynamische Daten wie Seitentitel oder Fehlermeldungen, Erfolgsmeldungen
     *
     * @param  string $route
     * @param  array $data
     * @return void
     */

    protected function loadView(string $route, array $data = []){
       include "app/view/{$route}.php";
    }
 }