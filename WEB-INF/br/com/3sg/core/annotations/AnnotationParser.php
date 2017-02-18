<?php

/**
 * The <b>AnnotationParser</b> has some useful functions which 
 * can be used with an instance of AnnotationObject
 * 
 * @package    br.com.3sg.core.annotations
 * @subpackage Core
 * @author     Guilherme Oliveira Toccacelli <consu3sg@gmail.com>
 */
abstract class AnnotationParser {

    /**
     * Parses a docComment to an instance of Annotation
     * @param type $docComment
     * @return \Annotation
     */
    public static function parse($docComment) {
        $matches = [];
        preg_match('/\@[A-Z_a-z]*/', $docComment, $matches);
        if (empty($matches)) {
            return new Annotation();
        }
        $map = [];
        $contents = [];
        preg_match('/\\' . $matches[0] . '\(([^\.]+)\)/', $docComment, $contents);
        if (!empty($contents)) {
            $content = $contents[0];
            foreach (AnnotationParser::buildArray($content) as $value) {
                $map += $value;
            }
        }
        preg_match_all("/\@[A-Z_a-z]*[\s\r\n\t]/", $docComment, $matches);
        foreach ($matches[0] as $value) {
            $name = trim(str_replace(["\n", "\t"], '', $value));
            $map[$name] = true;
        }
        return new Annotation($map);
    }

    /**
     * Converts the Annotations to an Array representation
     * @param type $contents
     * @return type
     */
    private static function buildArray($contents) {
        $matches = [];
        preg_match_all('/(?:[^,(]|\([^)]*\))+/', $contents, $matches); //Matches everything except comma
        $string = implode(',', $matches[0]);
        $eval = strtr($string, [
            "=" => "=>",
            '(' => '"=>[',
            ')' => ']]',
            '@' => '["@',
            "*" => ""
        ]);
        eval("\$eval = [$eval];");
        return $eval;
    }

    /**
     * Tells if there is any annotation inside that docComment
     * @param type $docComment
     * @return type
     */
    public static function containsAnnotations($docComment) {
        return preg_match('/\@[A-Z_a-z]*/', $docComment);
    }

}
