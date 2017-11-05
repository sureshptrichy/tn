<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Extendable Controller class.
 *
 * @package    truenorthng
 * @subpackage Controller
 */

abstract class Controller {
	protected $G;
	protected $model;
	protected $name;
	private $flash = array(
		'success' => array(),
		'info' => array(),
		'warning' => array(),
		'danger' => array()
	);

	/**
	 * The text used in the HTML title tag.
	 * @var string
	 */
	public $pageTitle;

	/**
	 * Array of default permission names required to view the controller method. These are also used by the menu
	 * generator to decide what can be seen.
	 * @var array
	 */
	public $permission = array('authenticated');

	/**
	 * "name" is the name of the current page, as shown in the menu system.
	 * "viewName" is the filename of the view to use.
	 * "main_order" is the order this item appears in the main menu system (optional).
	 * "sidebar_order" is the order this item appears in the sidebar menu system (optional).
	 * @var array ('name' => 'Page Name', 'view' => 'viewName')
	 */
	public $route = array();

	/**
	 * Show or ignore the main page navigation menu.
	 * @var bool
	 */
	public $showPageNav = TRUE;

	public $view = '';

	/**
	 * Which Types of objects to ignore when generating the Range drop-downs in the sidebar.
	 * @var array
	 */
	public $ignoreDatesFor = array(
		'Competency'
	);

	public function __construct(G $G) {
		$this->name = strtolower(substr(get_class($this), 11));
		$this->G = $G;
		$this->G->content = '';
		if (!isset($this->G->viewVariables) || !is_array($this->G->viewVariables)) {
			$this->G->viewVariables = array();
		}
		$this->setView($this->name);
	}

	protected function config($method = NULL) {
		// Method-specific configs are handled here since they don't require a menu item.
		if ($method !== NULL) {
			$method = 'config_' . strtolower($method);
			if (method_exists($this, $method)) {
				$this->$method();
			}
		}
		if (array_key_exists('view', $this->route) && isset($this->route['view']) && $this->route['view'] != '') {
			$this->setView($this->route['view']);
		}
		return $this->requirePermission($this->permission);
	}

	public function __toString() {
		return $this->view;
	}

	/**
	 * Sets the main view for this controller.
	 *
	 * @param string $view
	 */
	protected function setView($view) {
		$this->view = $view;
		$this->G->view = $view;
	}

	/**
	 * Sets the default model for this controller.
	 *
	 * @param string $model
	 */
	protected function setModel($model) {
		$this->model = get_model($model);
	}

	/**
	 * Sets which files to display. If $style is NULL, 'header' and 'footer'
	 * are loaded around the view. If $style is FALSE, the view is loaded
	 * alone. If $style is a string, it is appended to the filenames for
	 * 'header' and 'footer' with an '_' character.
	 *
	 * @param mixed $style
	 */
	protected function display($style = NULL) {
		if ($this->G->url->ajax) {
			$style = FALSE;
		}
		if ($style === FALSE) {
			$this->addFiles($this->view);
		} else {
			if (isset($style)) {
				$style = '_' . $style;
			}
			$this->addFiles('header' . $style, $this->view, 'footer' . $style);
		}

		// Setup default variables available to the front-end files.
		tpl_set('pageTitle', $this->pageTitle);
		tpl_set('mainMenu', menu($this->G, 'main'));
		tpl_set('sidebarSelector', breadcrumbSelector($this->G, 'sidebar'));
		tpl_set('rangeSelector', rangeSelector($this->G, 'range'));
		tpl_set('revision', $this->G->revision);
		tpl_set('showPageNav', $this->showPageNav);
		tpl_set('currentUrl', $this->G->url);
		tpl_set('flash', session('flash'));
		session_del('flash');
		tpl_set('mainSidebar', menu($this->G, 'sidebar'));
		$url = $this->G->url->getUrl(TRUE);
		$bodyClass = array();
		for ($i = 0, $c = count($url); $i < $c; $i++) {
			for ($j = $i, $d = count($url); $j < $d; $j++) {
				$bodyClass[$j][] = $url[$i];
			}
		}
		for ($i = 0, $c = count($bodyClass); $i < $c; $i++) {
			$bodyClass[$i] = 'tn-' . implode('-', $bodyClass[$i]);
		}
		$bodyClass = implode(' ', $bodyClass);
		if ($bodyClass == 'tn-') {
			$bodyClass = 'tn-' . $this->G->defaultController;
		}
		tpl_set('bodyClass', $bodyClass);
		tpl_set('currentUser', $this->G->user);
	}

	/**
	 * Add a list of files to the content of the current page.
	 *
	 * @param string
	 */
	protected function addFiles() {
		$files = func_get_args();
		$content = array();
		foreach ($files as $file) {
			if (file_exists(THEME_PATH . $file . '.php')) {
				$content[] = THEME_PATH . $file . '.php';
			} else {
				if (DEBUG) {
					echo "<p>File FAIL: " . THEME_PATH . $file . ".php</p>\n";
				}
			}
		}
		$this->G->content = $content;
	}

	/**
	 * Checks if this user instance has the requested permission(s).
	 *
	 * @param string|array $level A named permission or comma-delimited list of permissions to test for.
	 *
	 * @returns bool
	 */
	protected function requirePermission($level = NULL) {
		return user_has($level);
	}
}
