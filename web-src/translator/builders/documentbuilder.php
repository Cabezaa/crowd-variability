<?php 
/* 

   Copyright 2016 Giménez, Christian
   
   Author: Giménez, Christian   

   documentbuilder.php
   
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

namespace Wicom\Translator\Builders;

/**
   I set the common behaviour for every DocumentBuilder subclass.
 */
abstract class DocumentBuilder{
    protected $product = null;
       
    abstract public function insert_header();
    abstract public function insert_class($name, $col_attrs = []);
    /**
       Depending on the subclass, add an OWLlink text directly. 
     */
    public function insert_owllink($text){
    }
    abstract public function insert_footer();

    abstract public function insert_satisfiable();
    abstract public function insert_satisfiable_class($classname);
    
    public function get_product(){
        return $this->product;
    }
}
?>
