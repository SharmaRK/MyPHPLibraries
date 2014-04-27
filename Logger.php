<?php
class Logger
{
	private $fileName;
	private $fileHandle;
	private $logArray = array();

	function __construct($logFileName)
	{
		date_default_timezone_set("Asia/Kolkata");
		$this->fileName = getcwd() . "/" . $logFileName;
		if ( file_exists($this->fileName) )
		{
			//If filesize is greater than 1 MB, back it up
			if( filesize($this->fileName) > 1048576 )
			{
				$newFileName = $this->fileName . "." . date('Y-m-d');
				rename($this->fileName, $newFileName);
			}
		}
	}

	function log($data)
	{
		$currentDate = date('Y-m-d H:i:s');
		$logData = $currentDate . " - " . $data . "\n";
		array_push($this->logArray, $logData);
		//fwrite($this->fileHandle, $logData);
	}

	function __destruct()
	{
		$this->fileHandle = fopen( $this->fileName, 'a');
		foreach ($this->logArray as $logLine)
		{
			fwrite($this->fileHandle, $logLine);
		}
		fclose($this->fileHandle);
	}
}
