<?php
/**
 * LDAP entry class.
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

require_once 'UNL/LDAP/Entry/Attribute.php';

/**
 * Class for handling an ldap entry
 * 
 * @category  Default 
 * @package   UNL_LDAP
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://pear.unl.edu/package/UNL_LDAP
 */
class UNL_LDAP_Entry
{
    
    protected $_attributes;
    
    /**
     * Construct an LDAP entry object
     *
     * @param resource &$link LDAP connection
     * @param resource $entry Entry resource from ldap_next_entry
     */
    function __construct(&$link, $entry)
    {
        $this->_attributes = ldap_get_attributes($link, $entry);
    }
    
    /**
     * Determines if a specific attribute is set
     *
     * @param string $name Attribute name to check
     * 
     * @return bool
     */
    function __isset($name)
    {
        if (isset($this->_attributes[$name])) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Retrieve the requested attribute
     *
     * @param string $name Attribute to get
     * 
     * @return UNL_LDAP_Entry_Attribute
     */
    function __get($name)
    {
        if (isset($this->_attributes[$name])) {
            return new UNL_LDAP_Entry_Attribute($this->_attributes[$name]);
        }
    }
}
