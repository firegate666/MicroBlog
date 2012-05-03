<?php

class SqliteStorage extends Storage
{
	/**
	 * 
	 * @var SQLite3
	 */
	private $sqlite;

	/* (non-PHPdoc)
	 * @see Storage::find()
	 */
	public function find(Model $empty_model, $attributes = array(), $order = array()) {
		// TODO Auto-generated method stub
	}

	/* (non-PHPdoc)
	 * @see Storage::__construct()
	 */
	public function __construct($connection_string)
	{
		$runtime_path = __DIR__ . '/../runtime/';
		$this->sqlite = new SQLite3($runtime_path . $connection_string, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
	}

	/*
	 * (non-PHPdoc) @see Storage::load()
	 */
	public function load(Model $empty_model)
	{
		// TODO Auto-generated method stub
	}

	/*
	 * (non-PHPdoc) @see Storage::save()
	 */
	public function save(Model $model)
	{
		// TODO Auto-generated method stub
	}
}
