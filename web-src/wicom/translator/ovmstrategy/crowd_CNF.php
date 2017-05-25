<?php


namespace Wicom\Translator\OVMStrategies;

use function \load;
load('OVMStrategies.php');


class CNFcrowd extends OVMStrategies{

    function translate($json_str, $builder){

        $json = json_decode($json_str, true);

        // Classes
        $js_services = $json["service"];
        printf($js_services);
        foreach ($js_services as $service){
            //$builder->insert_subclassof($class["name"], "owl:Thing");
            printf($service);
            //Agregar aca el mensaje para descomponer el servicio.
        }
        //$this->translate_links($json, $builder);
        //Aca si quiero podria poner a descomponer las restricciones
    }

}
