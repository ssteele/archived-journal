<?php
namespace App\Custom\Annotation;

use App\Custom\Parser\AnnotationParser;

class MentionAnnotation extends AbstractAnnotation
{
    private $type = 'mention';
    private $regex = '/\@([a-z]+)/';

    public function __construct()
    {
        $this->setRegex($this->regex);
        $this->setParser(new AnnotationParser($this));
    }

    /**
     * Post-processing of annotations after parsing from entry
     * @return array    Annotations
     */
    public function process(array $annotations)
    {
        return $this->removeDuplicates($annotations);
    }
}
