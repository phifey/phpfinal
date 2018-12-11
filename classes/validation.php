<?php
class Validation {
  public $_error = false;
  private $_errors = array();
  private $_successMsg = "";
  private $_name;
  private $_pass;
  private $_phone;
  private $_email;
  private $_username;

  public function __construct($name = '', $pass = '', $phone = '', $email = '', $username = '')
	{
    $this->_name = $name;
    $this->_pass = $pass;
    $this->_phone = $phone;
    $this->_email = $email;
    $this->_username = $username;
	}

  public function isNotEmpty(array $fields)
  {
    foreach ($fields as $key => $value) {
      if(empty($value))
      {
        $this->_error = true;
        $this->_errors[] = $key;
      }
    }

    if($this->_error == true)
      return false;
    else
      return true;
  }

  public function mainValidation($field, $validator)
  {
    if(!filter_var($field, $validator))
    {
      $this->_error = true;
      $this->_errors[] = $field;
    }

    if($this->_error == true)
      return false;
    else
      return true;
  }

  public function getErrors()
  {
    if($this->_error)
    {
      return $this->_errors;
    }
  }
}
?>
