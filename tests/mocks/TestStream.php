<?php
/**
 * Console utilities
 *
 * PHP versions 5.3
 *
 * @category  Console
 * @package   Console
 * @author    James Logsdon <jlogsdon@php.net>
 * @copyright 2010 James Logsdon
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://www.github.com/jlogsdon/php-cli-tools
 */

stream_wrapper_register('test', 'TestStream');

/**
 * Stream used for testing input and output
 *
 * @category  Console
 * @package   Console
 * @author    James Logsdon <jlogsdon@php.net>
 * @copyright 2010 James Logsdon
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @link      http://www.github.com/jlogsdon/php-cli-tools
 */
class TestStream
{
    protected $stream;

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return true;
    }

    public function stream_eof()
    {
        return false;
    }

    public function stream_write($data)
    {
        $this->stream .= $data;
    }

    public function stream_read($length)
    {
        $stream = $this->stream;
        $this->stream = '';
        return $stream;
    }
}

?>
