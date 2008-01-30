<?php
require_once 'UNL/LDAP.php';

UNL_LDAP::$options['binddn']        = 'uid=youruidhere,ou=service,dc=unl,dc=edu';
UNL_LDAP::$options['bind_password'] = 'yourpasswordhere';
?>