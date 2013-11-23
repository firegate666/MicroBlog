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
	 * @param string $order
	 * @param Persistable $empty_model
	 * @return string
	 */
	public function build($order, Persistable $empty_model) {
		if (empty($order))
		{
			return ' ORDER BY id DESC';
		}

		$orders = array();
		$query = '';
		$refl_class = new ReflectionClass($empty_model);
		foreach($order as $orderfield => $orderdirection)
		{
			if ($refl_class->hasProperty($orderfield)) // @todo check if property is valid column
			{
				$orders[] = $orderfield
					. ' '
					. (in_array(strtoupper($orderdirection), array('ASC', 'DESC')) ? $orderdirection : 'DESC')
				;
			}
			// TODO log invalid attributes
		}
		if (!empty($orders)) {
			$query .= ' ORDER BY ' . implode(', ', $orders);
		}
		return $query;
	}


}
