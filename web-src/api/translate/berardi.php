<?php 
/* 

   Copyright 2016 Giménez, Christian
   
   Author: Giménez, Christian   

   berardi.php
   
   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.
   
   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
   
   You should have received a copy of the GNU General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


/**
   Translate to OWLlink using Berardi strategy. 

   The Berardi strategy implements the method explained on "Reasoning on UML 
   Class Diagrams" by Daniela Berardi, Diego Calvanesse and Giuseppe De
   Giacomo.

   Try this command:
   
   @code
   curl -d 'json={\"classes\": [{\"attrs\":[], \"methods\":[], \"name\": \"Hi World\"}]}' http://host.com/api/translate/berardi.php";
   @endcode

   @return An XML web page.
 */

require_once '../../common/import_functions.php';

load('translator.php', '../../wicom/translator/');
load('owllinkdocument.php', '../../wicom/translator/documents/');
load('berardistrat.php','../../wicom/translator/strategies/');
load('owllinkbuilder.php', '../../wicom/translator/builders/');
load('htmlbuilder.php', '../../wicom/translator/builders/');

use Wicom\Translator\Translator;
use Wicom\Translator\Strategies\Berardi;
use Wicom\Translator\Builders\OWLlinkBuilder;
use Wicom\Translator\Builders\HTMLBuilder;

$format = 'owllink';
if (array_key_exists('format',$_REQUEST)){
    $format = $_REQUEST['format'];
}

if ( ! array_key_exists('json', $_POST)){
    echo "
There's no \"json\" parameter :-(
Use, for example:

    curl -d 'json={\"classes\": [{\"attrs\":[], \"methods\":[], \"name\": \"Hi World\"}]}' http://host.com/translator/berardi.php";
}else{
    $builder = null;

    
    switch ($format){
    case "owllink" :
        $builder = new OWLlinkBuilder();
        break;
    case "html" :
        $builder = new HTMLBuilder();
        break;
    default:
        die("Format not recognized");
    }
        
    $trans = new Translator(new Berardi(), $builder);
    $res = $trans->to_owllink($_POST['json']);
    print_r($res);
}

?>

