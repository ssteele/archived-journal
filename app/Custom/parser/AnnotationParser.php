<?php
namespace App\Custom\Parser;

use App\Custom\Annotations\AnnotationsInterface;

class AnnotationParser implements ParserInterface
{
    private $annotation;

    public function __construct($annotation)
    {
        $this->setAnnotation($annotation);
    }

    public function setAnnotation(AnnotationsInterface $annotation)
    {
        $this->annotation = $annotation;
    }

    /**
     * Parse annotations from an entry
     * @return array    Annotations or empty array if none found
     */
    public function parse()
    {
        $string = $this->annotation->getEntry();
        $regex = $this->annotation->getRegex();
        preg_match_all($regex, $string, $matches);

        return array_pop($matches);
    }
}
