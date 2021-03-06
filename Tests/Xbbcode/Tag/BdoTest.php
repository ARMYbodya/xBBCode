<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class BdoTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [bdo=ltr]xBBCode[/bdo].';
        $result = 'test <bdo class="bb" dir="ltr">xBBCode</bdo>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
