<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * ACL model.
 *
 * @package    truenorthng
 * @subpackage Permissions
 */

class Model_Acl extends Model {
	public function __set($name, $value) {
		$this->data[$name] = $value;
	}

	public function loadRole($role) {
		$return = array();
		if (is_int($role)) {
			$sql = 'SELECT * FROM `' . $this->table . '_Roles` WHERE `status` = 1 AND `level` = ?';
		} else {
			$sql = 'SELECT * FROM `' . $this->table . '_Roles` WHERE `status` = 1 AND `name` = ?';
		}                
		$role = $this->execute($sql, $role);
                
		if (count($role) == 1) {
			$return = $role[0];
		}
		return $return;
	}

	public function loadRoles($levels = FALSE) {
		$return = array();
		$sql = 'SELECT * from `' . $this->table . '_Roles` WHERE `status` = 1 ORDER BY `level` DESC, `name`';
		$params = array();
		$this->G->db->executeQuery($sql, $params);
		if ($this->G->db->numRows() > 0) {
			while ($setting = $this->G->db->getRows()) {
				if ($levels == true){
					$return[$setting['id']] = $setting;
				} else {
					$return[$setting['id']] = $setting['name'];
				}
			}
		}
		return $return;
	}

	public function saveRole() {
		if (isset($this->data['id']) && $this->data['id'] != '') {
			// Update existing role permissions.
			$this->G->db->updateRecords($this->table . '_Roles', array(
				'id' => $this->data['id'],
				'status' => $this->data['status'],
				'name' => $this->data['name']
			), array('id' => $this->data['id']));
			$this->G->db->deleteRecords($this->table, array('role_id' => $this->data['id']));
			$perms = $this->loadPerms();
			foreach ($perms as $id => $perm) {
				if (array_key_exists($id, $this->data)) {
					$this->G->db->insertRecords($this->table, array('role_id' => $this->data['id'], 'perm_id' => $id));
				}
			}
		} else {
			// Add new role permissions.
			$this->data['id'] = $this->G->db->insertRecords($this->table . '_Roles', array(
				'id' => 0,
				'created' => time(),
				'status' => $this->data['status'],
				'name' => $this->data['name']
			));
			//echo "ID: ".$this->data['id']."<br>";
			$perms = $this->loadPerms();
			foreach ($perms as $id => $perm) {
				if (array_key_exists($id, $this->data)) {
					$this->G->db->insertRecords($this->table, array('role_id' => $this->data['id'], 'perm_id' => $id));
				}
			}
		}
	}

	public function loadPerms() {
		$return = array();
		$sql = 'SELECT * from ' . $this->table . '_Perms WHERE `status` = 1 ORDER BY `aid`';
		$params = array();
		$this->G->db->executeQuery($sql, $params);
		if ($this->G->db->numRows() > 0) {
			while ($setting = $this->G->db->getRows()) {
				$return[$setting['id']] = $setting['name'];
			}
		}
		return $return;
	}

	public function loadAcl($role) {
		$return = array();
		$sql = 'SELECT ' . $this->table . '_Perms.id as `id`, ' . $this->table . '_Perms.name as `name` FROM ' . $this->table . '_Perms, ' . $this->table . ' INNER JOIN ' . $this->table . '_Roles ON ' . $this->table . '.role_id = ' . $this->table . '_Roles.id WHERE ' . $this->table . '_Roles.name = ? AND ' . $this->table . '.perm_id = ' . $this->table . '_Perms.id ORDER BY ' . $this->table . '_Perms.aid';
		$params = array($role);
		$this->G->db->executeQuery($sql, $params);
		if ($this->G->db->numRows() > 0) {
			while ($setting = $this->G->db->getRows()) {
				$return[$setting['id']] = $setting['name'];
			}
		}
		return $return;
	}
}
