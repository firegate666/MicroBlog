<?php

namespace storage;
use helper\Sanitizer;

/**
 * Create SQL where condition
 *
 * @package storage
 */
class WhereBuilder {

	/**
	 * @param array $attributes
	 * @param boolean $entryPoint
	 * @param boolean $or
	 * @throws \InvalidArgumentException
	 * @return string
	 */
	public function build($attributes, $entryPoint = true, $or = false) {
		// @TODO compare operator
		$condition = array();
		$query = '';
		$boolop = $or ? ' OR ' : ' AND ';

		foreach ($attributes as $column => $data) {
			if (is_string($column) && $column === '__NOT__' && is_array($data)) {
				$condition[] = 'NOT(' . $this->build($data, false) . ')';
			} else if ((is_numeric($column) || is_string($column) && $column === '__OR__') && is_array($data)) {
				$condition[] = '(' . $this->build($data, false, $column === '__OR__') . ')';
			} else if (is_string($column) && is_array($data)) {
				$cmp = ' IN ';

				if (!Sanitizer::validateAllInt($data)) {
					throw new \InvalidArgumentException('IN statement with strings is not supported yet');
				}

				$bind = '(' . implode(', ', array_map('intval', $data)) . ')';

				$condition[] = $column . $cmp . $bind;
			} else {
				$cmp = $data == null ? ' IS ' : ' = :';
				$bind = $data == null ? 'NULL' : $column;

				$condition[] = $column . $cmp . $bind;
			}
		}

		if (!empty($condition)) {
			$query .= implode($boolop, $condition);
			if ($entryPoint) {
				$query = ' WHERE ' . $query;
			}
		}
		return $query;
	}
}
