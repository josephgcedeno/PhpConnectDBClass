<?php

/**
* @package dbcedeno ver 1.0.0
*/

class connectdb
{	
		public $connectthis;
		public $type;
		public $user;
		public $pass;
		public $db;
		public function __construct( $type , $username , $password , $database )
		{
			$this->user=$username;
			$this->pass=$password;
			$this->type=$type;
			$this->db=$database;
			$this->connectthis = new mysqli($this->type,$this->user,$this->pass,$this->db) or die("unable to connect");
		}
		public function SelectAllRow( $sql )
		{
			$result=$this->connectthis->query($sql) ;
			$rows=[];
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$rows[]=$row;
			}
			return $rows;
		}
		public function SelectAllColumn( string $tablename = null, $id = null, string $identifier = null )
		{
				$sql="SELECT * FROM $tablename WHERE ".(($identifier) ? $identifier : 'id')." = '$id' ";

				$result=$this->connectthis->query($sql);
				return mysqli_fetch_assoc($result);
		}
		public function InsertData( $tablename , $data )
		{
			$assignColumn='';
			$assignRow='';
			$counterValue=0;
			foreach ($data as $key => $value) 
			{
				$assignColumn.="`".$key."`";
				$assignRow.="'".mysqli_real_escape_string($this->connectthis,$value)."'";
				if ($counterValue+1!=count($data))
				{
					$assignColumn.=",";
					$assignRow.=",";
					$counterValue++;
				}
			}
			$check=mysqli_query($this->connectthis,"INSERT INTO `$tablename` ($assignColumn) VALUES 
			($assignRow)");
			if ($check) 
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		public function UpdateData( $tablename , $data , $id , string $identifier = null )
		{	
			$values="";

			$counterValue=0;

			foreach ($data as $column => $value) 
			{	
				$values.="`".$column."`";
				$values.=" = '".mysqli_real_escape_string($this->connectthis,$value)."'";	
				if ($counterValue+1!=count($data)) 
				{
					$values.=",";
					$counterValue++;
				}
			
			}

			$check=mysqli_query($this->connectthis,
				"UPDATE `$tablename` SET
				$values 
				WHERE ".(($identifier) ? $identifier : 'id')." = $id ");

			if ($check) 
			{
				return true;
			}
			else
			{
				return false;
			}

		}
		public function DeleteData( $tablename , $id, string $identifier = null  )
		{
			$check = mysqli_query($this->connectthis,
			 	"DELETE FROM $tablename WHERE  ".(($identifier) ? $identifier : 'id')."  = $id ");
			if ($check) 
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		public function query( $sql )
		{
			return mysqli_query($this->connectthis, $sql);
		}
		public function IsExist( $tablename , $data , string $operator = null , string $prefered = null)
		{
			$keys  = array_keys($data);
			$prefered=($prefered) ? " ".$prefered. " " : $keys[0]; // which column to return
			$query="
				 SELECT 
				 $prefered
				 FROM $tablename 
				 WHERE 
				 $keys[0] = '".mysqli_real_escape_string($this->connectthis,$data[$keys[0]])."'";
			
			//PARA MAG RETURN UG MULTIPLE CONDITION IF DAGHAN NGA COLUMN IYAHANG IPA CHECK 
			if( count( $keys ) >  1 )
			{ 
				for($i=1; $i<count($data); $i++) 
				{
					$query.= ($operator) ? " ".$operator." " : ' AND '; 
					$query.= $keys[$i] ." = '".mysqli_real_escape_string($this->connectthis,$data[$keys[$i]])."' ";					
				}				
			}
			$result=mysqli_query($this->connectthis,$query);
			return mysqli_fetch_assoc($result);
		}
		
}
		

?>