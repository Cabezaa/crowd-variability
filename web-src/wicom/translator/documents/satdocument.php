<?php

namespace Wicom\Translator\Documents;

use function \load;
load('document.php');

class SATDocument extends Document {
  protected $content = null;
  function __construct(){
      $this->content = "";
  }


  public function insert_line($line){
    $this->content .= $line; //Agregamos la linea que nos llega por el builder ya descompuesta
    $this->content .= "\n"; //saltamos de linea

  }
}
