<?php 
/* 

   Copyright 2016 Giménez, Christian
   
   Author: Giménez, Christian   

   answer.php
   
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

namespace Wicom\Answers;

/**
   A reasoner answer summary.

   # Why there's satisfiable classes and unsatisfiable too?
   We need both, despite you may think that the complement of one set 
   is the other. 

   Maybe, the GUI won't have all the set of classes, or maybe one 
   class is a suggestion. The GUI is responsible to use one set, 
   another or both depending on its needs.

   So, for the purpose of being a bit RESTfull, it is good to have 
   both sets despite all.
*/
class Answer{

    protected $kb_satis = null;
    protected $satis_classes = [];
    protected $unsatis_classes = [];
    protected $links_sugges = [];
    protected $reasoner_input = null;
    protected $reasoner_output = null;

    function __construct(){
        $kb_satis = false;
        $satis_classes = [];
        $unsatis_classes = [];
        $links_sugges = [];
        $reasoner_input = "";
        $reasoner_output = "";
    }

    function set_kb_satis($bool){
        $this->kb_satis = $bool;
    }

    function add_satis_class($classname){
        array_push($this->satis_classes, $classname);
    }
    function add_unsatis_class($classname){
        array_push($this->unsatis_classes, $classname);
    }
    function add_link_sugges($linkname, $col_classnames){
        array_push($this->links_sugges,
                   ["name" => $linkname,
                    "classes" => $col_classnames]);
    }
    function set_reasoner_input($input_str){
        $this->reasoner_input = $input_str;
    }
    function set_reasoner_output($output_str){
        $this->reasoner_output = $output_str;
    }
    
    
    /**
       The string generated by to_json() is like the following.
       
       @code{.json}
       { 
           "satisfiable": {
               "kb" : true,
               "classes" : ["name1", "name2"]
           },
           "unsatisfiable": {
              	"classes" : ["name3", "name4"]
           },
           "suggestions" : {
              	"links" : [
              	    {"name" : "suggestion 1",
              	     "classes": ["classname 1", "classname 2"]}
              	]
           },
           "reasoner" : {
              	"input" : "STRING WITH REASONER INPUT",
              	"output" : "STRING WITH REASONER OUTPUT"
           }
       }
       @endcode
    */    
    function to_json(){
        return json_encode(
            ["satisfiable" => [
                "kb" => $this->kb_satis,
                "classes" => $this->satis_classes],
             "unsatisfiable" => [
                 "classes" => $this->unsatis_classes],
             "suggestions" => [
                 "links" => $this->links_sugges
             ],
             "reasoner" => [
                 "input" => $this->reasoner_input,
                 "output" => $this->reasoner_output]
            ]
        );
    }
}
