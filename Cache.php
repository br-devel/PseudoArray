<?php

class EtuDev_PseudoArray_Cache {

	/**
	 * @var EtuDev_PseudoArray_Cache
	 */
	static protected $instansce;

	/**
	 * @return EtuDev_PseudoArray_Cache
	 */
	static public function getInstance() {
		if (!static::$instansce) {
			static::$instansce = new EtuDev_PseudoArray_Cache();
		}

		return static::$instansce;
	}

	protected $enabled = true;

	public function isEnabled() {
		return $this->enabled && EtuDev_Cache_Driver_APC::getInstance()->isEnabled();
	}

	public function enable() {
		$this->enabled = true;
	}

	public function disable() {
		$this->enabled = false;
	}

	protected $prefix;

	protected function getPrefix() {
		if (!$this->prefix) {
			$this->prefix = 'psa';
		}
		return $this->prefix;
	}

	protected function completeKey($k) {
		return $this->getPrefix() . $k;
	}

	public function write($k, $v, $time_to_live = 86400) {
		$key = $this->completeKey($k);
		return EtuDev_Cache_Driver_APC::getInstance()->set($key, $v, $time_to_live);
	}

	public function get($k) {
		return EtuDev_Cache_Driver_APC::getInstance()->get($this->completeKey($k));
	}

	public function deleteAll() {
		return EtuDev_Cache_Driver_APC::deletePrefix($this->getPrefix());
	}

}