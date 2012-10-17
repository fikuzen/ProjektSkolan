<?php

namespace Model;

class Database 
{
	private $mysqli = NULL;
	
	public function Connect(DBSettings $dbsettings) {
			
		$this->mysqli = new \mysqli($dbsettings->getHost(), 
									$dbsettings->getUser(), 
									$dbsettings->getPass(), 
									$dbsettings->getDB());
		if($this->mysqli->connect_error) {
			throw new Exception($this->mysqli->connect_error);
		}
		
		$this->mysqli->set_charset("utf8");
		return true;
	}
	
	public function SelectOne(mysqli_stmt $stmt) {
		
		$return = 0;
				
		if (!$stmt->execute()) {
			throw new Exception($this->mysqli->error);
		}
		
		if (!$stmt->bind_result($return)) {
			throw new Exception($this->mysqli->error);
		}
		
		$stmt->fetch();
		
		$stmt->close();
		
		return $return;
		
	}
	
	public function ExecuteSelectQuery(mysqli_stmt $stmt) {

		if (!$stmt) {
			throw new Exception($this->mysqli->error, $this->mysqli->errno);
		}
		
		// Executes the query and throw exception if it fails.
		if (!$stmt->execute()) {
			throw new Exception($this->mysqli->error, $this->mysqli->errno);
		}
		
		// Binds and fetch the result
		$result = $stmt->get_result();
		$return = $result->fetch_array(MYSQLI_ASSOC);
		
		$stmt->close();
		
		return $return;
	}
	
	public function ExecuteInsertQuery(mysqli_stmt $stmt) {
		
		// Possible prepare errors is caught
		if (!$stmt) {
			throw new Exception($this->mysqli->error);
		}
		
		// Executes the query and throw exception if it fails.
		if(!$stmt->execute()) {
			throw new Exception($this->mysqli->error, $this->mysqli->errno);
		}
		
		$return = $stmt->insert_id;
		
		$stmt->close();
		
		return $return;
	}
	
	public function ExecuteRemoveQuery(mysqli_stmt $stmt)
		{		
			// Possible prepare errors is caught
			if (!$stmt) {
				throw new Exception($this->mysqli->error, $this->mysqli->errno);
			}
			
			// Executes the query and throw exception if it fails.
			if (!$stmt->execute()) {
				throw new Exception($this->mysqli->error, $this->mysqli->errno);
			}
			
			// Something removed? yes/no
			$return = ($stmt->affected_rows > 0) ? true : false;
			
			$stmt->close();
			
			return $return;
		}
	
	/**
	 * Prepares a SQL Query
	 * @param $sql String SQL Query
	 * @return mysqli_stmt
	 */
	public function Prepare($sql) {
		$return = $this->mysqli->prepare($sql);
		
		if (!$return) {
			throw new Exception($this->mysqli->error);
		}
		
		return $return;
	}
	
	public function Close() {
		return $this->mysqli->close();
	}
}
