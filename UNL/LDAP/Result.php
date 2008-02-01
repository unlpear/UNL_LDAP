<?php
/**
 * LDAP result record
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
require_once 'UNL/LDAP/Entry.php';

class UNL_LDAP_Result implements Countable, Iterator
{
    private $_link;

    private $_result;
    
    private $_valid = false;
    
    private $_currentEntry = false;
    
    function rewind()
    {
        $this->_currentEntry = ldap_first_entry($this->_link, $this->_result);
    }
    
    function current()
    {
        return new UNL_LDAP_Entry($this->_link, $this->_currentEntry);
    }
    
    function next()
    {
        if ($this->_currentEntry !== false 
            && $this->_currentEntry = ldap_next_entry($this->_link, $this->_currentEntry)) {
            return $this->current();
        } else {
            $this->_valid = false;
            return false;
        }
    }
    
    function key()
    {
        //FIXME
        return $this->_currentEntry;
    }
    
    function valid()
    {
        return $this->_valid;
    }
    
    public function count()
    {
        return ldap_count_entries($this->_link, $this->_result);
    }
    
    public function __construct(&$link, &$result)
    {
        $this->_link   = $link;
        $this->_result = $result;
        $this->_valid  = true;
        $this->_currentEntry = ldap_first_entry($this->_link, $this->_result);
    }
    
    function __destruct()
    {
        unset($this->_currentEntry);
        @ldap_free_result($this->_result);
    }
    
    /**
     * Sort the returned results by a specific attribute
     *
     * @param string $attr Attribute to sort by
     */
    public function sort($attr)
    {
        if (!ldap_sort($this->_link, $this->_result, $attr)) {
            throw new Exception('Failed to sort by '.$attr);
        }
    }
}
