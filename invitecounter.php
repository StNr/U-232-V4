<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                			    |
 |--------------------------------------------------------------------------|
 |   Licence Info: GPL			                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V4					    |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless,putyn.					    |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
// Achievements mod by MelvinMeow
require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (CLASS_DIR . 'page_verify.php');
require_once (INCL_DIR . 'user_functions.php');
dbconn();
loggedinorreturn();
$newpage = new page_verify();
$newpage->check('takecounts');
$res = sql_query("SELECT COUNT(*) FROM users WHERE enabled = 'yes' AND invitedby =" . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
$arr3 = mysqli_fetch_row($res);
$invitedcount = $arr3['0'];
sql_query("UPDATE usersachiev SET invited=" . sqlesc($invitedcount) . " WHERE id=" . sqlesc($CURUSER['id'])) or sqlerr(__FILE__, __LINE__);
header("Location: {$INSTALLER09['baseurl']}/index.php");
?>
