<?php
/**
 * LDAP entry record.
 *
 * PHP version 5
 * 
 * @category  Default 
 * @package   UNL_LDAP
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2007 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://pear.unl.edu/package/UNL_LDAP
 */
class UNL_LDAP_Entry
{
    private $_link;
    
    private $_entry;
    
    private $_attributes;
    
    function __construct(&$link, $entry)
    {
        $this->_link  = $link;
        $this->_entry = $entry;
        $this->_attributes = ldap_get_attributes($link, $entry);
    }
    
    function __isset($name)
    {
        if (isset($this->_attributes[$name])) {
            return true;
        } else {
            return false;
        }
    }
    
    function __get($name)
    {
        if (isset($this->_attributes[$name])) {
			if($this->_attributes[$name]['count'] > 1)
			{
				$all = array();
				for($i = 0; $i < $this->_attributes[$name]['count']; $i++)
				{
					$all[] = $this->_attributes[$name][$i];
				}
				return $all;
			}
			else
			{
				return $this->_attributes[$name]['0'];
			}
        }
    }
}
