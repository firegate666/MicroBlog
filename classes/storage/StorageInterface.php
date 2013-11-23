<?php
/**
 * Created by PhpStorm.
 * User: marcobehnke
 * Date: 23.11.13
 * Time: 01:42
 */

namespace storage;

use Psr\Log\LoggerInterface;

interface StorageInterface {

	/**
	 * @param LoggerInterface $logger
	 * @return void
	 */
	public function setLogger(LoggerInterface $logger);

	/**
	 * load model
	 *
	 * @param Persistable $empty_model
	 * @return Persistable filled with data
	 */
	public function load(Persistable $empty_model);

	/**
	 * persist model
	 *
	 * @param Persistable $model
	 * @return boolean
	 */
	public function save(Persistable $model);

	/**
	 * find a set of models
	 *
	 * @param Persistable $empty_model
	 * @param array $attributes key/value with matching search criterias
	 * @param array $order key/value with attributes to order by as key and ASC or DESC as value
	 * @return Persistable[] array set of models
	 */
	public function find(Persistable $empty_model, $attributes = array(), $order = array());

	/**
	 * find all models
	 *
	 * @param Persistable $empty_model
	 * @param array $order key/value with attributes to order by as key and ASC or DESC as value
	 * @return array set of models
	 */
	public function findAll(Persistable $empty_model, $order = array());
}
