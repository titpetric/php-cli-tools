<?php

class ToolsTest extends PHPUnit_Framework_TestCase
{
	public function testTables()
	{
		$this->resetStreams();

		$suffix = \cli\Shell::isPiped() ? "_piped" : "";
		$this->assertTrue(is_numeric($columns = \cli\Shell::columns()));

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

		// test output

		$this->resetStreams();

		\cli\out("  \\cli\\out sends output to STDOUT\n");
		\cli\out("  It does not automatically append a new line\n");
		\cli\out("  It does accept any number of %s which are then %s to %s for formatting\n", 'arguments', 'passed', 'sprintf');
		\cli\out("  Alternatively, {:a} can use an {:b} as the second argument.\n\n", array('a' => 'you', 'b' => 'array'));

		\cli\err('  \cli\err sends output to STDERR');
		\cli\err('  It does automatically append a new line');
		\cli\err('  It does accept any number of %s which are then %s to %s for formatting', 'arguments', 'passed', 'sprintf');
		\cli\err("  Alternatively, {:a} can use an {:b} as the second argument.\n", array('a' => 'you', 'b' => 'array'));

		\cli\line('  \cli\line forwards to \cli\out for output');
		\cli\line('  It does automatically append a new line');
		\cli\line('  It does accept any number of %s which are then %s to %s for formatting', 'arguments', 'passed', 'sprintf');
		\cli\line("  Alternatively, {:a} can use an {:b} as the second argument.\n", array('a' => 'you', 'b' => 'array'));

		$output = $this->getStreams();

		$this->assertEquals(file_get_contents("test/output/out_errors"), $output['errors']);
		$this->assertEquals(file_get_contents("test/output/out_contents"), $output['contents']);

		$string = "";
		$string .= \cli\render('  \cli\err sends output to STDERR'."\n");
		$string .= \cli\render('  It does automatically append a new line'."\n");
		$string .= \cli\render('  It does accept any number of %s which are then %s to %s for formatting'."\n", 'arguments', 'passed', 'sprintf');
		$string .= \cli\render("  Alternatively, {:a} can use an {:b} as the second argument.\n\n", array('a' => 'you', 'b' => 'array'));

		$this->assertEquals(file_get_contents("test/output/out_errors"), $string);

		$this->resetStreams();

		$in = tmpfile();
		fputs($in, "quit\n");
		fseek($in, 0);

		\cli\Streams::setStream("in", $in);

		$line = \cli\prompt("prompt", false, "# ");

		$output = $this->getStreams();

		$this->assertEquals("quit", $line);
		$this->assertEquals("", $output['errors']);
		$this->assertEquals("prompt# ", $output['contents']);

		fseek($in, 0);

		$this->assertEquals("quit", \cli\input());

		fclose($in);
	}

	private function resetStreams()
	{
		\cli\Streams::setStream("out", tmpfile());
		\cli\Streams::setStream("err", tmpfile());
	}

	private function getStreams()
	{
		$contents = $this->getStreamContents("output", \cli\Streams::getStream("out"));
		$errors = $this->getStreamContents("errors", \cli\Streams::getStream("err"));
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
