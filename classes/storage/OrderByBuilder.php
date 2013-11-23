<?php

namespace storage;

use ReflectionClass;

/**
 * Create SQL order by clause
 *
 * @package storage
 */
class OrderByBuilder {

	/**
	 * @param array $order
	 * @param Persistable $emptyModel
	 * @return string
	 */
	public function build(array $order, Persistable $emptyModel) {
		if (empty($order)) {
			return ' ORDER BY id DESC';
		}

		$orders = array();
		$query = '';
		$reflectedClass = new ReflectionClass($emptyModel);
		foreach ($order as $orderField => $orderDirection) {
			if ($reflectedClass->hasProperty($orderField)) // @todo check if property is valid column
			{
				$orders[] = $orderField
					. ' '
					. (in_array(strtoupper($orderDirection), array('ASC', 'DESC')) ? $orderDirection : 'DESC');
			}
			// TODO log invalid attributes
		}
		if (!empty($orders)) {
			$query .= ' ORDER BY ' . implode(', ', $orders);
		}
		return $query;
	}


}
