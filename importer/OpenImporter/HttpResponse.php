<?php
/**
 * @name      OpenImporter
 * @copyright OpenImporter contributors
 * @license   BSD http://opensource.org/licenses/BSD-3-Clause
 *
 * @version 2.0 Alpha
 */

namespace OpenImporter\Core;

/**
 * This should contain the data used by the template.
 */
class HttpResponse extends ValuesBag
{
	/**
	 * The HTTP response header object.
	 * @var ResponseHeader
	 */
	protected $headers = null;

	/**
	 * The "translator" (i.e. the Lang object)
	 * @var object
	 */
	public $lng = null;

	/**
	 * Error messages occurred during the import process.
	 * @var string[]
	 */
	protected $error_params = array();

	/**
	 * Constructor
	 *
	 * @param ResponseHeader $headers
	 */
	public function __construct(ResponseHeader $headers)
	{
		$this->headers = $headers;
	}

	/**
	 * Sends out the headers to php using header function
	 */
	public function sendHeaders()
	{
		foreach ($this->headers->get() as $val)
			header($val);
	}

	/**
	 * Wrapper for ResponseHeader::set
	 *
	 * @param string $key
	 * @param string $val
	 */
	public function addHeader($key, $val)
	{
		$this->headers->set($key, $val);
	}

	/**
	 * Errors happen, this function adds a new one to the list.
	 *
	 * @param mixed|mixed[] $error_message
	 */
	public function addErrorParam($error_message)
	{
		$this->error_params[] = $error_message;
	}

	/**
	 * Returns the error messages sprintf'ed if necessary
	 */
	public function getErrors()
	{
		$return = array();
		foreach ($this->error_params as $msg)
		{
			if (is_array($msg))
				$return[] = sprintf($msg[0], $msg[1]);
			else
				$return[] = $msg;
		}

		return $return;
	}
}