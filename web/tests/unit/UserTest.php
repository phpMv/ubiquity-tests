<?php
use Classes\User;

require_once 'app\Classes/User.php';

/**
 * User test case.
 */
class UserTest extends \Codeception\Test\Unit {

	/**
	 *
	 * @var User
	 */
	private $user;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function _before() {
		$this->user = new User();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function _after() {
		$this->user = null;
	}


}

