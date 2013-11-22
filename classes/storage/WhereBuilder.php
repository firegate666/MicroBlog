<?php

namespace storage;

/**
 * Create SQL where condition
 *
 * @package storage
 */
class WhereBuilder {

	/**
	 * @param array $attributes
	 * @return string
	 */
	public function build($attributes) {
		// @TODO compare operator
		$condition = array();
		$query = '';
		foreach ($attributes as $column => $data)
		{
			$cmp = $data == null ? ' IS ' : '= :';
			$bind =  $data == null ? 'NULL' : $data;

			$condition[] = $column . $cmp . $bind;
		}

		if (!empty($condition))
		{
			$query .= ' WHERE ' . implode(' AND ', $condition);
		}
		return $query;
	}
}
