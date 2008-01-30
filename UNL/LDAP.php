<?php
/**
 * This class is a singleton class for operating with the UNL LDAP directory.
 * 
 * <code>
 * UNL_LDAP::$options['binddn']        = 'uid=youruseridhere,ou=service,dc=unl,dc=edu';
 * UNL_LDAP::$options['bind_password'] = 'passwordhere';
 * echo UNL_LDAP::getConnection()->getFirstAttribute('bbieber2', 'sn');
 * </code>
 *
 */
class UNL_LDAP
{
    /**
     * Singleton instance of UNL_LDAP
     *
     * @var UNL_LDAP
     */
    private static $connection;
    
    /**
     * The actual ldap connection link id.
     *
     * @var link
     */
    private static $ldap;
    
    /**
     * @var array
     */
    public static $options = array( 'uri'           => 'ldap://ldap.unl.edu:389/',
                                    'base'          => 'dc=unl,dc=edu',
                                    'suffix'        => 'ou=People,dc=unl,dc=edu',
                                    'bind_dn'       => 'get this from the identity management team',
                                    'bind_password' => 'get this from the identity management team');
    
    /**
     * singleton
     * 
     * <code>
     * UNL_LDAP::getConnection()->getAttribute('bbieber','cn');
     * </code>
     *
     */
    private function __construct()
    {
        $this->ldap = ldap_connect(UNL_LDAP::$options['uri']);
        ldap_bind($this->ldap, UNL_LDAP::$options['binddn'], UNL_LDAP::$options['bind_password']);
    }

    private function __clone() {}
    
    /**
     * Get the LDAP connection
     * 
     * <code>
     * $conn = UNL_LDAP::getConnection();
     * </code>
     *
     * @return UNL_LDAP
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
          self::$connection = new self;
        }
        return self::$connection;
    }
    
    /**
     * Get an attribute from LDAP given the LDAP-uid and attribute name.
     *
     * @param string $uid       The LDAP-uid of the user we are looking for.
     * @param string $attribute The attribute name we are interested in.
     * 
     * @return array The array of attribute values.
     */
    public function getAttribute($uid, $attribute)
    {
        $uid    = addslashes($uid);
        $result = ldap_search(self::getConnection()->ldap, self::$options['suffix'], "uid=$uid");
        $info   = ldap_get_entries(self::getConnection()->ldap, $result);
        
        if (count($info) == 0) {
            return false;
        } else {
            if (isset($info[0][$attribute])) {
                return $info[0][$attribute];
            } else {
                return false;
            }
        }
    }
    
    /**
     * Return the first attribute of an entry
     *
     * @param string $uid       The LDAP uid of the user we are looking for.
     * @param string $attribute The attribute name we are interested in.
     * 
     * @return string | false
     */
    public function getFirstAttribute($uid, $attribute)
    {
        if ($ret = $this->getAttribute($uid, $attribute)) {
            return $ret[0];
        } else {
            return false;
        }
    }
}
