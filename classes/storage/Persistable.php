<?php

namespace storage;

interface Persistable {

	/**
	 * validate inner state of persistable
	 *
	 * @return boolean
	 */
	public function isValid();

}
