<?php

use App\Custom\Annotations\TagAnnotations;
use App\Custom\Parser\AnnotationParser;

class AnnotationParserTest extends TestCase
{
    private $tagAnnotations;

    private function prepareTags($input)
    {
        $this->tagAnnotations = new TagAnnotations();
        $this->tagAnnotations->setEntry($input);
    }

    public function testOneTag()
    {
        $input = 'lorem #foo ipsum';
        $expected = ['foo'];

        $this->prepareTags($input);
        $this->assertEquals($expected, $this->tagAnnotations->extract());
    }

    public function testTwoTags()
    {
        $input = 'lorem #foo ipsum #bar dolor';
        $expected = ['foo', 'bar'];

        $this->prepareTags($input);
        $this->assertEquals($expected, $this->tagAnnotations->extract());
    }

    public function testThreeTags()
    {
        $input = 'lorem #foo ipsum #bar #baz dolor';
        $expected = ['foo', 'bar', 'baz'];

        $this->prepareTags($input);
        $this->assertEquals($expected, $this->tagAnnotations->extract());
    }

    public function testDuplicateTags()
    {
        $input = 'lorem #foo ipsum #bar #foo dolor';
        $expected = ['foo', 'bar', 'foo'];

        $this->prepareTags($input);
        $this->assertEquals($expected, $this->tagAnnotations->extract());
    }

    public function testLoremIpsumTags()
    {
        $input = 'Excepteur cillum nisi consectetur do esse <@eiusmod adipisicing dolor> id #laboris anim in laborum ex sed dolor et; Lorem ipsum dolore nostrud occaecat quis ex minim id aliqua proident nulla culpa excepteur, @Lorem ipsum quis officia reprehenderit amet ut sed incididunt elit quis in id nisi nostrud aute aliqua in, Ea sunt dolore cillum eu exercitation sunt ad eu laboris ut <m: nulla minim>, Ad velit in exercitation #excepteur eu in quis minim deserunt et amet <i: exercitation dolor deserunt> occaecat cillum; Occaecat ut cillum tempor incididunt elit dolore mollit cillum cupidatat minim adipisicing consectetur sunt sed nostrud, Nisi eu amet quis sint id ad enim esse aliqua mollit eu dolor non in minim qui, Occaecat eu culpa #sint mollit <h: sint id eiusmod> in ut elit; @Lorem ipsum voluptate non dolore ea commodo ut ullamco non velit @elit nostrud non irure sunt veniam <cillum sit occaecat id>. Ex cillum voluptate enim nulla velit magna sint voluptate voluptate in aliqua cillum! Lorem ipsum pariatur <e: #laboris excepteur dolor in> voluptate pariatur non incididunt culpa velit, Lorem ipsum fugiat reprehenderit do dolor nulla incididunt in elit tempor dolore dolore adipisicing <m: aliqua laborum deserunt> tempor voluptate excepteur minim; Aliquip commodo #sint et consectetur labore in adipisicing <nulla sed dolore> <reprehenderit veniam cupidatat> ad non irure non do, Voluptate veniam qui reprehenderit ullamco sed ut officia ut sed ex qui proident magna incididunt, <i: Tempor deserunt veniam> proident commodo sunt consequat laborum laboris <h: reprehenderit magna occaecat> sunt; Sit dolor ut in sit sed deserunt <e: officia amet aute>, Dolor ut non consectetur dolor @eiusmod id pariatur fugiat esse occaecat culpa tempor qui ut, Dolore voluptate magna amet ut amet aliquip reprehenderit culpa proident ullamco in est; Culpa ea qui aute ut nulla et in culpa ut, Non tempor occaecat esse #sint labore esse veniam ad amet est ullamco, @Lorem ipsum magna voluptate exercitation veniam #duis et non deserunt eiusmod in @amet velit nostrud';
        $expected = ['laboris', 'excepteur', 'sint', 'laboris', 'sint', 'sint', 'duis'];

        $this->prepareTags($input);
        $this->assertEquals($expected, $this->tagAnnotations->extract());
    }
}
