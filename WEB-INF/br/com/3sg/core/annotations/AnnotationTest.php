<?php

/**
 * Classe AnnotationController
 * 
 * @AuthenticatedSession('class' = 'loginSession', 'attribute'='userId', 'redirect'='admin'),
 * @Dependencies(
 *      @Dependency('name' = 'file1', 'filepath' = '...'),
 *      @Dependency('name' = 'file1', 'filepath' = '...'),
 *      @Dependency('name' = 'file1', 'filepath' = '...')
 * ),
 * @ManagedController
 */
class AnnotationController {

    /** @Integer */
    private $value;

    public function __construct() {
        $this->value = '1';
        $annotationObject = new AnnotationObject($this);
        $classAnnotations = $annotationObject->getClassAnnotations();


        print_r($classAnnotations->toArray());
        die();
        if ($classAnnotations->contains("@ManagedController")) {
            echo 'This class has the annotation @ManagedController';
        }
        $authenticatedSession = $classAnnotations->get("@AuthenticatedSession");
        echo "Class: " . $authenticatedSession['class'] . "\n";
        echo "Attribute: " . $authenticatedSession['attribute'] . "\n";
        echo "Redirect: " . $authenticatedSession['redirect'] . "\n";
        $methodAnnotations = $annotationObject->getMethodAnnotations('loadContent');
        if ($methodAnnotations->contains("@Produces")) {
            $mimeType = $methodAnnotations->get("@Produces")[0];
            header("Content-Type: $mimeType; charset=utf-8");
        }
        $propertyAnnotatons = $annotationObject->getPropertyAnnotations('value');
        if ($propertyAnnotatons->contains("@Integer") && !is_integer($this->value)) {
            echo "Invalid Value!\n";
        }

        print_r($classAnnotations->toArray());
    }

    /** @Produces("text/xml") */
    public function loadContent() {
        return
                "<?xml version='1.0' standalone='yes'?> "
                . "<root>"
                . "    <content>Hello World!</content>"
                . "</root>";
    }

    //GETTERS AND SETTERS//
    function getValue() {
        return $this->value;
    }

    function setValue($value) {
        $this->value = $value;
    }

}
