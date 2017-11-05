<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Base user class.
 *
 * @package truenorthng
 * @subpackage User
 */

final class User extends Object {
	private $model;

	public function __construct(G $G) {
		parent::__construct($G);
		$this->model = get_model('user');

		// Set immutable $data keys
		$this->data = array(
			'loggedin' => FALSE,
			'role' => 'anon',
			'acl' => NULL,
			'id' => 0,
			'username' => NULL,
			'password' => NULL,
			'created' => NULL,
			'status' => NULL,
			'last' => NULL,
			'passwordreset' => NULL
		);

		session('user', $this->data['id']);
		$this->data['acl'] = $this->G->getObject('acl', FALSE, $this->data['role']);
	}

	public function __set($name, $value) {
		if (array_key_exists($name, $this->data)) {
			$this->data[$name] = $value;
		}
	}

	public function login($user, $pass) {
		$return = FALSE;
		$result = $this->model->getOne(array($user, 1), array('username', 'status'));
		//echo "<pre>".print_r($result, TRUE)."</pre>";
		if (count($result) > 0) {
			if (Crypt::checkHashedString($pass, $result['password'])) {
				// Login matched!
				$return = TRUE;
				$this->loadUser($result['id']);
			}
		}
		return $return;
	}

	public function loadUser($id) {
		//$result = $this->model->getOne($id, 'id');
		$sql = 'SELECT `#__User`.*, `#__User_Role`.`role_id`, `roles`.`name` as `role_name` FROM `#__User`, `#__User_Role` INNER JOIN (SELECT * FROM `#__Acl_Roles`) AS `roles` ON `roles`.`id` = `#__User_Role`.`role_id` WHERE `#__User`.`id` = ? AND `#__User`.`id` = `#__User_Role`.`user_id`';
		$result = $this->model->execute($sql, $id);
		echo "<pre>LOADUSER:".print_r($result, TRUE)."</pre>";
		$this->loggedin = TRUE;
		$this->role = $result[0]['role_name'];
		$this->id = $id;
		$this->username = $result[0]['username'];
		$this->password = $result[0]['password'];
		$this->created = $result[0]['created'];
		$this->status = $result[0]['status'];
		$this->acl = new Acl($this->G, $this->role);
		session('user', $id);
	}

	public function save() {
		$this->model->save();
	}
}
