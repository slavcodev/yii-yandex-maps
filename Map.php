<?php
/**
 * \YandexMaps\Map class file.
 */

namespace YandexMaps;

use YandexMaps\Interfaces;

use CException as Exception;

/**
 * @property string $id
 * @property array $objects
 */
class Map extends JavaScript implements Interfaces\GeoObjectCollection
{
	const CONTROL_MAP_TOOLS = 'mapTools';
	const CONTROL_MINI_MAP = 'miniMap';
	const CONTROL_SCALE_LINE = 'scaleLine';
	const CONTROL_SEARCH = 'searchControl';
	const CONTROL_TRAFFIC = 'trafficControl';
	const CONTROL_TYPE_SELECTOR = 'typeSelector';
	const CONTROL_ZOOM = 'zoomControl';
	const CONTROL_SMALL_ZOOM = 'smallZoomControl';

	const BEHAVIOR_DEFAULT = 'default';
	const BEHAVIOR_DRAG = 'drag';
	const BEHAVIOR_SCROLL_ZOOM = 'scrollZoom';
	const BEHAVIOR_CLICK_ZOOM = 'dblClickZoom';
	const BEHAVIOR_MULTI_TOUCH = 'multiTouch';
	const BEHAVIOR_RIGHT_MAGNIFIER = 'rightMouseButtonMagnifier';
	const BEHAVIOR_LEFT_MAGNIFIER = 'leftMouseButtonMagnifier';
	const BEHAVIOR_RULER = 'ruler';
	const BEHAVIOR_ROUTE_EDITOR = 'routeEditor';

	/** @var array */
	public $state = array();
	/** @var array */
	public $options = array();

	/** @var array */
	public $controls = array();
	/** @var array */
	public $events = array();

	/** @var string */
	private $_id;
	/** @var array */
	private $_objects = array();

	/**
	 * @param string $id
	 * @param array $state
	 * @param array $options
	 */
	public function __construct($id = 'myMap', array $state = array(), array $options = array())
	{
		$this->setId($id);
		$this->state = $state;
		if (isset($options['controls'])) {
			$this->controls = $options['controls'];
			unset($options['controls']);
		}
		if (isset($options['events'])) {
			$this->events = $options['events'];
			unset($options['events']);
		}
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
	 * @param string $code
	 * @throws Exception
	 */
	final public function setCode($code)
	{
		throw new Exception('Cannot change code directly.');
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

	/**
	 * @return array
	 */
	public function getObjects()
	{
		return $this->_objects;
	}

	/**
	 * @param array $objects
	 */
	public function setObjects(array $objects = array())
	{
		$this->_objects = array();
		foreach ($objects as $object) {
			$this->addObject($object);
		}
	}

	/**
	 * @param mixed $object
	 */
	public function addObject($object)
	{
		$this->_objects[] = $object;
	}
}