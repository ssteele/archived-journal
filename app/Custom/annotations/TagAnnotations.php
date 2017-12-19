<?php
namespace App\Custom\Annotations;

use App\Custom\Parser\AnnotationParser;

class TagAnnotations extends AbstractAnnotations
{
    private $type = 'tags';
    private $regex = '/\#([^\s,.;?!]+)/';

    public function __construct()
    {
        $this->setRegex($this->regex);
        $this->setParser(new AnnotationParser($this));
    }
}
