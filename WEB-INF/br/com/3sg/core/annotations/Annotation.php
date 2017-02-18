<?php

/**
 * The <b>Annotation</b> represents a group of annotaions as a complex array
 * 
 * @package    br.com.3sg.core.annotations
 * @subpackage Core
 * @author     Guilherme Oliveira Toccacelli <consu3sg@gmail.com>
 */
class Annotation {

    private $map;

    public function __construct($map = []) {
        $this->map = $map;
    }

    /**
     * Returns all annotations as an array
     * @return type
     */
    public function toArray() {
        return $this->map;
    }

    /**
     * Returns the matching object in the annotation array
     * @param type $name
     * @return type
     */
    public function get($name) {
        return $this->map[$name];
    }

    /**
     * Tells if the annotation exists
     * @param type $name
     * @return type
     */
    public function contains($name) {
        return isset($this->map[$name]);
    }

}
