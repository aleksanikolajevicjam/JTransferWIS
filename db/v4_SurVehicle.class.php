<?php
/*
 * Author: Rafael Rocha
 *
 * Changes: Bogo Soic-Mirilovic bogo.split@gmail.com
 * 
 * Version of MYSQL_to_PHP: 1.1.1
 * 
 * License: LGPL 
 * 
 */
require_once 'db.class.php';

Class v4_SurVehicle {

	public $ID; //int(11)
	public $SiteID; //smallint(3)
	public $OwnerID; //int(10)
	public $VehicleID; //int(10)
	public $NightStart; //varchar(5)
	public $NightEnd; //varchar(5)
	public $NightPercent; //decimal(5,2)
	public $NightAmount; //decimal(7,2)
	public $WeekendPercent; //decimal(5,2)
	public $WeekendAmount; //decimal(7,2)
	public $MonPercent; //decimal(5,2)
	public $MonAmount; //decimal(7,2)
	public $TuePercent; //decimal(5,2)
	public $TueAmount; //decimal(7,2)
	public $WedPercent; //decimal(5,2)
	public $WedAmount; //decimal(7,2)
	public $ThuPercent; //decimal(5,2)
	public $ThuAmount; //decimal(7,2)
	public $FriPercent; //decimal(5,2)
	public $FriAmount; //decimal(7,2)
	public $SatPercent; //decimal(5,2)
	public $SatAmount; //decimal(7,2)
	public $SunPercent; //decimal(5,2)
	public $SunAmount; //decimal(7,2)
	public $S1Start; //varchar(5)
	public $S1End; //varchar(5)
	public $S1Percent; //decimal(5,2)
	public $S2Start; //varchar(5)
	public $S2End; //varchar(5)
	public $S2Percent; //decimal(5,2)
	public $S3Start; //varchar(5)
	public $S3End; //varchar(5)
	public $S3Percent; //decimal(5,2)
	public $S4Start; //varchar(5)
	public $S4End; //varchar(5)
	public $S4Percent; //decimal(5,2)
	public $S5Start; //varchar(5)
	public $S5End; //varchar(5)
	public $S5Percent; //decimal(5,2)
	public $S6Start; //varchar(5)
	public $S6End; //varchar(5)
	public $S6Percent; //decimal(5,2)
	public $S7Start; //varchar(5)
	public $S7End; //varchar(5)
	public $S7Percent; //decimal(5,2)
	public $S8Start; //varchar(5)
	public $S8End; //varchar(5)
	public $S8Percent; //decimal(5,2)
	public $S9Start; //varchar(5)
	public $S9End; //varchar(5)
	public $S9Percent; //decimal(5,2)
	public $S10Start; //varchar(5)
	public $S10End; //varchar(5)
	public $S10Percent; //decimal(5,2)
	public $connection;

	function __construct(){
		$this->connection = new DataBaseMysql();
	}	public function myreal_escape_string($string){
		return $this->connection->real_escape_string($string);
	}

    /**
     * New object to the class. Don´t forget to save this new object "as new" by using the function $class->saveAsNew(); 
     *
     */
	public function New_v4_SurVehicle($SiteID,$OwnerID,$VehicleID,$NightStart,$NightEnd,$NightPercent,$NightAmount,$WeekendPercent,$WeekendAmount,$MonPercent,$MonAmount,$TuePercent,$TueAmount,$WedPercent,$WedAmount,$ThuPercent,$ThuAmount,$FriPercent,$FriAmount,$SatPercent,$SatAmount,$SunPercent,$SunAmount,$S1Start,$S1End,$S1Percent,$S2Start,$S2End,$S2Percent,$S3Start,$S3End,$S3Percent,$S4Start,$S4End,$S4Percent,$S5Start,$S5End,$S5Percent,$S6Start,$S6End,$S6Percent,$S7Start,$S7End,$S7Percent,$S8Start,$S8End,$S8Percent,$S9Start,$S9End,$S9Percent,$S10Start,$S10End,$S10Percent){
		$this->SiteID = $SiteID;
		$this->OwnerID = $OwnerID;
		$this->VehicleID = $VehicleID;
		$this->NightStart = $NightStart;
		$this->NightEnd = $NightEnd;
		$this->NightPercent = $NightPercent;
		$this->NightAmount = $NightAmount;
		$this->WeekendPercent = $WeekendPercent;
		$this->WeekendAmount = $WeekendAmount;
		$this->MonPercent = $MonPercent;
		$this->MonAmount = $MonAmount;
		$this->TuePercent = $TuePercent;
		$this->TueAmount = $TueAmount;
		$this->WedPercent = $WedPercent;
		$this->WedAmount = $WedAmount;
		$this->ThuPercent = $ThuPercent;
		$this->ThuAmount = $ThuAmount;
		$this->FriPercent = $FriPercent;
		$this->FriAmount = $FriAmount;
		$this->SatPercent = $SatPercent;
		$this->SatAmount = $SatAmount;
		$this->SunPercent = $SunPercent;
		$this->SunAmount = $SunAmount;
		$this->S1Start = $S1Start;
		$this->S1End = $S1End;
		$this->S1Percent = $S1Percent;
		$this->S2Start = $S2Start;
		$this->S2End = $S2End;
		$this->S2Percent = $S2Percent;
		$this->S3Start = $S3Start;
		$this->S3End = $S3End;
		$this->S3Percent = $S3Percent;
		$this->S4Start = $S4Start;
		$this->S4End = $S4End;
		$this->S4Percent = $S4Percent;
		$this->S5Start = $S5Start;
		$this->S5End = $S5End;
		$this->S5Percent = $S5Percent;
		$this->S6Start = $S6Start;
		$this->S6End = $S6End;
		$this->S6Percent = $S6Percent;
		$this->S7Start = $S7Start;
		$this->S7End = $S7End;
		$this->S7Percent = $S7Percent;
		$this->S8Start = $S8Start;
		$this->S8End = $S8End;
		$this->S8Percent = $S8Percent;
		$this->S9Start = $S9Start;
		$this->S9End = $S9End;
		$this->S9Percent = $S9Percent;
		$this->S10Start = $S10Start;
		$this->S10End = $S10End;
		$this->S10Percent = $S10Percent;
	}

    /**
     * Load one row into var_class. To use the vars use for exemple echo $class->getVar_name; 
     *
     * @param key_table_type $key_row
     * 
     */
	public function getRow($key_row){
		$result = $this->connection->RunQuery("Select * from v4_SurVehicle where ID = \"$key_row\" ");
		if($result->num_rows < 1) return false;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$this->ID = $row["ID"];
			$this->SiteID = $row["SiteID"];
			$this->OwnerID = $row["OwnerID"];
			$this->VehicleID = $row["VehicleID"];
			$this->NightStart = $row["NightStart"];
			$this->NightEnd = $row["NightEnd"];
			$this->NightPercent = $row["NightPercent"];
			$this->NightAmount = $row["NightAmount"];
			$this->WeekendPercent = $row["WeekendPercent"];
			$this->WeekendAmount = $row["WeekendAmount"];
			$this->MonPercent = $row["MonPercent"];
			$this->MonAmount = $row["MonAmount"];
			$this->TuePercent = $row["TuePercent"];
			$this->TueAmount = $row["TueAmount"];
			$this->WedPercent = $row["WedPercent"];
			$this->WedAmount = $row["WedAmount"];
			$this->ThuPercent = $row["ThuPercent"];
			$this->ThuAmount = $row["ThuAmount"];
			$this->FriPercent = $row["FriPercent"];
			$this->FriAmount = $row["FriAmount"];
			$this->SatPercent = $row["SatPercent"];
			$this->SatAmount = $row["SatAmount"];
			$this->SunPercent = $row["SunPercent"];
			$this->SunAmount = $row["SunAmount"];
			$this->S1Start = $row["S1Start"];
			$this->S1End = $row["S1End"];
			$this->S1Percent = $row["S1Percent"];
			$this->S2Start = $row["S2Start"];
			$this->S2End = $row["S2End"];
			$this->S2Percent = $row["S2Percent"];
			$this->S3Start = $row["S3Start"];
			$this->S3End = $row["S3End"];
			$this->S3Percent = $row["S3Percent"];
			$this->S4Start = $row["S4Start"];
			$this->S4End = $row["S4End"];
			$this->S4Percent = $row["S4Percent"];
			$this->S5Start = $row["S5Start"];
			$this->S5End = $row["S5End"];
			$this->S5Percent = $row["S5Percent"];
			$this->S6Start = $row["S6Start"];
			$this->S6End = $row["S6End"];
			$this->S6Percent = $row["S6Percent"];
			$this->S7Start = $row["S7Start"];
			$this->S7End = $row["S7End"];
			$this->S7Percent = $row["S7Percent"];
			$this->S8Start = $row["S8Start"];
			$this->S8End = $row["S8End"];
			$this->S8Percent = $row["S8Percent"];
			$this->S9Start = $row["S9Start"];
			$this->S9End = $row["S9End"];
			$this->S9Percent = $row["S9Percent"];
			$this->S10Start = $row["S10Start"];
			$this->S10End = $row["S10End"];
			$this->S10Percent = $row["S10Percent"];
		}
	}

    /**
     * Delete the row by using the key as arg
     *
     * @param key_table_type $key_row
     *
     */
	public function deleteRow($key_row){
		$this->connection->RunQuery("DELETE FROM v4_SurVehicle WHERE ID = $key_row");
	}

    /**
     * Update the active row table on table
     */
	public function saveRow(){
		$result = $this->connection->RunQuery("UPDATE v4_SurVehicle set 
SiteID = '".$this->myreal_escape_string($this->SiteID)."', 
OwnerID = '".$this->myreal_escape_string($this->OwnerID)."', 
VehicleID = '".$this->myreal_escape_string($this->VehicleID)."', 
NightStart = '".$this->myreal_escape_string($this->NightStart)."', 
NightEnd = '".$this->myreal_escape_string($this->NightEnd)."', 
NightPercent = '".$this->myreal_escape_string($this->NightPercent)."', 
NightAmount = '".$this->myreal_escape_string($this->NightAmount)."', 
WeekendPercent = '".$this->myreal_escape_string($this->WeekendPercent)."', 
WeekendAmount = '".$this->myreal_escape_string($this->WeekendAmount)."', 
MonPercent = '".$this->myreal_escape_string($this->MonPercent)."', 
MonAmount = '".$this->myreal_escape_string($this->MonAmount)."', 
TuePercent = '".$this->myreal_escape_string($this->TuePercent)."', 
TueAmount = '".$this->myreal_escape_string($this->TueAmount)."', 
WedPercent = '".$this->myreal_escape_string($this->WedPercent)."', 
WedAmount = '".$this->myreal_escape_string($this->WedAmount)."', 
ThuPercent = '".$this->myreal_escape_string($this->ThuPercent)."', 
ThuAmount = '".$this->myreal_escape_string($this->ThuAmount)."', 
FriPercent = '".$this->myreal_escape_string($this->FriPercent)."', 
FriAmount = '".$this->myreal_escape_string($this->FriAmount)."', 
SatPercent = '".$this->myreal_escape_string($this->SatPercent)."', 
SatAmount = '".$this->myreal_escape_string($this->SatAmount)."', 
SunPercent = '".$this->myreal_escape_string($this->SunPercent)."', 
SunAmount = '".$this->myreal_escape_string($this->SunAmount)."', 
S1Start = '".$this->myreal_escape_string($this->S1Start)."', 
S1End = '".$this->myreal_escape_string($this->S1End)."', 
S1Percent = '".$this->myreal_escape_string($this->S1Percent)."', 
S2Start = '".$this->myreal_escape_string($this->S2Start)."', 
S2End = '".$this->myreal_escape_string($this->S2End)."', 
S2Percent = '".$this->myreal_escape_string($this->S2Percent)."', 
S3Start = '".$this->myreal_escape_string($this->S3Start)."', 
S3End = '".$this->myreal_escape_string($this->S3End)."', 
S3Percent = '".$this->myreal_escape_string($this->S3Percent)."', 
S4Start = '".$this->myreal_escape_string($this->S4Start)."', 
S4End = '".$this->myreal_escape_string($this->S4End)."', 
S4Percent = '".$this->myreal_escape_string($this->S4Percent)."', 
S5Start = '".$this->myreal_escape_string($this->S5Start)."', 
S5End = '".$this->myreal_escape_string($this->S5End)."', 
S5Percent = '".$this->myreal_escape_string($this->S5Percent)."', 
S6Start = '".$this->myreal_escape_string($this->S6Start)."', 
S6End = '".$this->myreal_escape_string($this->S6End)."', 
S6Percent = '".$this->myreal_escape_string($this->S6Percent)."', 
S7Start = '".$this->myreal_escape_string($this->S7Start)."', 
S7End = '".$this->myreal_escape_string($this->S7End)."', 
S7Percent = '".$this->myreal_escape_string($this->S7Percent)."', 
S8Start = '".$this->myreal_escape_string($this->S8Start)."', 
S8End = '".$this->myreal_escape_string($this->S8End)."', 
S8Percent = '".$this->myreal_escape_string($this->S8Percent)."', 
S9Start = '".$this->myreal_escape_string($this->S9Start)."', 
S9End = '".$this->myreal_escape_string($this->S9End)."', 
S9Percent = '".$this->myreal_escape_string($this->S9Percent)."', 
S10Start = '".$this->myreal_escape_string($this->S10Start)."', 
S10End = '".$this->myreal_escape_string($this->S10End)."', 
S10Percent = '".$this->myreal_escape_string($this->S10Percent)."' WHERE ID = '".$this->ID."'");
	return $result; 
}

    /**
     * Save the active var class as a new row on table
     */
	public function saveAsNew(){
		$this->connection->RunQuery("INSERT INTO v4_SurVehicle (SiteID, OwnerID, VehicleID, NightStart, NightEnd, NightPercent, NightAmount, WeekendPercent, WeekendAmount, MonPercent, MonAmount, TuePercent, TueAmount, WedPercent, WedAmount, ThuPercent, ThuAmount, FriPercent, FriAmount, SatPercent, SatAmount, SunPercent, SunAmount, S1Start, S1End, S1Percent, S2Start, S2End, S2Percent, S3Start, S3End, S3Percent, S4Start, S4End, S4Percent, S5Start, S5End, S5Percent, S6Start, S6End, S6Percent, S7Start, S7End, S7Percent, S8Start, S8End, S8Percent, S9Start, S9End, S9Percent, S10Start, S10End, S10Percent) values ('".$this->myreal_escape_string($this->SiteID)."', '".$this->myreal_escape_string($this->OwnerID)."', '".$this->myreal_escape_string($this->VehicleID)."', '".$this->myreal_escape_string($this->NightStart)."', '".$this->myreal_escape_string($this->NightEnd)."', '".$this->myreal_escape_string($this->NightPercent)."', '".$this->myreal_escape_string($this->NightAmount)."', '".$this->myreal_escape_string($this->WeekendPercent)."', '".$this->myreal_escape_string($this->WeekendAmount)."', '".$this->myreal_escape_string($this->MonPercent)."', '".$this->myreal_escape_string($this->MonAmount)."', '".$this->myreal_escape_string($this->TuePercent)."', '".$this->myreal_escape_string($this->TueAmount)."', '".$this->myreal_escape_string($this->WedPercent)."', '".$this->myreal_escape_string($this->WedAmount)."', '".$this->myreal_escape_string($this->ThuPercent)."', '".$this->myreal_escape_string($this->ThuAmount)."', '".$this->myreal_escape_string($this->FriPercent)."', '".$this->myreal_escape_string($this->FriAmount)."', '".$this->myreal_escape_string($this->SatPercent)."', '".$this->myreal_escape_string($this->SatAmount)."', '".$this->myreal_escape_string($this->SunPercent)."', '".$this->myreal_escape_string($this->SunAmount)."', '".$this->myreal_escape_string($this->S1Start)."', '".$this->myreal_escape_string($this->S1End)."', '".$this->myreal_escape_string($this->S1Percent)."', '".$this->myreal_escape_string($this->S2Start)."', '".$this->myreal_escape_string($this->S2End)."', '".$this->myreal_escape_string($this->S2Percent)."', '".$this->myreal_escape_string($this->S3Start)."', '".$this->myreal_escape_string($this->S3End)."', '".$this->myreal_escape_string($this->S3Percent)."', '".$this->myreal_escape_string($this->S4Start)."', '".$this->myreal_escape_string($this->S4End)."', '".$this->myreal_escape_string($this->S4Percent)."', '".$this->myreal_escape_string($this->S5Start)."', '".$this->myreal_escape_string($this->S5End)."', '".$this->myreal_escape_string($this->S5Percent)."', '".$this->myreal_escape_string($this->S6Start)."', '".$this->myreal_escape_string($this->S6End)."', '".$this->myreal_escape_string($this->S6Percent)."', '".$this->myreal_escape_string($this->S7Start)."', '".$this->myreal_escape_string($this->S7End)."', '".$this->myreal_escape_string($this->S7Percent)."', '".$this->myreal_escape_string($this->S8Start)."', '".$this->myreal_escape_string($this->S8End)."', '".$this->myreal_escape_string($this->S8Percent)."', '".$this->myreal_escape_string($this->S9Start)."', '".$this->myreal_escape_string($this->S9End)."', '".$this->myreal_escape_string($this->S9Percent)."', '".$this->myreal_escape_string($this->S10Start)."', '".$this->myreal_escape_string($this->S10End)."', '".$this->myreal_escape_string($this->S10Percent)."')");
		return $this->connection->insert_id(); //return insert_id 
	}

    /**
     * Returns array of keys order by $column -> name of column $order -> desc or acs
     *
     * @param string $column
     * @param string $order
     */
	public function getKeysBy($column, $order, $where = NULL){
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("SELECT ID from v4_SurVehicle $where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ID"];
				$i++;
			}
	return $keys;
	}

	/**
	 * @return ID - int(11)
	 */
	public function getID(){
		return $this->ID;
	}

	/**
	 * @return SiteID - smallint(3)
	 */
	public function getSiteID(){
		return $this->SiteID;
	}

	/**
	 * @return OwnerID - int(10)
	 */
	public function getOwnerID(){
		return $this->OwnerID;
	}

	/**
	 * @return VehicleID - int(10)
	 */
	public function getVehicleID(){
		return $this->VehicleID;
	}

	/**
	 * @return NightStart - varchar(5)
	 */
	public function getNightStart(){
		return $this->NightStart;
	}

	/**
	 * @return NightEnd - varchar(5)
	 */
	public function getNightEnd(){
		return $this->NightEnd;
	}

	/**
	 * @return NightPercent - decimal(5,2)
	 */
	public function getNightPercent(){
		return $this->NightPercent;
	}

	/**
	 * @return NightAmount - decimal(7,2)
	 */
	public function getNightAmount(){
		return $this->NightAmount;
	}

	/**
	 * @return WeekendPercent - decimal(5,2)
	 */
	public function getWeekendPercent(){
		return $this->WeekendPercent;
	}

	/**
	 * @return WeekendAmount - decimal(7,2)
	 */
	public function getWeekendAmount(){
		return $this->WeekendAmount;
	}

	/**
	 * @return MonPercent - decimal(5,2)
	 */
	public function getMonPercent(){
		return $this->MonPercent;
	}

	/**
	 * @return MonAmount - decimal(7,2)
	 */
	public function getMonAmount(){
		return $this->MonAmount;
	}

	/**
	 * @return TuePercent - decimal(5,2)
	 */
	public function getTuePercent(){
		return $this->TuePercent;
	}

	/**
	 * @return TueAmount - decimal(7,2)
	 */
	public function getTueAmount(){
		return $this->TueAmount;
	}

	/**
	 * @return WedPercent - decimal(5,2)
	 */
	public function getWedPercent(){
		return $this->WedPercent;
	}

	/**
	 * @return WedAmount - decimal(7,2)
	 */
	public function getWedAmount(){
		return $this->WedAmount;
	}

	/**
	 * @return ThuPercent - decimal(5,2)
	 */
	public function getThuPercent(){
		return $this->ThuPercent;
	}

	/**
	 * @return ThuAmount - decimal(7,2)
	 */
	public function getThuAmount(){
		return $this->ThuAmount;
	}

	/**
	 * @return FriPercent - decimal(5,2)
	 */
	public function getFriPercent(){
		return $this->FriPercent;
	}

	/**
	 * @return FriAmount - decimal(7,2)
	 */
	public function getFriAmount(){
		return $this->FriAmount;
	}

	/**
	 * @return SatPercent - decimal(5,2)
	 */
	public function getSatPercent(){
		return $this->SatPercent;
	}

	/**
	 * @return SatAmount - decimal(7,2)
	 */
	public function getSatAmount(){
		return $this->SatAmount;
	}

	/**
	 * @return SunPercent - decimal(5,2)
	 */
	public function getSunPercent(){
		return $this->SunPercent;
	}

	/**
	 * @return SunAmount - decimal(7,2)
	 */
	public function getSunAmount(){
		return $this->SunAmount;
	}

	/**
	 * @return S1Start - varchar(5)
	 */
	public function getS1Start(){
		return $this->S1Start;
	}

	/**
	 * @return S1End - varchar(5)
	 */
	public function getS1End(){
		return $this->S1End;
	}

	/**
	 * @return S1Percent - decimal(5,2)
	 */
	public function getS1Percent(){
		return $this->S1Percent;
	}

	/**
	 * @return S2Start - varchar(5)
	 */
	public function getS2Start(){
		return $this->S2Start;
	}

	/**
	 * @return S2End - varchar(5)
	 */
	public function getS2End(){
		return $this->S2End;
	}

	/**
	 * @return S2Percent - decimal(5,2)
	 */
	public function getS2Percent(){
		return $this->S2Percent;
	}

	/**
	 * @return S3Start - varchar(5)
	 */
	public function getS3Start(){
		return $this->S3Start;
	}

	/**
	 * @return S3End - varchar(5)
	 */
	public function getS3End(){
		return $this->S3End;
	}

	/**
	 * @return S3Percent - decimal(5,2)
	 */
	public function getS3Percent(){
		return $this->S3Percent;
	}

	/**
	 * @return S4Start - varchar(5)
	 */
	public function getS4Start(){
		return $this->S4Start;
	}

	/**
	 * @return S4End - varchar(5)
	 */
	public function getS4End(){
		return $this->S4End;
	}

	/**
	 * @return S4Percent - decimal(5,2)
	 */
	public function getS4Percent(){
		return $this->S4Percent;
	}

	/**
	 * @return S5Start - varchar(5)
	 */
	public function getS5Start(){
		return $this->S5Start;
	}

	/**
	 * @return S5End - varchar(5)
	 */
	public function getS5End(){
		return $this->S5End;
	}

	/**
	 * @return S5Percent - decimal(5,2)
	 */
	public function getS5Percent(){
		return $this->S5Percent;
	}

	/**
	 * @return S6Start - varchar(5)
	 */
	public function getS6Start(){
		return $this->S6Start;
	}

	/**
	 * @return S6End - varchar(5)
	 */
	public function getS6End(){
		return $this->S6End;
	}

	/**
	 * @return S6Percent - decimal(5,2)
	 */
	public function getS6Percent(){
		return $this->S6Percent;
	}

	/**
	 * @return S7Start - varchar(5)
	 */
	public function getS7Start(){
		return $this->S7Start;
	}

	/**
	 * @return S7End - varchar(5)
	 */
	public function getS7End(){
		return $this->S7End;
	}

	/**
	 * @return S7Percent - decimal(5,2)
	 */
	public function getS7Percent(){
		return $this->S7Percent;
	}

	/**
	 * @return S8Start - varchar(5)
	 */
	public function getS8Start(){
		return $this->S8Start;
	}

	/**
	 * @return S8End - varchar(5)
	 */
	public function getS8End(){
		return $this->S8End;
	}

	/**
	 * @return S8Percent - decimal(5,2)
	 */
	public function getS8Percent(){
		return $this->S8Percent;
	}

	/**
	 * @return S9Start - varchar(5)
	 */
	public function getS9Start(){
		return $this->S9Start;
	}

	/**
	 * @return S9End - varchar(5)
	 */
	public function getS9End(){
		return $this->S9End;
	}

	/**
	 * @return S9Percent - decimal(5,2)
	 */
	public function getS9Percent(){
		return $this->S9Percent;
	}

	/**
	 * @return S10Start - varchar(5)
	 */
	public function getS10Start(){
		return $this->S10Start;
	}

	/**
	 * @return S10End - varchar(5)
	 */
	public function getS10End(){
		return $this->S10End;
	}

	/**
	 * @return S10Percent - decimal(5,2)
	 */
	public function getS10Percent(){
		return $this->S10Percent;
	}

	/**
	 * @param Type: int(11)
	 */
	public function setID($ID){
		$this->ID = $ID;
	}

	/**
	 * @param Type: smallint(3)
	 */
	public function setSiteID($SiteID){
		$this->SiteID = $SiteID;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setOwnerID($OwnerID){
		$this->OwnerID = $OwnerID;
	}

	/**
	 * @param Type: int(10)
	 */
	public function setVehicleID($VehicleID){
		$this->VehicleID = $VehicleID;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setNightStart($NightStart){
		$this->NightStart = $NightStart;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setNightEnd($NightEnd){
		$this->NightEnd = $NightEnd;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setNightPercent($NightPercent){
		$this->NightPercent = $NightPercent;
	}

	/**
	 * @param Type: decimal(7,2)
	 */
	public function setNightAmount($NightAmount){
		$this->NightAmount = $NightAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setWeekendPercent($WeekendPercent){
		$this->WeekendPercent = $WeekendPercent;
	}

	/**
	 * @param Type: decimal(7,2)
	 */
	public function setWeekendAmount($WeekendAmount){
		$this->WeekendAmount = $WeekendAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setMonPercent($MonPercent){
		$this->MonPercent = $MonPercent;
	}

	/**
	 * @param Type: decimal(7,2)
	 */
	public function setMonAmount($MonAmount){
		$this->MonAmount = $MonAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setTuePercent($TuePercent){
		$this->TuePercent = $TuePercent;
	}

	/**
	 * @param Type: decimal(7,2)
	 */
	public function setTueAmount($TueAmount){
		$this->TueAmount = $TueAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setWedPercent($WedPercent){
		$this->WedPercent = $WedPercent;
	}

	/**
	 * @param Type: decimal(7,2)
	 */
	public function setWedAmount($WedAmount){
		$this->WedAmount = $WedAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setThuPercent($ThuPercent){
		$this->ThuPercent = $ThuPercent;
	}

	/**
	 * @param Type: decimal(7,2)
	 */
	public function setThuAmount($ThuAmount){
		$this->ThuAmount = $ThuAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setFriPercent($FriPercent){
		$this->FriPercent = $FriPercent;
	}

	/**
	 * @param Type: decimal(7,2)
	 */
	public function setFriAmount($FriAmount){
		$this->FriAmount = $FriAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setSatPercent($SatPercent){
		$this->SatPercent = $SatPercent;
	}

	/**
	 * @param Type: decimal(7,2)
	 */
	public function setSatAmount($SatAmount){
		$this->SatAmount = $SatAmount;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setSunPercent($SunPercent){
		$this->SunPercent = $SunPercent;
	}

	/**
	 * @param Type: decimal(7,2)
	 */
	public function setSunAmount($SunAmount){
		$this->SunAmount = $SunAmount;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS1Start($S1Start){
		$this->S1Start = $S1Start;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS1End($S1End){
		$this->S1End = $S1End;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setS1Percent($S1Percent){
		$this->S1Percent = $S1Percent;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS2Start($S2Start){
		$this->S2Start = $S2Start;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS2End($S2End){
		$this->S2End = $S2End;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setS2Percent($S2Percent){
		$this->S2Percent = $S2Percent;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS3Start($S3Start){
		$this->S3Start = $S3Start;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS3End($S3End){
		$this->S3End = $S3End;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setS3Percent($S3Percent){
		$this->S3Percent = $S3Percent;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS4Start($S4Start){
		$this->S4Start = $S4Start;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS4End($S4End){
		$this->S4End = $S4End;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setS4Percent($S4Percent){
		$this->S4Percent = $S4Percent;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS5Start($S5Start){
		$this->S5Start = $S5Start;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS5End($S5End){
		$this->S5End = $S5End;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setS5Percent($S5Percent){
		$this->S5Percent = $S5Percent;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS6Start($S6Start){
		$this->S6Start = $S6Start;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS6End($S6End){
		$this->S6End = $S6End;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setS6Percent($S6Percent){
		$this->S6Percent = $S6Percent;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS7Start($S7Start){
		$this->S7Start = $S7Start;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS7End($S7End){
		$this->S7End = $S7End;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setS7Percent($S7Percent){
		$this->S7Percent = $S7Percent;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS8Start($S8Start){
		$this->S8Start = $S8Start;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS8End($S8End){
		$this->S8End = $S8End;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setS8Percent($S8Percent){
		$this->S8Percent = $S8Percent;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS9Start($S9Start){
		$this->S9Start = $S9Start;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS9End($S9End){
		$this->S9End = $S9End;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setS9Percent($S9Percent){
		$this->S9Percent = $S9Percent;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS10Start($S10Start){
		$this->S10Start = $S10Start;
	}

	/**
	 * @param Type: varchar(5)
	 */
	public function setS10End($S10End){
		$this->S10End = $S10End;
	}

	/**
	 * @param Type: decimal(5,2)
	 */
	public function setS10Percent($S10Percent){
		$this->S10Percent = $S10Percent;
	}

    /**
     * fieldValues - Load all fieldNames and fieldValues into Array. 
     *
     * @param 
     * 
     */
	public function fieldValues(){
		$fieldValues = array(
			'ID' => $this->getID(),
			'SiteID' => $this->getSiteID(),
			'OwnerID' => $this->getOwnerID(),
			'VehicleID' => $this->getVehicleID(),
			'NightStart' => $this->getNightStart(),
			'NightEnd' => $this->getNightEnd(),
			'NightPercent' => $this->getNightPercent(),
			'NightAmount' => $this->getNightAmount(),
			'WeekendPercent' => $this->getWeekendPercent(),
			'WeekendAmount' => $this->getWeekendAmount(),
			'MonPercent' => $this->getMonPercent(),
			'MonAmount' => $this->getMonAmount(),
			'TuePercent' => $this->getTuePercent(),
			'TueAmount' => $this->getTueAmount(),
			'WedPercent' => $this->getWedPercent(),
			'WedAmount' => $this->getWedAmount(),
			'ThuPercent' => $this->getThuPercent(),
			'ThuAmount' => $this->getThuAmount(),
			'FriPercent' => $this->getFriPercent(),
			'FriAmount' => $this->getFriAmount(),
			'SatPercent' => $this->getSatPercent(),
			'SatAmount' => $this->getSatAmount(),
			'SunPercent' => $this->getSunPercent(),
			'SunAmount' => $this->getSunAmount(),
			'S1Start' => $this->getS1Start(),
			'S1End' => $this->getS1End(),
			'S1Percent' => $this->getS1Percent(),
			'S2Start' => $this->getS2Start(),
			'S2End' => $this->getS2End(),
			'S2Percent' => $this->getS2Percent(),
			'S3Start' => $this->getS3Start(),
			'S3End' => $this->getS3End(),
			'S3Percent' => $this->getS3Percent(),
			'S4Start' => $this->getS4Start(),
			'S4End' => $this->getS4End(),
			'S4Percent' => $this->getS4Percent(),
			'S5Start' => $this->getS5Start(),
			'S5End' => $this->getS5End(),
			'S5Percent' => $this->getS5Percent(),
			'S6Start' => $this->getS6Start(),
			'S6End' => $this->getS6End(),
			'S6Percent' => $this->getS6Percent(),
			'S7Start' => $this->getS7Start(),
			'S7End' => $this->getS7End(),
			'S7Percent' => $this->getS7Percent(),
			'S8Start' => $this->getS8Start(),
			'S8End' => $this->getS8End(),
			'S8Percent' => $this->getS8Percent(),
			'S9Start' => $this->getS9Start(),
			'S9End' => $this->getS9End(),
			'S9Percent' => $this->getS9Percent(),
			'S10Start' => $this->getS10Start(),
			'S10End' => $this->getS10End(),
			'S10Percent' => $this->getS10Percent()		);
		return $fieldValues;
	}
    /**
     * fieldNames - returns array of fieldNames 
     *
     * @param 
     * 
     */
	public function fieldNames(){
		$fieldNames = array(
			'ID',			'SiteID',			'OwnerID',			'VehicleID',			'NightStart',			'NightEnd',			'NightPercent',			'NightAmount',			'WeekendPercent',			'WeekendAmount',			'MonPercent',			'MonAmount',			'TuePercent',			'TueAmount',			'WedPercent',			'WedAmount',			'ThuPercent',			'ThuAmount',			'FriPercent',			'FriAmount',			'SatPercent',			'SatAmount',			'SunPercent',			'SunAmount',			'S1Start',			'S1End',			'S1Percent',			'S2Start',			'S2End',			'S2Percent',			'S3Start',			'S3End',			'S3Percent',			'S4Start',			'S4End',			'S4Percent',			'S5Start',			'S5End',			'S5Percent',			'S6Start',			'S6End',			'S6Percent',			'S7Start',			'S7End',			'S7Percent',			'S8Start',			'S8End',			'S8Percent',			'S9Start',			'S9End',			'S9Percent',			'S10Start',			'S10End',			'S10Percent'		);
		return $fieldNames;
	}
    /**
     * Close mysql connection
     */
	public function endv4_SurVehicle(){
		$this->connection->CloseMysql();
	}

}