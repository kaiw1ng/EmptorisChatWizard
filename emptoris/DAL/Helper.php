<?php
/** Global Settings*/
define ( "COOKIE_USERID"	, "USERID" );
define ( "COOKIE_FIRSTNAME"	, "FIRSTNAME" );
define ( "COOKIE_LASTNAME"	, "LASTNAME" );
define ( "ROOTPATH"			, realpath ( dirname ( '../../' ) ) );
define ( "ADMINROOTPATH"	, realpath ( dirname ( '.' ) ) );
define ( "PERMISSION"		, "Insufficient permissions, please contact system administrator" );
define ( "CURRENCY"			, "$" );
define ( "APPDEBUG"			, "OFF" );
define ( "SENDER_EMAIL"		, "system@emptoris.com" );
define ( "BASE_URL"			, strtolower( substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/')) )."://".$_SERVER['SERVER_NAME']. $_SERVER['PHP_SELF'] );
define ( "LOG_FILE"			, ROOTPATH . "/SysLog.html" );
define ( "ERR_FILE"			, ROOTPATH . "/PdoLog.log");
error_reporting ( E_ALL );

class Helper
{
//	protected				$_PDO_DB_NAME			= 'emptorischat';
//	protected				$_PDO_DB_HOST			= 'localhost';
//	protected				$_PDO_DB_USER			= 'root';
//	protected				$_PDO_DB_PASS			= 'namnam';
	protected				$_PDO_DB_NAME			= 'ad_98c4f7e9b20a7f1';
	protected				$_PDO_DB_HOST			= 'us-cdbr-iron-east-04.cleardb.net';
	protected				$_PDO_DB_USER			= 'be29f567297ba0';
	protected				$_PDO_DB_PASS			= '57064f93';
	private static			$_DB_MANAGER;
	private					$_DB_CONNECTION;
	public					$_FUNC					= "nameParams";
	private					$_PREP_STATEMENT_NO		= 0;
	protected				$_PRODUCTION_MODE		= TRUE;
	private					$_DB_TYPE				= "mysql";
	protected				$_DB_PORT				= 3306;
	protected				$_DB_PARAMS				= array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => TRUE);
	public					$_DEBUG_MODE			= FALSE;
	private					$_LOG_FILE				= LOG_FILE;
	private					$_ERR_FILE				= ERR_FILE;

	public function IsDebug ()
	{
		return $this->_DEBUG_MODE;
	}

	public static function GetManager ()
	{
		if ( null === self::$_DB_MANAGER )
		{
			self::$_DB_MANAGER = new Helper ();
		}
		return self::$_DB_MANAGER;
	}

	private function __construct ()
	{
		if (! $this->_DB_CONNECTION) 
		{
			try 
			{
				$this->_DB_CONNECTION = new PDO ( $this->_DB_TYPE.':host='.$this->_PDO_DB_HOST.';port='.$this->_DB_PORT.';dbname='.$this->_PDO_DB_NAME,$this->_PDO_DB_USER,$this->_PDO_DB_PASS, $this->_DB_PARAMS );
				$this->_DB_CONNECTION->beginTransaction();
				
				if ($this->_PRODUCTION_MODE === true) 
				{
					// $this->_DB_CONNECTION->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
					$this->_DB_CONNECTION->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				} 
				else 
				{
					$this->_DB_CONNECTION->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				}
				$this->_DB_CONNECTION->commit();
				
			}
			catch ( PDOException $Exp ) 
			{
				if ($this->_PRODUCTION_MODE === true) 
				{
					file_put_contents($this->_ERR_FILE, $Exp->getCode () ."\n". $Exp->getFile ()."\n".$Exp->getLine ()."\n".$Exp->getMessage ()."\n".$Exp->getTraceAsString (),FILE_APPEND);
					die ( "Datatbae Error, View Logs" );
				} 
				else 
				{
					file_put_contents($this->_ERR_FILE, $Exp->getCode () ."\n". $Exp->getFile ()."\n".$Exp->getLine ()."\n".$Exp->getMessage ()."\n".$Exp->getTraceAsString (),FILE_APPEND);
			die ( "Datatbae Error, View Logs" );
				}
				$this->_DB_CONNECTION->rollBack();
				$this->_DB_CONNECTION = null;
			}
		}		
		return $this->_DB_CONNECTION;
	}

	public function ClearLogs ()
	{
		$HtmlHeaders = '<!DOCTYPE html>';
		$HtmlHeaders.= '<html lang="en">';
		$HtmlHeaders.= '<head>';
		$HtmlHeaders.= '<meta charset="utf-8">';
		$HtmlHeaders.= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
		$HtmlHeaders.= '<meta name="viewport" content="width=device-width, initial-scale=1">';
		$HtmlHeaders.= '<title>System Logs</title>';
		$HtmlHeaders.= '<link href="dist/css/bootstrap.min.css" rel="stylesheet">';
		$HtmlHeaders.= '<style> td {font-size:11px;} </style>';
		$HtmlHeaders.= '</head>';
		$HtmlHeaders.= '<body>';
		file_put_contents ( $this->_LOG_FILE, $HtmlHeaders );
	}

	public function QueryTextToWebServiceCall ( $QUERY_TEXT )
	{
		try
		{
			return str_replace ( ' ', '%20', $QUERY_TEXT );
		}
		catch (Exception $Exp)
		{
			file_put_contents($this->_ERR_FILE, $Exp->getCode () ."\n". $Exp->getFile ()."\n".$Exp->getLine ()."\n".$Exp->getMessage ()."\n".$Exp->getTraceAsString (),FILE_APPEND);
			die ( "Datatbae Error, View Logs" );
		}
	}

	public function LogDateTime ()
	{
		return date ( 'Y-m-d H:i:s' );
	}

	public function DebugMode ( $PrintText, $PrintLabel = "", $CSSClass = 'text-danger' )
	{
		if ( $this->_DEBUG_MODE == TRUE )
		{
			print '<style>.text-danger{font-family:Arial; font-size:12px; color:red;}.text-info{font-family:Arial; font-size:12px; color:blue;}.text-default{font-family:Arial; font-size:12px; color:#000;} </style>';
		}
		if ( is_array ( $PrintText ) )
		{
			if ( count ( $PrintText ) > 0 )
			{
				foreach ( $PrintText as
					$PrintText_Array )
				{
					$Line = '<table border="0" width="98%" align="center" cellpadding="1" cellspacing="1">' . "\n" . '<tr class="' . $CSSClass . '">' . "\n" . '<td width="58%">' . $PrintText_Array . '</td>' . "\n" . '<td width="25%">[' . $PrintLabel . ']</td>' . "\n" . '<td width="17%" style="text-align:right">[' . $this->LogDateTime () . ']</td>' . "\n" . '</tr>' . "\n" . '</table>' . "\n" . '';
					if ( $this->_DEBUG_MODE == TRUE )
					{
						echo $Line;
					}
					else
					{
						$Line = file_get_contents ( $this->_LOG_FILE ) . $Line;
						file_put_contents ( $this->_LOG_FILE, $Line );
					}
				}
			}
			else
			{
				$Line = '<table border="0" width="98%" align="center" cellpadding="1" cellspacing="1">' . "\n" . '<tr class="' . $CSSClass . '">' . "\n" . '<td width="58%">EMPTY_STRING</td>' . "\n" . '<td width="25%">[' . $PrintLabel . ']</td>' . "\n" . '<td width="17%" style="text-align:right">[' . $this->LogDateTime () . ']</td>' . "\n" . '</tr>' . "\n" . '</table>' . "\n" . '';
				if ( $this->_DEBUG_MODE == TRUE )
				{
					echo $Line;
				}
				else
				{
					$Line = file_get_contents ( $this->_LOG_FILE ) . $Line;
					file_put_contents ( $this->_LOG_FILE, $Line );
				}
			}
		}
		else
		{
			if ( strlen ( $PrintLabel ) > 0 )
			{
				$Line = '<table border="0" width="98%" align="center" cellpadding="1" cellspacing="1">' . "\n" . '<tr class="' . $CSSClass . '">' . "\n" . '<td width="58%">' . $PrintText . '</td>' . "\n" . '<td width="25%">[' . $PrintLabel . ']</td>' . "\n" . '<td width="17%" style="text-align:right">[' . $this->LogDateTime () . ']</td>' . "\n" . '</tr>' . "\n" . '</table>' . "\n" . '';
				if ( $this->_DEBUG_MODE == TRUE )
				{
					echo $Line;
				}
				else
				{
					$Line = file_get_contents ( $this->_LOG_FILE ) . $Line;
					file_put_contents ( $this->_LOG_FILE, $Line );
				}
			}
			else
			{
				$Line = '<table border="0" width="98%" align="center" cellpadding="1" cellspacing="1">' . "\n" . '<tr style="font-size:12px;" class="' . $CSSClass . '">' . "\n" . '<td width="50%">' . $PrintText . '</td>' . '<td width="10%">[' . $this->LogDateTime () . ']</td>' . "\n" . '</tr>' . "\n" . '</table>' . "\n" . '';
				if ( $this->_DEBUG_MODE == TRUE )
				{
					echo $Line;
				}
				else
				{
					$Line = file_get_contents ( $this->_LOG_FILE ) . "<br>" . $Line;
					file_put_contents ( $this->_LOG_FILE, $Line );
				}
			}
		}
	}

	public function __destruct ()
	{
		$this->_DB_CONNECTION=NULL;
	}

	public function GetParameterValue ( $ParameterName )
	{
		$ParameterValue = "";
		if ( isset ( $_POST [$ParameterName] ) )
		{
			$ParameterValue = $_POST [$ParameterName];
		}
		else if ( isset ( $_GET [$ParameterName] ) )
		{
			$ParameterValue = $_GET [$ParameterName];
		}
		else if ( isset ( $_REQUEST [$ParameterName] ) )
		{
			$ParameterValue = $_REQUEST [$ParameterName];
		}
		return $ParameterValue;
	}

	public function GenericSelect ( $SqlQuery, $Values = null, $RowsAffected = false )
	{
		try
		{
			$PrepStatement = $this->ResetCursor ( $SqlQuery, $Values );
			while ($RowsCaptured = $PrepStatement->fetch ( PDO::FETCH_BOTH ))
			{
				$ResultSet [] = $RowsCaptured;
			}
			if ( $RowsAffected )
			{
				print "Rows Affected = " . $PrepStatement->rowCount ();
			}
			if ( isset ( $ResultSet ) )
			{
				return $ResultSet;
			}
		}
		catch (Exception $Exp)
		{
			//file_put_contents($this->_ERR_FILE, $Exp->getCode () ."\n". $Exp->getFile ()."\n".$Exp->getLine ()."\n".$Exp->getMessage ()."\n".$Exp->getTraceAsString (),FILE_APPEND);
			die("Generic Select Failed". $Exp->getCode () . $Exp->getFile ().$Exp->getLine ().$Exp->getMessage ().$Exp->getTraceAsString ());
		}
	}

	public function Insert ( $Data_Array_Unchecked, $TableName )
	{
		$Fields_Array = array();
		foreach ( $Data_Array_Unchecked as	$FieldName => $FieldValue )
		{
			if ( $FieldValue != null )
			{
				$Fields_Array [$FieldName] = "'" . $FieldValue . "'";
			}
		}
		$FieldName			= $this->namedColumns ( $Fields_Array );
		$FieldValue			= $this->namedValues ( $Fields_Array );
		$SqlQuery			= " INSERT INTO $TableName ( $FieldName ) values ( $FieldValue ) ";
		$this->ResetCursor ( $SqlQuery, $Fields_Array );
		$LastInsertedId = $this->_DB_CONNECTION->lastInsertId ();
		return $LastInsertedId;
	}
	public function UpdateQuick($NewValues, $Filters, $TableName, $RowsAffected = false) 
	{
		
		$SqlQuery 		= "UPDATE $TableName SET";
		$WhereClause 	= array ();
		foreach ( $NewValues as $Field => $FieldValue ) 
		{
			$SqlQuery .= " $Field=?,";
			$WhereClause [] = $FieldValue;
		}
		$SqlQuery = rtrim ( $SqlQuery, "," );	
		$SqlQueryWhere = $this->BuildWhereClause ( $SqlQuery, $Filters );
		
		foreach ( $SqlQueryWhere [1] as $FieldValuealue ) 
		{
			$WhereClause[] = $FieldValuealue;
		}
		$PrepStatement = $this->ResetCursor ( $SqlQueryWhere [0], $WhereClause );
		
		if (isset ( $PrepStatement )) 
		{
			if ($RowsAffected) 
			{
				
				return  $PrepStatement->rowCount ();
			}
		}
	}

	public function DeleteQuick($Filters, $TableName, $RowsAffected = false) 
	{
		$SqlQuery 	= "DELETE FROM $TableName";
		$SqlQueryWhere 	= $this->BuildWhereClause ( $SqlQuery, $Filters );
		$PrepStatement 	= $this->ResetCursor ( $SqlQueryWhere [0], $SqlQueryWhere [1] );
		if ($RowsAffected === true) 
		{
			echo "" . $PrepStatement->rowCount () . " record(s) has been successfully deleted.\n\n";
		}
	}
	public function SelectQuickFields ( $Filters, $FieldList, $TableName, $Limit = '0,50000000000000', $Operator = '', $SortBy = '', $ORDER = ' ASC ', $RowsAffected = false )
	{
		if ( strlen ( $SortBy ) > 0 && strlen ( $ORDER ) > 0 )
		{
			$SortBy = " ORDER BY " . $ORDER . " " . $SortBy;
		}
		else
		{
			$SortBy = "";
		}
		if ( $Operator != '' )
		{
			$SqlQueryWhere = $this->BuildWhereClause ( "SELECT DISTINCT $FieldList FROM $TableName", $Filters, "LIKE" );
		}
		else
		{
			$SqlQueryWhere = $this->BuildWhereClause ( "SELECT DISTINCT $FieldList FROM $TableName", $Filters, "=" );
		}

		$PrepStatement = $this->ResetCursor ( $SqlQueryWhere [0] . $SortBy . " LIMIT $Limit", $SqlQueryWhere [1] );
		while ($Records = $PrepStatement->fetch ( PDO::FETCH_BOTH ))
		{
			$ResultSet[] = $Records;
		}
		if ( isset ( $ResultSet ) )
		{
			return $ResultSet;
		}
	}

	public function SelectQuick ( $Filters, $TableName, $Limit = '0,50000000000000', $Operator = '', $SortBy = '', $ORDER = ' ASC ', $RowsAffected = false )
	{
		if ( strlen ( $SortBy ) > 0 && strlen ( $ORDER ) > 0 )
		{
			$SortBy = " ORDER BY " . $ORDER . " " . $SortBy;
		}
		else
		{
			$SortBy = "";
		}
		if ( $Operator != '' )
		{
			$SqlQueryWhere = $this->BuildWhereClause ( "SELECT * FROM $TableName", $Filters, "LIKE" );
		}
		else
		{
			$SqlQueryWhere = $this->BuildWhereClause ( "SELECT * FROM $TableName", $Filters, "=" );
		}

		$PrepStatement = $this->ResetCursor ( $SqlQueryWhere [0] . $SortBy . " LIMIT $Limit", $SqlQueryWhere [1] );
		while ($Records = $PrepStatement->fetch ( PDO::FETCH_BOTH ))
		{
			$ResultSet[] = $Records;
		}
		if ( isset ( $ResultSet ) )
		{
			return $ResultSet;
		}
	}


	public function SelectQuickSort ( $Filters, $TableName, $SortBy, $ORDER = ' ASC ', $RowsAffected = false, $Limit = 1000 )
	{
		if ( strlen ( $SortBy ) > 0 )
		{
			$SortBy = " ORDER BY " . $SortBy . " " . $ORDER;
		}
		$SqlQueryWhere = $this->BuildWhereClause ( "SELECT * FROM $TableName", $Filters );
		$PrepStatement = $this->ResetCursor ( $SqlQueryWhere [0] . $SortBy . " LIMIT $Limit", $SqlQueryWhere [1] );

		while ($Records = $PrepStatement->fetch ( PDO::FETCH_BOTH ))
		{
			$ResultSet[] = $Records;
		}
		if ( isset ( $ResultSet ) )
		{
			return $ResultSet;
		}
	}

	public function BuildWhereClause ( $SqlQuery, $WhereClause, $Operator = "=" )
	{
		try
		{
			$Counter = 0;
			$CountWhereFields = count ( $WhereClause );
			$FieldValuealues = array();
			if ( $CountWhereFields > 0 )
			{
				foreach ( $WhereClause as $FieldKey => $FieldValue )
				{
					$Counter ++;
					$SqlQuery .= ($Counter == 1) ? " WHERE " : "";
					$SqlQuery .= "$FieldKey $Operator ?";
					$SqlQuery .= ($Counter >= 1) && ($Counter < $CountWhereFields) ? " AND " : "";
					$FieldValuealues [] = $FieldValue;
				}
				$SqlQueryWhere = array($SqlQuery, $FieldValuealues);
			}
			else
			{
				$SqlQueryWhere = array($SqlQuery, $FieldValuealues);
			}
			return $SqlQueryWhere;
		}
		catch (Exception $Exp)
		{
			file_put_contents($this->_ERR_FILE, $Exp->getCode () ."\n". $Exp->getFile ()."\n".$Exp->getLine ()."\n".$Exp->getMessage ()."\n".$Exp->getTraceAsString (),FILE_APPEND);
			die("BuildWhereClause");
		}
	}

	public function ResetCursor ( $Prepare, $Execute )
	{
		try
		{
			$PrepStatement = 'statement' . $this->_PREP_STATEMENT_NO;
			$this->_PREP_STATEMENT_NO ++;
			${$PrepStatement} = $this->_DB_CONNECTION->prepare ( $Prepare );
			if ( $this->_PREP_STATEMENT_NO != 1 )
			{
				${$PrepStatement}->closeCursor ();
			}
			${$PrepStatement}->execute ( $Execute );
			return ${$PrepStatement};
			${$PrepStatement} = null;
		}
		catch (Exception $Exp)
		{
//			file_put_contents($this->_ERR_FILE, $Exp->getCode () ."\n". $Exp->getFile ()."\n".$Exp->getLine ()."\n".$Exp->getMessage ()."\n".$Exp->getTraceAsString (),FILE_APPEND);
			die("Reset Cursor". $Exp->getCode () . $Exp->getFile ().$Exp->getLine ().$Exp->getMessage ().$Exp->getTraceAsString ());
		}
	}

	public function namedColumns ( $Data_Array )
	{
		return $InsertColumn = implode ( ", ", array_keys ( $Data_Array ) );
	}

	public function namedValues ( $Data_Array )
	{
		return $InsertValues = implode ( ", ", array_values ( $Data_Array ) );
	}

	public function nameParams ( $InputParams )
	{
		return ":" . $InputParams;
	}

	public function GetStringValue ( $FieldName, $Filters, $TableName )
	{
		$StringValue = "";
		$objResultSet = $this->SelectQuickSort ( $Filters, $TableName, $FieldName );
		if ( count ( $objResultSet ) > 0 )
		{
			foreach ( $objResultSet as
				$Fields )
			{
				return $Fields [$FieldName];
			}
		}
	}

	public function PopulateCombo ( $SelectedIndex, $FieldNames, $Filters, $TableName )
	{
		$ComboValue = "";
		$SqlQueryWhere = $this->BuildWhereClause ( "SELECT DISTINCT $FieldNames[0], $FieldNames[1] FROM $TableName", $Filters );
		$PrepStatement = $this->ResetCursor ( $SqlQueryWhere [0] , $SqlQueryWhere [1] );
		while ($Records = $PrepStatement->fetch ( PDO::FETCH_BOTH ))
		{
			$ResultSet[] = $Records;
		}
		foreach ( $ResultSet as	$Fields )
		{
			if ( $SelectedIndex == $Fields [$FieldNames [0]] )
			{
				$ComboValue .= '<option selected="selected" value="' . $Fields [$FieldNames [0]] . '">' . $Fields [$FieldNames [1]] . '</option>';
			}
			else
			{
				$ComboValue .= '<option value="' . $Fields [$FieldNames [0]] . '">' . $Fields [$FieldNames [1]] . '</option>';
			}
		}
		return $ComboValue;
	}

	public function PopulateComboWhereNotIn ( $SelectedIndex, $FieldNames, $Filters, $TableName )
	{
		$ComboValue = "";
		$objResultSet = $this->SelectQuickSort ( $Filters, $TableName, true, 1000, $FieldNames [1] );
		foreach ( $objResultSet as
			$Fields )
		{
			if ( $SelectedIndex == $Fields [$FieldNames [0]] )
			{
				$ComboValue .= "\n<option selected='selected' value='" . $Fields [$FieldNames [0]] . "'>" . $Fields [$FieldNames [1]] . "</option>";
			}
			else
			{
				$ComboValue .= "\n<option value='" . $Fields [$FieldNames [0]] . "'>" . $Fields [$FieldNames [1]] . "</option>";
			}
		}
		return $ComboValue;
	}

	public function PopulateComboWhere ( $SelectedIndex, $FieldNames, $Filters, $TableName )
	{
		$ComboValue = "";
		$objResultSet = $this->SelectQuickSort ( $Filters, $TableName, true, 1000, $FieldNames [1] );
		foreach ( $objResultSet as
			$Fields )
		{
			if ( $SelectedIndex == $Fields [$FieldNames [0]] )
			{
				$ComboValue .= "\n<option selected='selected' value='" . $Fields [$FieldNames [0]] . "'>" . $Fields [$FieldNames [1]] . "</option>";
			}
			else
			{
				$ComboValue .= "\n<option value='" . $Fields [$FieldNames [0]] . "'>" . $Fields [$FieldNames [1]] . "</option>";
			}
		}
		return $ComboValue;
	}

	public function GetPageUI ( $PageName )
	{
		$SqlQuery = "Select LinkId from tbllink where LinkURL='$PageName'";
		$ResultSet = $this->GenericSelect ( $SqlQuery );
		if ( $ResultSet > 0 )
		{
			foreach ( $ResultSet as
				$Fields )
			{
				return $Fields['LinkId'];
			}
		}
		else
		{
			return 0;
		}
	}

	public function UserRole ( $LinkId )
	{
		$Permission = "";
		$SqlQuery = "Select AccessType from tblpermission where UserId='" . $_COOKIE[COOKIENAME] . "' and LinkId=$LinkId";
		$ResultSet = $this->GenericSelect ( $SqlQuery );
		if ( $ResultSet > 0 )
		{
			foreach ( $ResultSet as
				$Fields )
			{
				$Permission = $Fields['AccessType'];
			}
		}
		return $Permission;
	}

	public function CurrentMonth ()
	{
		return $this->GetStringValue ( "SettingParameter", array('SettingName' => 'CURRENTMONTH'), "tblglobalsettings" );
	}

	public function PageSize ()
	{
		return $this->GetStringValue ( "SettingParameter", array('SettingName' => 'PAGESIZE'), "tblglobalsettings" );
	}

	public function PageBreak ()
	{
		return $this->GetStringValue ( "SettingParameter", array('SettingName' => 'PAGEBREAK'), "tblglobalsettings" );
	}

	public function TotalPages ( $TotalRecords )
	{
		$PAGESIZE = $this->GetStringValue ( "SettingParameter", array('SettingName' => 'PAGESIZE'), "tblglobalsettings" );
		if ( $TotalRecords >= 1 )
		{
			$TotalRecords = $TotalRecords / $PAGESIZE;
			$Position = strpos ( $TotalRecords, "." );
			if ( !$Position == "" )
			{
				$TotalRecords = intval ( $TotalRecords ) + 1;
			}
		}
		else
		{
			$TotalRecords = 0;
		}
		return $TotalRecords;
	}

	public function FormatSpells ( $TEXTDATA )
	{
		$LENGTH = strlen ( $TEXTDATA );
		$CapitalArray = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",);
		$Found = "";
		for ( $x = 1;
			$x < $LENGTH;
			$x++ )
		{
			foreach ( $CapitalArray as
				$value )
			{
				if ( $value == substr ( $TEXTDATA, $x, 1 ) )
				{
					$TEXTDATA = str_replace ( $value, " " . $value . "", $TEXTDATA );
					$x = $x + 1;
				}
			}
		}
		return $TEXTDATA;
	}

	public function ValidateSession ()
	{
		if ( !isset ( $_COOKIE [COOKIE_USERID] ) )
		{
			echo "<meta http-equiv='refresh' content='0;URL=Login.php'/>";
			exit ();
		}
		else
		{
			return $_COOKIE [COOKIENAME];
		}
	}

	public function GetPermission ( $UID, $UserId )
	{
		if ( $UID != "" && $UserId != "" )
		{
			$Filters = array('UserId' => $UserId, 'LinkId' => $UID);
			$TableName = "tblpermission";
			$Permission = Helper::GetStringValue ( "AccessType", $Filters, $TableName );
			if ( $Permission == "None" )
			{
				$ErrorTitle = "401 Unauthorized";
				$ErrorMsg = "Invalid operation, you are not authorised to access this content. Please contact your system administrator";
				header ( "Location: pgSystemError.php?ErrorTitle=" . $ErrorTitle . "&ErrorMsg=" . $ErrorMsg );
				exit ();
			}
			else
			{
				return $Permission;
			}
		}
	}

	public function PrefixLength ( $StringValue, $PrefixLength )
	{
		$PrefixString = "";
		if ( strlen ( $StringValue ) < $PrefixLength )
		{
			$Counter = $PrefixLength - strlen ( $StringValue );
			for ( $Loop = 0;
				$Loop < $Counter;
				$Loop++ )
			{
				$PrefixString.="0";
			}
		}
		$PrefixString = $PrefixString . $StringValue;
		return $PrefixString;
	}

	public function CurrentDate ()
	{
		return date ( 'Y-m-d' );
	}

	public function CurrentDateTime ()
	{
		return date ( 'Y-m-d h:i:s' );
	}

	public function AddDaysToDate ( $CurrentDateValue, $Interval )
	{
		$NewDate = new DateTime ( $CurrentDateValue );
		$NewDate->add ( new DateInterval ( $Interval ) );
		return $NewDate->format ( 'Y-m-d' );
	}

	public function Title ()
	{
		return ":: EPA - Administration ::";
	}

	public function RestCall ( $WS_UserName, $WS_Password, $WS_SEARCH_CRITERIA, $WS_URL, $ServiceName = "" )
	{
		$Curl_Request = curl_init ();
		curl_setopt ( $Curl_Request, CURLOPT_HTTPAUTH, CURLAUTH_ANY );
		curl_setopt ( $Curl_Request, CURLOPT_USERPWD, "$WS_UserName:$WS_Password" );
		curl_setopt ( $Curl_Request, CURLOPT_URL, $WS_URL );
		curl_setopt ( $Curl_Request, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $Curl_Request, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $Curl_Request, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt ( $Curl_Request, CURLOPT_SSL_VERIFYHOST, 0 );
		$InboundData = curl_exec ( $Curl_Request );
		$JSON_Object = json_decode ( $InboundData, true );
		if ( !curl_errno ( $Curl_Request ) )
		{
			$WebServiceInformation = curl_getinfo ( $Curl_Request );

			$this->DebugMode ( "<a target='_new' href='" . $WebServiceInformation['url'] . "'>Click here to resend</a>", $ServiceName . ' Service Call URL', 'text-info' );
			$this->DebugMode ( "Processed in " . $WebServiceInformation['total_time'] . " seconds with the HTTP Status Code " . $WebServiceInformation['http_code'], "Criteria: " . $this->ShortString ( str_replace ( "%20", " ", trim ( $WS_SEARCH_CRITERIA ) ), 30 ), 'text-info' );
		}
		curl_close ( $Curl_Request );
		return $JSON_Object;
	}

	public function MoneyFormat ( $Number, $Decimals )
	{
		return number_format ( $Number, $Decimals );
	}

	public function ShortString ( $FullText, $NewLength )
	{
		return substr ( $FullText, 0, $NewLength ) . "...";
	}

	function GeneratePassword ( $PasswordLength = 9, $AddDashes = false, $AvailableSets = 'luds' )
	{
		$Sets = array();
		if ( strpos ( $AvailableSets, 'l' ) !== false )
			$Sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if ( strpos ( $AvailableSets, 'u' ) !== false )
			$Sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if ( strpos ( $AvailableSets, 'd' ) !== false )
			$Sets[] = '23456789';
		if ( strpos ( $AvailableSets, 's' ) !== false )
			$Sets[] = '!@#$%&*?';
		$ResetAll = '';
		$NewPassword = '';
		foreach ( $Sets as
			$Set )
		{
			$NewPassword .= $Set[array_rand ( str_split ( $Set ) )];
			$ResetAll .= $Set;
		}
		$ResetAll = str_split ( $ResetAll );
		for ( $i = 0;
			$i < $PasswordLength - count ( $Sets );
			$i++ )
			$NewPassword .= $ResetAll[array_rand ( $ResetAll )];
		$NewPassword = str_shuffle ( $NewPassword );
		if ( !$AddDashes )
			return $NewPassword;
		$dash_len = floor ( sqrt ( $PasswordLength ) );
		$dash_str = '';
		while (strlen ( $NewPassword ) > $dash_len)
		{
			$dash_str .= substr ( $NewPassword, 0, $dash_len ) . '-';
			$NewPassword = substr ( $NewPassword, $dash_len );
		}
		return $NewPassword;
	}

	public function ExecuteSqlQuery ( $_DB_TABLE_NAME, $SQL_QUERY, $LATEST_NEWS )
	{
		$_Resultset = array();
		$ProcessingStartTime = microtime ( TRUE );
		
		$DB_Statement = $this->_DB_CONNECTION->prepare ( $SQL_QUERY );
		$DB_Statement->execute ();
		ini_set ( 'memory_limit', '512M' );
		$COUNTER = 0;
		while ($RecSet = $DB_Statement->fetch ( PDO::FETCH_ASSOC ))
		{
			$_Resultset[$COUNTER] = $RecSet;
			$COUNTER++;
		}
		$ProcessingEndTime = microtime ( TRUE );
		$ProcessingTime = number_format ( $ProcessingEndTime - $ProcessingStartTime, 2 ) . " seconds.";
		$JSON_RESPONSE['RecSet'] = $_Resultset;
		$JSON_RESPONSE['ProcessingTime'] = $ProcessingTime;
		$JSON_RESPONSE['SqlQuery'] = $SQL_QUERY;
		$JSON_RESPONSE['LatesNews'] = $LATEST_NEWS;
		return json_encode ( $JSON_RESPONSE );
	}

}

?>
