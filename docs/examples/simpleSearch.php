<?php
chdir(dirname(__FILE__).'/../../');
require_once 'UNL/LDAP.php';
require_once 'config.inc.php';

$ldap   = UNL_LDAP::getConnection();
$result = $ldap->search('dc=unl,dc=edu', '(|(sn=ryan lim)(cn=ryan lim)(&(| (givenname=ryan) (sn=ryan) (mail=ryan) (unlemailnickname=ryan) (unlemailalias=ryan))(| (givenname=lim) (sn=lim) (mail=lim) (unlemailnickname=lim) (unlemailalias=lim))))');

$result->sort('uid');

echo $result->count().' results found.'.PHP_EOL;

foreach ($result as $entry) {
    echo $entry->givenName.' '.$entry->sn.' is '.$entry->uid.PHP_EOL;
    if (count($entry->objectClass)) {
        echo $entry->givenName.' is a member of:';
        foreach ($entry->objectClass as $class) {
            echo $class.',';
        }
        echo PHP_EOL;
    }
}