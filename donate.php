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
require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bittorrent.php');
require_once (INCL_DIR . 'user_functions.php');
require_once (INCL_DIR . 'bbcode_functions.php');
require_once (INCL_DIR . 'html_functions.php');
require_once (CACHE_DIR . 'paypal_settings.php');
dbconn(false);
loggedinorreturn();
$lang = array_merge(load_language('global'));
$nick = ($CURUSER ? $CURUSER["username"] : ("Guest" . rand(1000, 9999)));
$form_template = <<<PAYPAL
<form action='https://www.{$INSTALLER09['paypal_config']['sandbox']}paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='business' value='{$INSTALLER09['paypal_config']['email']}' />
<input type='hidden' name='cmd' value='_xclick' />
<input type='hidden' name='amount' value='#amount' />
<input type='hidden' name='item_name' value='#item_name' />
<input type='hidden' name='item_number' value='#item_number' />
<input type='hidden' name='currency_code' value='{$INSTALLER09['paypal_config']['currency']}' />
<input type='hidden' name='no_shipping' value='1' />
<input type='hidden' name='notify_url' value='{$INSTALLER09['baseurl']}/donatecheck.php' />
<input type='hidden' name='rm' value='2' />
<input type='hidden' name='custom' value='#id' />
<input type='hidden' name='return' value='{$INSTALLER09['baseurl']}/donate.php?done=1' />
<input type='submit' value='Donate #amount {$INSTALLER09['paypal_config']['currency']}' />
</form>
PAYPAL;
//this shows what they get
$donate = array(
    $INSTALLER09['paypal_config']['gb_donated_1'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_1'].' week',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_1'].' week',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_1'].' wk',
        ''.$INSTALLER09['paypal_config']['up_amt_1'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_1'].' bonus points',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_1'].' week',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_1'].' week'
    ) ,
    $INSTALLER09['paypal_config']['gb_donated_2'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_2'].' weeks',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_2'].' weeks',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_2'].' wks',
        ''.$INSTALLER09['paypal_config']['up_amt_2'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_2'].' bonus points',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_2'].' weeks',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_2'].' weeks'
    ) ,
    $INSTALLER09['paypal_config']['gb_donated_3'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_3'].' weeks',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_3'].' weeks',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_3'].' wks',
        ''.$INSTALLER09['paypal_config']['up_amt_3'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_3'].' bonus points',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_3'].' weeks',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_3'].' weeks'
    ) ,
    $INSTALLER09['paypal_config']['gb_donated_4'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_4'].' weeks',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_4'].' weeks',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_4'].' wks',
        ''.$INSTALLER09['paypal_config']['up_amt_4'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_4'].' bonus points',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_4'].' weeks',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_4'].' weeks'
    ) ,
    $INSTALLER09['paypal_config']['gb_donated_5'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_5'].' weeks',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_5'].' weeks',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_5'].' wks',
        ''.$INSTALLER09['paypal_config']['up_amt_5'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_5'].' bonus points',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_5'].' weeks',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_5'].' weeks'
    ) ,
    $INSTALLER09['paypal_config']['gb_donated_6'] => array(
        'ViP '.$INSTALLER09['paypal_config']['vip_dur_6'].' weeks',
        'Donor '.$INSTALLER09['paypal_config']['donor_dur_6'].' weeks',
        'Freeleech '.$INSTALLER09['paypal_config']['free_dur_6'].' wks',
        ''.$INSTALLER09['paypal_config']['up_amt_6'].'G upload',
        ''.$INSTALLER09['paypal_config']['kp_amt_6'].' bonus points',
        'Donor star '.$INSTALLER09['paypal_config']['duntil_dur_6'].' weeks',
        'Imunnity '.$INSTALLER09['paypal_config']['imm_dur_6'].' weeks'
    ) ,
);
$done = isset($_GET['done']) && $_GET['done'] == 1 ? true : false;
if ($INSTALLER09['paypal_config']['enable'] == 0 ) {
$out = stdmsg('Sorry','Donation system is currently offline.');
} else {
$out = begin_main_frame() . ($done ? stdmsg('Success', 'Your donations was sent to paypal wait for processing, this should be immediately! If any errors appear youll be contacted by someone from staff') : '') . begin_frame('Donate') . '<table width=\'80%\' align=\'center\' cellpadding=\'2\' cellspacing=\'3\'><tr>';
foreach ($donate as $amount => $ops) {
    $out.= '<td align=\'center\' valign=\'top\'><table cellpadding=\'2\'>
			  <tr><td class=\'colhead\' align=\'center\'>Donate ' . $amount . ' ' . $INSTALLER09['paypal_config']['currency'] . '</td></tr>
			  <tr><td align=\'left\'><ul style=\'margin-left: 0px;padding-left:15px\'>';
    foreach ($ops as $op) $out.= '<li>' . $op . '</li>';
    $out.= '</ul></td></tr><tr><td align=\'center\'>' . str_replace(array(
        '#amount',
        '#item_name',
        '#item_number',
        '#id'
    ) , array(
        $amount,
        $nick,
        $amount,
        $CURUSER['id']
    ) , $form_template);
    $out.= '</td></tr></table></td>';
}
$out.= '</tr></table>' . end_frame() . stdmsg('Note', 'If you want to say something to ' . $INSTALLER09['site_name'] . ' staff, click on <b>Add special instructions to seller</b> link as soon as you are on paypal.com page' . '      Please note donating will reset Hit and Runs, any warnings and download bans.') . end_main_frame();
}
echo (stdhead('Donate') . $out . stdfoot());
?>
