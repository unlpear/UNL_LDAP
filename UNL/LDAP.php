<?php
/**
 * This file contains a class for operating with the UNL LDAP directory.
 *
 * PHP version 5
 * 
 * $Id$
 * 
 * @category  Default 
 * @package   UNL_LDAP
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2007 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://pear.unl.edu/package/UNL_LDAP
 */

/**
 * This class is a singleton class for operating with the UNL LDAP directory.
 * 
 * <code>
 * UNL_LDAP::$options['bind_dn']       = 'uid=youruseridhere,ou=service,dc=unl,dc=edu';
 * UNL_LDAP::$options['bind_password'] = 'passwordhere';
 * echo UNL_LDAP::getConnection()->getFirstAttribute('bbieber2', 'sn');
 * </code>
 * 
 * @category  Default 
 * @package   UNL_LDAP
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2007 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://pear.unl.edu/package/UNL_LDAP
 */
class UNL_LDAP
{
    /**
     * Singleton instance of UNL_LDAP
     *
     * @var UNL_LDAP
     */
    private static $_connection;
    
    /**
     * The actual ldap connection link id.
     *
     * @var link
     */
    private static $_ldap;
    
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
        UNL_LDAP::$_ldap = ldap_connect(UNL_LDAP::$options['uri']);
        ldap_bind(UNL_LDAP::$_ldap, UNL_LDAP::$options['bind_dn'], UNL_LDAP::$options['bind_password']);
    }

    /**
     * disallow cloning
     * 
     * @return void
     */
    private function __clone()
    {
        
    }
    
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
        if (self::$_connection === null) {
            self::$_connection = new self;
        }
        return self::$_connection;
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
        $result = ldap_search(self::$_ldap, self::$options['suffix'], "uid=$uid");
        $info   = ldap_get_entries(self::$_ldap, $result);
        
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
    
    /**
     * Search the directory for matching entries.
     *
     * @param string $base   Search base
     * @param string $filter LDAP filter to use
     * @param array  $params Optional parameters to add to the LDAP query
     * 
     * @return UNL_LDAP_Result
     */
    public function search($base = null, $filter = null, array $params = array())
    {
        include_once 'UNL/LDAP/Result.php';
        /* setting searchparameters  */
        (isset($params['sizelimit']))  ? $sizelimit  = $params['sizelimit']  : $sizelimit = 0;
        (isset($params['timelimit']))  ? $timelimit  = $params['timelimit']  : $timelimit = 0;
        (isset($params['attrsonly']))  ? $attrsonly  = $params['attrsonly']  : $attrsonly = 0;
        (isset($params['attributes'])) ? $attributes = $params['attributes'] : $attributes = array();
        
        $sr = ldap_search(self::$_ldap, $base, $filter, $attributes, $attrsonly, $sizelimit, $timelimit);
        return new UNL_LDAP_Result(self::$_ldap, $sr);
    }
    
    /**
     * return the ldap connection
     *
     * FIXME
     * 
     * @return mixed
     */
    function __toString()
    {
        return self::$ldap;
    }
}
