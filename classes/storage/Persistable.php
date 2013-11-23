<?php

namespace storage;

interface Persistable {

	/**
	 * validate inner state of persistable
	 *
	 * @return boolean
	 */
	public function isValid();

	/**
	 * @return integer
	 */
	public function getId();

	/**
	 * @param integer $new_id
	 * @return void
	 */
	public function setId($new_id);

}
