<?php
/**
 * LDAP attribute object
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
class UNL_LDAP_Entry_Attribute implements Countable, Iterator
{
    private $_attribute;
    
    private $_valid = false;
    
    private $_currentEntry = false;
    
    public function __construct(array $attribute)
    {
        $this->_attribute    = $attribute;
        $this->_valid        = true;
        $this->_currentEntry = 0;
    }
    
    function current()
    {
        return $this->_attribute[$this->_currentEntry];
    }
    
    function next()
    {
        if ($this->_currentEntry !== false 
            && $this->_currentEntry < $this->count()-1) {
            $this->_currentEntry ++;
            return $this->current();
        } else {
            $this->_valid = false;
            return false;
        }
    }
    
    public function rewind()
    {
        $this->_currentEntry = 0;
    }
    
    public function key()
    {
        return $this->_currentEntry; 
    }
    
    public function valid()
    {
        return $this->_valid;
    }
    
    public function count()
    {
        return $this->_attribute['count'];
    }
    
    public function __toString()
    {
        return $this->current();
    }
}