<?php

$yourEmail = "geodaticamx@gmail.com";
$yourEmailPassword = "karamazov2103";
$hostname = "{imap.gmail.com:993/ssl}INBOX";
$mailbox = imap_open($hostname, $yourEmail, $yourEmailPassword) or die('Cannot connect to Gmail: ' . imap_last_error());
/*
$mail = imap_search($mailbox, "ALL");
$mail_headers = imap_headerinfo($mailbox, $mail[0]);
$subject = $mail_headers->subject;
$from = $mail_headers->fromaddress;
imap_setflag_full($mailbox, $mail[0], "\\Seen \\Flagged");
imap_close($mailbox);
 */
?>

