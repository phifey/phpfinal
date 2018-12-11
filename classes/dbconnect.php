<?php
class DatabaseConnect
{
  private $_conn;
  private $_stmt;
  private $_db;
  private $_serverName;
  private $_username;
  private $_password;
  private $_fetch;
  private $_rows = array();

  public function __construct($username, $password, $db, $sName)
  {
    $this->_username = $username;
    $this->_password = $password;
    $this->_db = $db;
    $this->_serverName = $sName;
    $this->dbConnect();
  }

  public function dbConnect()
  {
    try {
    $this->_conn = new PDO("mysql:host=".$this->_serverName.";dbname=".$this->_db."", $this->_username, $this->_password);
    $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return true;
    }
catch(PDOException $e)
    {
    error_log($e->getMessage());
    error_log(debug_backtrace());
    return false;
    }
  }

  public function dbCloseConn()
  {
    $this->_stmt = null;
    $this->_conn = null;
  }

  public function bindParams(array $paramValues): void
  {
    foreach($paramValues as $key => $val)
    {
      if(is_numeric($val))
      {
        $filterValInt = filter_var($val, FILTER_SANITIZE_NUMBER_INT);
        $this->_stmt->bindParam(''.$key.'',$filterValInt,PDO::PARAM_INT);
      } else
      {
        $filterValName = filter_var($val, FILTER_SANITIZE_STRING);
        $this->_stmt->bindParam(''.$key.'',$filterValName,PDO::PARAM_STR);
      }
    }
  }

  public function dbPrepare(string $sqlStr)
  {
    try {
      $this->_stmt = $this->_conn->prepare($sqlStr);
      return true;
    }
    catch(PDOException $e)
    {
      error_log($e->getMessage());
      error_log(print_r(debug_backtrace(), true));
      return false;
    }
  }

  public function executeQuery($query)
  {
    try {
      $this->_stmt->execute();
      if($query != "upd" || $query != "ins")
      {
        return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
      }
    }
    catch(PDOException $e)
    {
      error_log($e->getMessage());
      error_log(print_r(debug_backtrace(), true));
      return false;
    }
  }
}
?>
