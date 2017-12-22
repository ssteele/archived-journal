<?php
namespace App\Custom\Annotation;

use App\Custom\Parser\AnnotationParser;

class TagAnnotation extends AbstractAnnotation
{
    private $type = 'tag';
    private $regex = '/\#([^\s,.;?!]+)/';

    public function __construct()
    {
        $this->setRegex($this->regex);
        $this->setParser(new AnnotationParser($this));
    }
}
