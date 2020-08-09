<?php

namespace hala\Press\Tests\Feature;

use hala\Press\MarkdownParser;
use hala\Press\Tests\TestCase;


class MarkdownTest extends TestCase
{
    /** @test */
    public function markdown()
    {
        $this->assertEquals('<p>Hello</p>', MarkdownParser::parse('Hello'));
    }
}