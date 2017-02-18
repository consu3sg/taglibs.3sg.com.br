<?php

/**
 * The <b>AnnotationObject</b> reports 
 * information about an annotation from classes, methods or properties
 * 
 * @package    br.com.3sg.core.annotations
 * @subpackage Core
 * @author     Guilherme Oliveira Toccacelli <consu3sg@gmail.com>
 */
class AnnotationObject {

    private $reflection;

    /**
     * Contructs an AnnotationObject
     * @param type $object
     */
    public function __construct($object) {
        $this->reflection = new ReflectionObject($object);
    }

    /**
     * Returns an instance of Class Annotation 
     * @param type $methodName
     * @return type
     * @throws Exception
     */
    function getMethodAnnotations($methodName) {
        if ($this->reflection->hasMethod($methodName)) {
            return AnnotationParser::parse($this->reflection->getMethod($methodName)->getDocComment());
        } else {
            throw new Exception("Method not found...");
        }
    }

    /**
     * Returns an instance of Class Annotation 
     * @param type $propertyName
     * @return type
     * @throws Exception
     */
    function getPropertyAnnotations($propertyName) {
        if ($this->reflection->hasProperty($propertyName)) {
            return AnnotationParser::parse($this->reflection->getProperty($propertyName)->getDocComment());
        } else {
            throw new Exception("Property not found...");
        }
    }

    /**
     * Returns an instance of Class Annotation
     * @return type
     */
    function getClassAnnotations() {
        return AnnotationParser::parse($this->reflection->getDocComment());
    }

}
