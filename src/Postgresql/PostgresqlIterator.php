<?php
/**
 * Part of the Joomla Framework Database Package
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Database\Postgresql;

use Joomla\Database\DatabaseIterator;

/**
 * PostgreSQL Database Iterator.
 *
 * @since  1.0
 */
class PostgresqlIterator extends DatabaseIterator
{
	/**
	 * Get the number of rows in the result set for the executed SQL given by the cursor.
	 *
	 * @return  integer  The number of rows in the result set.
	 *
	 * @since   1.0
	 * @see     Countable::count()
	 */
	public function count()
	{
		if ($this->cursor !== false)
		{
			if (pg_num_rows($this->cursor) > 0)
			{
				return pg_num_rows($this->cursor);
			}
			elseif (pg_affected_rows($this->cursor) > 0)
			{
				return pg_affected_rows($this->cursor);
			}
		}

		return 0;
	}

	/**
	 * Method to fetch a row from the result set cursor as an object.
	 *
	 * @return  mixed   Either the next row from the result set or false if there are no more rows.
	 *
	 * @since   1.0
	 */
	protected function fetchObject()
	{
		return pg_fetch_object($this->cursor, null, $this->class);
	}

	/**
	 * Method to free up the memory used for the result set.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function freeResult()
	{
		pg_free_result($this->cursor);
	}
}
