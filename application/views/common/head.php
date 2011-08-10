<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<title><?php 
	if(!empty($page_title))
		echo htmlentities($page_title);
	?></title>
	
	<meta name="Keywords" content="<?php
		if(!empty($keywords)) echo htmlspecialchars($keywords);
	?>" />
	<meta name="Description" content="<?php
		if(!empty($description)) echo htmlspecialchars($description);
	?>" />
