<?php
namespace App\Custom\Annotations;

use App\Custom\Parser\ParserInterface;

class AbstractAnnotations implements AnnotationsInterface
{
    private $type;
    private $entry;
    private $regex;
    private $parser;
    private $annotations = [];

    public function setEntry($entry)
    {
        $this->entry = $entry;
    }

    public function getEntry()
    {
        return $this->entry;
    }

    public function setRegex($regex)
    {
        $this->regex = $regex;
    }

    public function getRegex()
    {
        return $this->regex;
    }

    protected function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse annotations and provide post-process hook
     * @return array    Annotations
     */
    public function extract()
    {
        $this->annotations = $this->parser->parse();
        $this->annotations = $this->process($this->annotations);

        return $this->annotations;
    }

    /**
     * Post-processing of annotations after parsing from entry
     * @return array    Annotations
     */
    public function process(array $annotations)
    {
        return $annotations;
    }

    /**
     * Remove duplicate annotations
     * @param  array  $annotations    Annotations
     * @return array                  Unique annotations
     */
    protected function removeDuplicates(array $annotations)
    {
        return array_unique($annotations);
    }
}
