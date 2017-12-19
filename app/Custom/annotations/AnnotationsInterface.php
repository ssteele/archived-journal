<?php
namespace App\Custom\Annotations;

use App\Custom\Parser\ParserInterface;

interface AnnotationsInterface
{
    public function getEntry();
    public function getRegex();
    public function extract();
    public function process(array $annotations);
}
