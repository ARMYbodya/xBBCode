<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class QuoteTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [quote]xBBCode[/quote].';
        $result = 'test <blockquote class="bb bb_quote">xBBCode</blockquote>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());


        $text = 'test [quote=test]xBBCode[/quote].';
        $result = 'test <blockquote class="bb bb_quote"><div class="bb_quote_author">test:</div>xBBCode</blockquote>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());


        $text = 'test [quote author=test]xBBCode[/quote].';
        $result = 'test <blockquote class="bb bb_quote"><div class="bb_quote_author">test:</div>xBBCode</blockquote>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
