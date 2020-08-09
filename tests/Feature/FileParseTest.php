<?php


namespace hala\Press\Tests;

use Carbon\Carbon;
use hala\Press\FileParser;

class FileParseTest extends TestCase
{
    /** @test */
    public function the_head_and_body_split()
    {
        $file = (new FileParser(__DIR__ . '/../files/testfile.md'));
        $data = $file->getRawData();

        $this->assertStringContainsString("description", $data[1]);
        $this->assertStringContainsString("title", $data[1]);
        $this->assertStringContainsString("Blog post body here", $data[2]);
    }

    /** @test */
    public function each_head_get_separated()
    {
        $file = (new FileParser(__DIR__ . '/../files/testfile.md'));
        $data = $file->getData();

        $this->assertEquals("<p>Description here</p>", $data['description']);
        $this->assertEquals("<p>My Title</p>", $data['title']);
    }


    /** @test */
    public function data_will_have_body()
    {
        $file = (new FileParser(__DIR__ . '/../files/testfile.md'));
        $data = $file->getData();

        $this->assertEquals("<h1>Heading</h1>\n<p>Blog post body here</p>", $data['body']);
    }

    /** @test */
    public function a_text_can_be_nested()
    {
        $file = (new FileParser("---\ntitle: My title\n---\nblog post body here"));
        $data = $file->getData();

        $this->assertEquals('<p>blog post body here</p>', $data['body']);


    }

    /** @test */
    public function date_get_parsed()
    {
        $file = (new FileParser("---\ndate: April 25 .1996\n---\n"));
        $data = $file->getData();

        $this->assertInstanceOf(Carbon::class, $data['date']);
        $this->assertEquals('04/25/1996', $data['date']->format('m/d/Y'));

    }

    /** @test */
    public function data_having_extra_attribute()
    {
        $file = (new FileParser("---\nauthor:Hala Almomani\n---\n"));
        $data = $file->getData();

        $this->assertEquals(json_encode(['author' => 'Hala Almomani']), $data['extra']);

    }

    /** @test */
    public function data_having_multi_extra_attribute()
    {
        $file = (new FileParser("---\nauthor:Hala Almomani\nimage:hala.jpg\n---\n"));
        $data = $file->getData();

        $this->assertEquals(json_encode(['author' => 'Hala Almomani','image'=>'hala.jpg']), $data['extra']);

    }
}