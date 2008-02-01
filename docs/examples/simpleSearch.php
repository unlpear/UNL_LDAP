<?php
chdir(dirname(__FILE__).'/../../');
require_once 'UNL/LDAP.php';
require_once 'config.inc.php';

$ldap   = UNL_LDAP::getConnection();
$result = $ldap->search('dc=unl,dc=edu', '(|(sn=brett bieber)(cn=brett bieber)(&(| (givenname=brett) (sn=brett) (mail=brett) (unlemailnickname=brett) (unlemailalias=brett))(| (givenname=bieber) (sn=bieber) (mail=bieber) (unlemailnickname=bieber) (unlemailalias=bieber))))');

echo $result->count().' results found.'.PHP_EOL;

foreach ($result as $entry) {
    echo $entry->givenName.' '.$entry->sn.' is '.$entry->uid.PHP_EOL;
}