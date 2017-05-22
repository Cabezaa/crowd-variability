<?php
/*

   Copyright 2016 Gilia, Departamento de Teoría de la Computación, Universidad Nacional del Comahue

   Author: Gilia

   crowdUMLtest.php

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

require_once("common.php");

// use function \load;
load("crowd_CNF.php", "wicom/translator/strategies/ovmstrategy/");
load("owllinkbuilder.php", "wicom/translator/builders/");

use Wicom\Translator\Strategies\UMLcrowd;
use Wicom\Translator\Builders\OWLlinkBuilder;

/**
   # Warning!
   Don't use assertEqualXMLStructure()! It won't check for attributes values!

   It will only check for the amount of attributes.
 */


class UMLcrowdTest extends PHPUnit_Framework_TestCase
{


/*    public function testTranslate(){
        //TODO: Complete JSON!
        $json = <<<'EOT'
{
"classes": [{"attrs":[], "methods":[], "name": "Hi World"}],
"links": []
}
EOT;
        //TODO: Complete XML!
        $expected = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<RequestMessage xmlns=\"http://www.owllink.org/owllink#\"
xmlns:owl=\"http://www.w3.org/2002/07/owl#\"
xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
xsi:schemaLocation=\"http://www.owllink.org/owllink# http://www.owllink.org/owllink-20091116.xsd\">
       <CreateKB kb=\"http://localhost/kb1\" />
       <Tell kb=\"http://localhost/kb1\">
       		<owl:SubClassOf>
       		<owl:Class IRI=\"Hi World\" />
       		<owl:Class abbreviatedIRI=\"owl:Thing\" />
       		</owl:SubClassOf>
       </Tell>
</RequestMessage>";

        $strategy = new UMLcrowd();
        $builder = new OWLlinkBuilder();

        $builder->insert_header(); // Without this, loading the DOMDocument
        // will throw error for the owl namespace
        $strategy->translate($json, $builder);
        $builder->insert_footer();

        $actual = $builder->get_product();
        $actual = $actual->to_string();

        //$expected = process_xmlspaces($expected);
        //$actual = process_xmlspaces($actual);
        // Don't use assertEqualXMLStructure()! It won't check for attributes values!
        $this->assertXmlStringEqualsXmlString($expected, $actual, true);
    }
*/



    ##
    # Test if translate works properly with binary roles many-to-many
    public function testTranslateMandatory(){
		$json = <<< EOT

  //INSERTAR JSON DE TEST DE MATI.
  {
    "Datasheet" : {
      "id" : "service mandatoryEjemplo",
      "service" : {
        "name" : "A",
        "GlobalVariationPoint" : {
          "MandatoryVP" : {
            "service" : [
               { "name" : "B1" },
               { "name" : "B2" }
            ]
          }
        }
      }
    }
  }

EOT;

        //TODO: Complete XML!
        $expected = <<< EOT
"p cnf 4 4
1 0
2 0
-2 3 0
-2 4 0"
EOT;

        $strategy = new CNFcrowd();
        $builder = new OWLlinkBuilder();

  #      $builder->insert_header(); // Without this, loading the DOMDocument
        // will throw error for the owl namespace
        $strategy->translate($json, $builder);
#        $builder->insert_footer();

        $actual = $builder->get_product();
        $actual = $actual->to_string();
        $this->assertXmlStringEqualsXmlString($expected, $actual,true);
    }




    ##
    # Test if translate works properly with binary roles many-to-many
    public function testTranslateOptional(){
		$json = <<< EOT
    {
      "Datasheet" : {
        "id" : "service mandatoryEjemplo",
        "service" : {
          "name" : "A",
          "GlobalVariationPoint" : {
            "OptionalVP" : {
              "service" : [
                 { "name" : "B1" },
                 { "name" : "B2" }
              ]
            }
          }
        }
      }
    }
EOT;

        //TODO: Complete XML!
        $expected = <<< EOT
"p cnf 4 4
1 0
2 0
-2 -3 3 0
-2 -4 4 0"

EOT;

        $strategy = new CNFcrowd();
        $builder = new OWLlinkBuilder();

        //$builder->insert_header(); // Without this, loading the DOMDocument
        // will throw error for the owl namespace
        $strategy->translate($json, $builder);
        //$builder->insert_footer();

        $actual = $builder->get_product();
        $actual = $actual->to_string();
        $this->assertXmlStringEqualsXmlString($expected, $actual,true);
    }



    ##
    # Test if translate works properly with binary roles many-to-many
    public function testTranslateAlternative(){
		$json = <<< EOT
    {
      "Datasheet" : {
        "id" : "service mandatoryEjemplo",
        "service" : {
          "name" : "A",
          "GlobalVariationPoint" : {
            "AlternativeVP" : {
              "service" : [
                 { "name" : "B1" },
                 { "name" : "B2" },
                 { "name" : "B3" }
              ]
            }
          }
        }
      }
    }
EOT;

        //TODO: Complete XML!
        $expected = <<< EOT
"p cnf 5 9
1 0
2 0
-2 -3 -4 5 0
-2 -3 4 -5 0
-2 3 -4 -5 0
-2 3 4 5 0
-3 -4 0
-3 -5 0
-4 -5 0
"
EOT;

        $strategy = new CNFcrowd();
        $builder = new OWLlinkBuilder();

        //$builder->insert_header(); // Without this, loading the DOMDocument
        // will throw error for the owl namespace
        $strategy->translate($json, $builder);
        //$builder->insert_footer();

        $actual = $builder->get_product();
        $actual = $actual->to_string();
        $this->assertXmlStringEqualsXmlString($expected, $actual,true);
    }


    ##
    # Test if translate works properly with binary roles many-to-many
    public function testTranslateVariant(){
		$json = <<< EOT
    {
      "Datasheet" : {
        "id" : "service mandatoryEjemplo",
        "service" : {
          "name" : "A",
          "GlobalVariationPoint" : {
            "VariantVP" : {
              "service" : [
                 { "name" : "B1" },
                 { "name" : "B2" },
                 { "name" : "B3" },
              ]
            }
          }
        }
      }
    }
EOT;

        //TODO: Complete XML!
        $expected = <<< EOT
"p cnf 5 3
1 0
2 0
-2 3 4 5
"
EOT;

        $strategy = new CNFcrowd();
        $builder = new OWLlinkBuilder();

        //$builder->insert_header(); // Without this, loading the DOMDocument
        // will throw error for the owl namespace
        $strategy->translate($json, $builder);
        //$builder->insert_footer();

        $actual = $builder->get_product();
        $actual = $actual->to_string();
        $this->assertXmlStringEqualsXmlString($expected, $actual,true);
    }



    ##
    # Test if translate works properly with binary roles many-to-many > 1
    public function testTranslateComplete(){
		$json = <<< EOT
    {
      "Datasheet": {
        "-id": "service functionalityError1",
        "service": {
          "name": "PG.1",
          "GlobalVariationPoint": {
            "OptionalVP": {
              "service": [
                { "name": "MM.13" },
                {
                  "name": "MM.10",
                  "GlobalVariationPoint": {
                    "AlternativeVP": {
                      "service": [
                        {
                          "name": "HI.13",
                          "GlobalVariationPoint": {
                            "MandatoryVP": {
                              "service": [
                                {
                                  "name": "MM.7",
                                  "uses": {
                                    "service": { "name": "PG.7" }
                                  }
                                },
                                {
                                  "name": "MM.2",
                                  "GlobalVariationPoint": {
                                    "AlternativeVP": {
                                      "service": [
                                        { "name": "HI.16" },
                                        {
                                          "name": "MM.11",
                                          "uses": {
                                            "service": { "name": "HI.6" }
                                          }
                                        },
                                        {
                                          "name": "PG.5",
                                          "uses": [
                                            {
                                              "service": {
                                                "name": "HI.7",
                                                "GlobalVariationPoint": {
                                                  "MandatoryVP": {
                                                    "service": [
                                                      {
                                                        "name": "PG.6",
                                                        "uses": {
                                                          "service": { "name": "HI.1" }
                                                        }
                                                      },
                                                      {
                                                        "name": "HI.2",
                                                        "uses": {
                                                          "service": { "name": "MM.12" }
                                                        }
                                                      }
                                                    ]
                                                  }
                                                },
                                                "uses": {
                                                  "service": { "name": "PG.8" }
                                                }
                                              }
                                            },
                                            {
                                              "service": { "name": "MM.9" }
                                            }
                                          ]
                                        }
                                      ]
                                    }
                                  },
                                  "uses": {
                                    "service": { "name": "MM.8" }
                                  }
                                }
                              ]
                            }
                          }
                        },
                        { "name": "MM.4" },
                        { "name": "HI.11" }
                      ]
                    }
                  },
                  "uses": {
                    "service": { "name": "HI.10" }
                  }
                }
              ]
            }
          }
        }
      }
    }

EOT;

        //TODO: Complete XML!
        $expected = <<< EOT
"p cnf 23 67
1 0
1 0
2 0
4 0
5 0
6 0
1 0
2 0
4 0
-6 7 0
-7 6 0
-10 11 0
-11 10 0
-14 15 0
-15 14 0
-16 17 0
-17 16 0
-13 14 0
-13 16 0
 -14 13 0
-16 13 0
-13 18 0
-18 13 0
-12 13 0
-13 12 0
-12 19 0
-19 12 0
-9 -10 0
-9 -12 0
-10 -9 0
-10 -12 0
-12 -9 0
-12 -10 0
-8 9 10 12 0
-8 9 -10 -12 0
-8 -9 -10 12 0
-8 -9 10 -12 0
 -9 8 0
-10 8 0
-12 8 0
-8 20 0
-20 8 0
-5 6 0
-5 8 0
 -6 5 0
-8 5 0
-5 -21 0
-5 -22 0
-21 -5 0
-21 -22 0
-22 -5 0
-22 -21 0
-4 5 21 22 0
-4 5 -21 -22 0
-4 -5 -21 22 0
-4 -5 21 -22 0
 -5 4 0
-21 4 0
-22 4 0
-4 23 0
-23 4 0
-2  3 4 0
 -3 2 0
-4 2 0
-1 2 0
-2 1 0
-6 -4 0
"
EOT;

        $strategy = new CNFcrowd();
        $builder = new OWLlinkBuilder();

        $builder->insert_header(); // Without this, loading the DOMDocument
        // will throw error for the owl namespace
        $strategy->translate($json, $builder);
        $builder->insert_footer();

        $actual = $builder->get_product();
        $actual = $actual->to_string();
        $this->assertXmlStringEqualsXmlString($expected, $actual,true);
    }
}
