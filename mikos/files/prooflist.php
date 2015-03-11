<?php
	include(dirname(dirname(__FILE__))."/libs/class.KIS.php");
	include(dirname(dirname(__FILE__))."/libs/class.CPIS.php");
	
	session_start();
	include("../cpis.php");

	// load cpis and prooflist data
	$_SESSION['cpis']->requireLogin();
	$myProofList = $_SESSION['cpis']->call('getProoflistDetail',array('prooflistId'=>$_GET['pid'],'withPDF' => true));
	
	//close session to enable changing header
	session_write_close();

	// display pdf bytestream
	ob_start();
	
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);

    $mimetype = substr($myProofList->fileName, -3) == 'xls' ? 'application/vnd.ms-excel' : 'application/pdf';

	header("Content-Type: ".$mimetype);
	header("Content-Disposition: attachment; filename=\"".$myProofList->fileName."\"");
	header("Content-Transfer-Encoding: binary");
    
	print($myProofList->pdfFile);