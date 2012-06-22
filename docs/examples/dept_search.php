<?php
/**
 * This file conducts a simple ldap search
 *
 * PHP version 5
 * 
 * $Id$
 * 
 * @category  Default 
 * @package   UNL_LDAP
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://pear.unl.edu/package/UNL_LDAP
 */
highlight_file(__FILE__);
set_include_path(realpath(dirname(__FILE__).'/../..'));
require_once 'UNL/LDAP.php';
require_once 'config.inc.php';

$ldap   = UNL_LDAP::getConnection($options);

$results = $ldap->search('dc=unl,dc=edu',
'(
    &
    (eduPersonAffiliation=faculty)
    (
        |
        (unlHROrgUnitNumber=50000908)
        (unlHROrgUnitNumber=50001035)
        (unlHROrgUnitNumber=50001036)
        (unlHROrgUnitNumber=50001037)
    )
)');
$results->sort('sn');

echo count($results).' results found.'.PHP_EOL;

echo "<pre>Last Name,First Name,Title,Department,Email\n";

foreach ($results as $dn=>$entry) {
    echo "$entry->sn,$entry->givenName,$entry->title,$entry->unlHRPrimaryDepartment,$entry->mail\n";
}

