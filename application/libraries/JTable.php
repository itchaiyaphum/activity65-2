<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class JTable extends JObject
{
    public $_tbl = '';

    public $_tbl_key = '';

    public $_nameQuote = '`';

    public $_db = null;
    
    public $_status_key = 'status';

    public function __construct($table=null, $key=null, &$db=null)
    {
        $this->_tbl = $table;
        $this->_tbl_key = $key;
        $this->_db = & $db;
    }

    public function &getInstance($type, $prefix = 'Table', $db = null)
    {
        $false = false;
        
        $type = preg_replace('/[^A-Z0-9_\.-]/i', '', $type);
        $tableClass = $prefix . ucfirst($type);
        
        if (is_null($db)) {
            $ci = & get_instance();
            $db = $ci->db;
        }
        $instance = new $tableClass($db);
        
        return $instance;
    }

    public function setStatusKey($key='status')
    {
        return $this->_status_key = $key;
    }
    
    public function &getDBO()
    {
        return $this->_db;
    }

    public function setDBO(&$db)
    {
        $this->_db = & $db;
    }

    public function getTableName()
    {
        return $this->_tbl;
    }

    public function getKeyName()
    {
        return $this->_tbl_key;
    }

    public function reset()
    {
        $k = $this->_tbl_key;
        foreach ($this->getProperties() as $name => $value) {
            if ($name != $k) {
                $this->$name = $value;
            }
        }
    }

    public function bind($from, $ignore = array())
    {
        $fromArray = is_array($from);
        $fromObject = is_object($from);
        
        if (! $fromArray && ! $fromObject) {
            $this->setError(get_class($this).'::bind failed. Invalid from argument');
            return false;
        }
        if (!is_array($ignore)) {
            $ignore = explode(' ', $ignore);
        }
        foreach ($this->getProperties() as $k => $v) {
            // internal attributes of an object are ignored
            if (!in_array($k, $ignore)) {
                if ($fromArray && isset($from[$k])) {
                    $this->$k = $from[$k];
                } elseif ($fromObject && isset($from->$k)) {
                    $this->$k = $from->$k;
                }
            }
        }
        return true;
    }

    public function load($oid=null)
    {
        $k = $this->_tbl_key;

        if ($oid !== null) {
            $this->$k = $oid;
        }

        $oid = $this->$k;

        if ($oid === null) {
            return false;
        }
        $this->reset();

        $db =& $this->getDBO();

        $sql = "SELECT * FROM {$this->_tbl} WHERE {$this->_tbl_key} = ? ";
        $query = $db->query($sql, array($oid));

        if ($result = $query->row()) {
            return $this->bind($result);
        } else {
            return false;
        }
    }

    public function check()
    {
        return true;
    }


    public function store($updateNulls=false)
    {
        $k = $this->_tbl_key;

        if ($this->$k) {
            $ret = $this->updateObject($this->_tbl, $this, $this->_tbl_key, $updateNulls);
        } else {
            $ret = $this->insertObject($this->_tbl, $this, $this->_tbl_key);
        }
        if (!$ret) {
            return false;
        } else {
            return true;
        }
    }
    

    private function nameQuote($s)
    {
        // Only quote if the name is not using dot-notation
        if (strpos($s, '.') === false) {
            $q = $this->_nameQuote;
            if (strlen($q) == 1) {
                return $q . $s . $q;
            } else {
                return $q{0} . $s . $q{1};
            }
        } else {
            return $s;
        }
    }
    
    private function insertObject($table, &$object, $keyName = null)
    {
        $fmtsql = 'INSERT INTO '.$this->nameQuote($table).' ( %s ) VALUES ( %s ) ';
        $fields = array();
        foreach (get_object_vars($object) as $k => $v) {
            if (is_array($v) or is_object($v) or $v === null) {
                continue;
            }
            if ($k[0] == '_') { // internal field
                continue;
            }
            $fields[] = $this->nameQuote($k);
            $values[] = $this->_db->escape($v);
        }
        $result = $this->_db->query(sprintf($fmtsql, implode(",", $fields), implode(",", $values)));
        if (!$result) {
            return false;
        }
        $id = $this->_db->insert_id();
        if ($keyName && $id) {
            $object->$keyName = $id;
        }
        return true;
    }

    private function updateObject($table, &$object, $keyName, $updateNulls=true)
    {
        $fmtsql = 'UPDATE '.$this->nameQuote($table).' SET %s WHERE %s';
        $tmp = array();
        foreach (get_object_vars($object) as $k => $v) {
            if (is_array($v) or is_object($v) or $k[0] == '_') { // internal or NA field
                continue;
            }
            if ($k == $keyName) { // PK not to be updated
                $where = $keyName . '=' . $this->_db->escape($v);
                continue;
            }
            if ($v === null) {
                if ($updateNulls) {
                    $val = 'NULL';
                } else {
                    continue;
                }
            } else {
                $val = $this->_db->escape($v);
            }
            $tmp[] = $this->nameQuote($k) . '=' . $val;
        }
        return $this->_db->query(sprintf($fmtsql, implode(",", $tmp), $where));
    }

    public function delete($oid=null)
    {
        $k = $this->_tbl_key;
        if ($oid) {
            $this->$k = intval($oid);
        }

        if ($this->_db->delete($this->_tbl, array($this->_tbl_key => $this->$k))) {
            return true;
        } else {
            return false;
        }
    }

    public function save($source, $ignore='', $order_filter='')
    {
        if (!$this->bind($source, $ignore)) {
            return false;
        }
        if (!$this->check()) {
            return false;
        }
        if (!$this->store()) {
            return false;
        }
        $this->setError('');
        return true;
    }
    
    public function publish($id=null, $publish=1)
    {
        $this->_db->where('id', $id);
        $this->_db->set($this->_status_key, $publish);
        $result = $this->_db->update($this->_tbl);

        if (!$result) {
            return false;
        }

        return true;
    }
}
