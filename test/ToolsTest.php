<?php

class ToolsTest extends PHPUnit_Framework_TestCase
{
	public function testTables()
	{
		$this->resetStreams();

		$suffix = \cli\Shell::isPiped() ? "_piped" : "";

		$headers = array('First Name', 'Last Name', 'City', 'State');
		$data = array(
			array('Maryam',   'Elliott',    'Elizabeth City',   'SD'),
			array('Jerry',    'Washington', 'Bessemer',         'ME'),
			array('Allegra',  'Hopkins',    'Altoona',          'ME'),
			array('Audrey',   'Oneil',      'Dalton',           'SK'),
		);

		$table = new \cli\Table();
		$table->setRenderer(new \cli\table\Ascii());
		$table->setHeaders($headers);
		$table->setRows($data);
		$table->display();

		$output = $this->getStreams();

		$this->assertEquals("", $output['errors']);
		$this->assertEquals(file_get_contents("test/output/table_1"), $output['contents']);

		$this->resetStreams();

		$table->sort(1);
		$table->display();

		$output = $this->getStreams();

		$this->assertEquals("", $output['errors']);
		$this->assertEquals(file_get_contents("test/output/table_2"), $output['contents']);

		$this->resetStreams();

		foreach ($data as $k => $v) {
			$data[$k] = array_combine(array("name", "surname", "city", "state"), $v);
		}

		$renderer = new \cli\table\Ascii();
		$renderer->setCharacters(array("corner" => "x", "line" => "=", "border" => "!"));

		$table = new \cli\Table($data);
		$table->setRenderer($renderer);
		$table->sort("surname");
		$table->display();

		$output = $this->getStreams();

		$this->assertEquals("", $output['errors']);
		$this->assertEquals(file_get_contents("test/output/table_3"), $output['contents']);

		$this->assertEquals("\033[0m", \cli\Colors::color("reset"));

		$this->assertEquals("foo\tbar", \cli\table\Tabular::row(array("foo", "bar")));
		$this->assertNull(\cli\table\Tabular::border());

	}

	private function resetStreams()
	{
		\cli\Streams::$out = tmpfile();
		\cli\Streams::$err = tmpfile();
	}

	private function getStreams()
	{
		$contents = $this->getStreamContents("output", \cli\Streams::$out);
		$errors = $this->getStreamContents("errors", \cli\Streams::$err);
		return compact("errors", "contents");
	}

	private function getStreamContents($name, $handle)
	{
		$output = "";
		fseek($handle, 0);
		while (($line = fgets($handle)) !== false) {
			$output .= $line;
		}
		if (!feof($handle)) {
			throw new Exception("Unexpected fgets failure with getStreams for '".$name."'");
		}
		fclose($handle);
		return $output;
	}
}
