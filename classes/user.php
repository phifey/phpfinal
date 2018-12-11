<?php
class User {
	public $_error = false;
	private $_hash;
	private $_code;
	private $_errorMsg = "";
	private $_successMsg = "";
  private $_rows = array();
	private $_user;
	private $_pass;
	private $_phone;
	private $_email;
	private $_username;
	private $_passwordVerify;
	protected $_table;
	protected $_db;

	public function __construct(PDO $db, $table, $user = '', $pass = '', $phone = '', $email = '', $username = '', $code = '', $rows = '')
	{
		$this->_db = $db;
		$this->_user = $user;
		$this->_pass = $pass;
		$this->_phone = $phone;
		$this->_email = $email;
		$this->_username = $username;
    $this->_table = $table;
    $this->_rows = $rows;
		$this->_code = $code;
	}

	public function verify($email = '', $code = '')
	{
		if($email == '' && $code == '')
		{
			if($this->_emailVerify($this->_email, $this->_code))
			{
				return true;
			}
			$this->_error = true;
			$this->_errorMsg = "Couldn't validate information";
			return false;
		}
		else if($this->_emailVerify($email, $code))
		{
			return true;
		}
		$this->_error = true;
		$this->_errorMsg = "Couldn't validate information";
		return false;
	}

	public function requestPassword($email = '')
	{
		if($email == '')
		{
			if($this->_isEmailExist($this->_email))
			{
				return true;
			}
			return false;
		} else if($this->_isEmailExist($email))
		{
			return true;
		}
		return false;
	}

	public function register()
	{
		if($this->_userExists($this->_username,$this->_email))
		{
			if($this->_registerUser($this->_user, $this->_pass, $this->_phone, $this->_email, $this->_username, $this->_code))
			{
				return true;
			}
			else {
				$this->_error = true;
				$this->_errorMsg = "Something went wrong.";
				return false;
			}
		}
		else {
			$this->_error = true;
			$this->_errorMsg = "Username and(or) email already exists.";
			return false;
		}
	}

	public function login($email = '')
	{
		if($email != '')
		{
			if($this->_checkCredentials($this->_username, $this->_pass, $email))
				{
					return true;
				}
			else {
				$this->_error = true;
				$this->_errorMsg = "Credentials did not match any of our users.";
				return false;
			}
		} else if($this->_checkCredentials($this->_username, $this->_pass))
			{
				return true;
			}
		else {
			$this->_error = true;
			$this->_errorMsg = "Credentials did not match any of our users.";
			return false;
		}
	}

	public function logoutUser()
	{
	  session_unset();
		session_destroy();
	}

	public function displayTable()
	{
		if($this->_fetchUserTable())
		{
			return true;
		}
		$this->_error = true;
		$this->_errorMsg = "<p style='color:white'>User table could not be loaded</p>";
		return false;
	}

	public function updateUser()
	{
		if($this->_updateUserRow())
		{
			return true;
		}
		return false;
	}

	public function deleteUser()
	{
		if($this->_deleteUserRow())
		{
			$this->_successMsg = "<p style='color: black'>Row successfully deleted from the database</p>";
			return true;
		}
		$this->_error = true;
		$this->_errorMsg = "<p style='color: black'>Row couldn't be deleted. Unexpected error has occured</p>";
		return false;
	}

	public function getEmail()
	{
		return $this->_email;
	}

	public function getMsg()
	{
		if($this->_error)
			return $this->_errorMsg;
		else
			return $this->_successMsg;
	}

	public function getHash()
	{
		return $this->_hash;
	}

	public function hashPassword(string $password): void
	{
		$this->_hash = password_hash($password, PASSWORD_DEFAULT);
	}

	protected function _passwordVerify(string $input, string $hash): void
	{
		$this->_passwordVerify = password_verify($input, $hash);
	}

	protected function _userExists(string $username, string $email)
	{
		try {
			$filterUserName = filter_var($username, FILTER_SANITIZE_STRING);
			$filterEmail = filter_var($email, FILTER_SANITIZE_STRING);
			$stmt = $this->_db->prepare("SELECT * FROM ". $this->_table ." WHERE user_username = :username OR user_email = :email");
			$stmt->bindParam(':username',$filterUserName, PDO::PARAM_STR);
			$stmt->bindParam(':email',$filterEmail, PDO::PARAM_STR);
			$stmt->execute();
			if($stmt->rowCount() >= 1)
			{
				$this->_error = true;
				$this->_errorMsg = "Username (and or) Email already exists";
				return false;
			}
			else {
				return true;
			}
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}

	protected function _emailVerify(string $email, string $code)
	{
		try {
			$filterEmail = filter_var($email, FILTER_SANITIZE_STRING);
			$stmt = $this->_db->prepare("SELECT * FROM ". $this->_table ." WHERE user_email = :email AND user_code = :code");
			$stmt->bindParam(':email',$filterEmail, PDO::PARAM_STR);
			$stmt->bindParam(':code',$code, PDO::PARAM_STR);
			$stmt->execute();
				if($stmt->rowCount() == 1)
				{
					$bool = 1;
					$stmt = $this->_db->prepare("UPDATE ". $this->_table ." SET user_verified = :verified WHERE user_email = :email AND user_code = :code");
					$stmt->bindParam(':verified',$bool,PDO::PARAM_INT);
					$stmt->bindParam(':email',$filterEmail, PDO::PARAM_STR);
					$stmt->bindParam(':code',$code, PDO::PARAM_STR);
					$stmt->execute();
					return true;
				}
				else {
					return false;
				}
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}

	protected function _isEmailExist(string $email)
	{
		try {
			$filterEmail = filter_var($email, FILTER_SANITIZE_STRING);
			$stmt = $this->_db->prepare("SELECT user_email, user_verified FROM ". $this->_table. " WHERE user_email = :email");
			$stmt->bindParam(':email',$filterEmail, PDO::PARAM_STR);
			$stmt->execute();
			$fetch = $stmt->fetchAll();
				if($stmt->rowCount() == 1)
				{
					if($fetch[0]["user_verified"] == 1)
					{
						return true;
					}
					$this->_error = true;
					$this->_errorMsg = "Email was never verified, therefore I will not help to reset the password";
					return false;
				}
				else {
					$this->_error = true;
					$this->_errorMsg = "Email isn't currently registered";
					return false;
				}
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}

	protected function _registerUser(string $name, string $password, string $phone, string $email, string $username, string $code)
	{
		try {
			$filterName = filter_var($name, FILTER_SANITIZE_STRING);
			$filterPhone = filter_var($phone, FILTER_SANITIZE_STRING);
			$filterEmail = filter_var($email, FILTER_SANITIZE_STRING);
			$filterUserName = filter_var($username, FILTER_SANITIZE_STRING);
			$this->hashPassword($password);
			$stmt = $this->_db->prepare("INSERT INTO ". $this->_table. " (user_fullname, user_password, user_phone, user_email, user_username, user_code) VALUES (:name,:password,:phone,:email,:username, :code)");
			$stmt->bindParam(':name',$filterName, PDO::PARAM_STR);
			$stmt->bindParam(':password',$this->_hash, PDO::PARAM_STR);
			$stmt->bindParam(':phone',$filterPhone, PDO::PARAM_STR);
			$stmt->bindParam(':email',$filterEmail, PDO::PARAM_STR);
			$stmt->bindParam(':username',$filterUserName, PDO::PARAM_STR);
			$stmt->bindParam(':code',$code,PDO::PARAM_STR);
			$stmt->execute();
				if($stmt->rowCount() == 1)
				{
					return true;
				}
				else {
					return false;
				}
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}

	protected function _checkCredentials(string $username, string $password, $email = '')
	{
		try {
			$stmt = $this->_db->prepare("SELECT user_password, user_username FROM ". $this->_table ." WHERE user_username = :username");
			$stmt->bindParam(':username',$username,PDO::PARAM_STR);
			$stmt->execute();
			$fetch = $stmt->fetchAll();
			if($stmt->rowCount() >= 1)
			{
				$this->_passwordVerify($password, $fetch[0]["user_password"]);
				if($this->_passwordVerify == true || $this->_passwordVerify == 1)
				{
					if($email != '')
					{
						$stmt = $this->_db->prepare("SELECT user_email FROM ". $this->_table ." WHERE user_username = :username");
						$stmt->bindParam(':username',$username,PDO::PARAM_STR);
						$stmt->execute();
						$fetch = $stmt->fetchAll();
						if($stmt->rowCount() >= 1)
						{
							$this->_email = $fetch[0]["user_email"];
							return true;
						}
					}
					return true;
				}
				return false;
			}
			return false;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}
}

/**
 *
 */
class Admin extends User
{
	private $_rows;
	function __construct(PDO $db, $table, array $rows)
	{
		$this->_rows = $rows;
		parent::__construct($db, $table);
	}

	public function isSet()
	{
		if($this->_db != '' && $this->_table != '')
		{
			foreach($this->_rows as $val)
			{
				echo ", $val";
			}
		}
	}

	public function fetchTable()
	{
		if($this->fetchSpecificTable())
		{
			return true;
		}
		$this->_error = true;
		$this->_errorMsg = "$this->_table wasn't able to be retrieved at the moment!";
		return false;
	}

	private function fetchSpecificTable(): void
	{
		try {
		$string = '';
		$first = true;
		foreach($this->_rows as $val)
		{
			$string .= ",".$val;
		}
		$rows = trim($string, ", ");
		$stmt = $this->_db->prepare("SELECT $rows FROM $this->_table");
		$stmt->execute();
		if($stmt->rowCount() >= 1)
		{
			$headerstyles = "style='color:black; padding-left: 1rem; padding-right: 1rem; font-weight: 600; font-size: 16px'";
			$styles = "style='color:black; border: 1px solid black; padding-left: 1rem; padding-right: 1rem'";
			echo "<table id='$this->_table'>";
				echo "<tr>";
					foreach($this->_rows as $val)
					{
						echo "<td $headerstyles>". $val . "</td>";
					}
				echo "</tr>";
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				echo "<tr>";
					foreach($this->_rows as $val)
					{
						echo "<td $styles>" . $row[$val] . "</td>";
					}
				echo "</tr>";
			}
			echo "</table>";
		}
		else
			echo "Table cannot be found at this moment, sorry";
		} catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
?>
