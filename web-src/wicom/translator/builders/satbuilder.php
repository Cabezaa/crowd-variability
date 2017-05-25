<?php
namespace Wicom\Translator\Builders;

use function \load;
load("documentbuilder.php");
load("htmldocument.php", "../documents/");

use Wicom\Translator\Documents\SATDocument;

class SATBuilder extends DocumentBuilder {
  function __construct(){
    $this->product = new SATDocument();
  }


}
