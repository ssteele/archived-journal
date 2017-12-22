<?php
namespace App\Custom\Annotation;

use App\Custom\Parser\ParserInterface;

interface AnnotationInterface
{
    public function getEntry();
    public function getRegex();
    public function extract();
    public function process(array $annotations);
}
