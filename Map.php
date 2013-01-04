<?php
/**
 * \YandexMaps\Map class file.
 */

namespace YandexMaps;

use CException as Exception,
	CComponent as Component;

/**
 * @property string $id
 * @property array $objects
 */
class Map extends Component
{
	/** @var array */
	public $state = array();
	/** @var array */
	public $options = array();

	/** @var string */
	private $_id;

	/** @var Placemark[] */
	private $_objects = array();

	/**
	 * @param string $id
	 * @param array $state
	 * @param array $options
	 */
	public function __construct($id = 'myMap', array $state = array(), array $options = array())
	{
		$this->_id = $id;
		$this->state = $state;
		$this->options = $options;
	}

	/**
	 * Clone object.
	 */
	function __clone()
	{
		$this->id = null;
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function getId()
	{
		if (empty($this->_id)) {
			throw new Exception('Empty map ID.');
		}
		return $this->_id;
	}

	/**
	 * @param string $id
	 */
	public function setId($id)
	{
		$this->_id = (string) $id;
	}

	public function getObjects()
	{
		return $this->_objects;
	}

	public function setObjects(array $objects = array())
	{
		$this->_objects = array();
		foreach ($objects as $object) {
			$this->addObject($object);
		}
	}

	public function addObject($object)
	{
		$this->_objects[] = $object;
	}
}