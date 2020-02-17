<?php

namespace App;

require __DIR__. '/DB.php';

/**
 * Class Collection
 */
class Collection
{
    use Database;

//    protected $fillable = null;
//    protected $table = 'tickets';

    public function paginate ($n) {
        $this->pagin = $n;
        return $this;
    }

    public function get ($id = null) {
        $limit = '';
        if (@$this->pagin) {
            $p = (@$_REQUEST['p']) ? @$_REQUEST['p'] : 1;
            $page = (filter_var($p, FILTER_SANITIZE_NUMBER_INT) > 1) ? filter_var($p, FILTER_SANITIZE_NUMBER_INT) : 1;
            $offset = ($page-1) * $this->pagin;
            $limit = ' limit ' . $offset . ',' . $this->pagin;
        }
        $sort = '';
        if (in_array(@$_REQUEST['sort'], $this->fillable)) {
            $sort = ' order by ' . $_REQUEST['sort'];
            if (in_array(@$_REQUEST['direction'], ['asc', 'desc']))
                $sort .= ' ' . $_REQUEST['direction'];
        }
            $where = '';
        if ($id)
            if (is_array($id)) {
                $where = ' where id in ('.implode(', ', $id).')';
            } else {
                $where = ' where id='.(int)$id;
            }
        mysqli_query($this->db(), 'SET NAMES UTF8');
        $result = $this->db()->query('select * from ' . $this->table . $where . $sort . $limit);
        $arr_result = [];
        foreach ($result as $row)
            $arr_result[] = $row;

        if(@$this->pagin) {
            $cnt = $this->db()->query('select * from ' . $this->table . $where . $sort)->num_rows;
            $this->pages = $cnt / $this->pagin;
            if ($cnt % $this->pagin) $this->pages++;
        }
        return $arr_result;
    }

    public function pagination () {
        $pages = '<div class="pagination mt-5">';
        for ($i=1; $i<=$this->pages; $i++)
            $pages .= '<a class="mr-4 '.((@$_REQUEST['p']==$i) ? 'selected' : '').'" href="?p='.$i.'">'.$i.'</a>';
        $pages .= '</div>';
        return $pages;
    }

    /**
     * Добавляет запись в бд
     * @return bool|\mysqli_result
     */
    public function save () {
        if (count($this->fillable) > 0) {
            $fields = implode(', ', $this->fillable);
            $values = [];
            foreach ($this->fillable as $field)
                $values[] = $this->$field;
            $values = "'" . implode("', '", $values) . "'";
            $query = "insert into $this->table ($fields) values ($values)";
            mysqli_query($this->db(), 'SET NAMES UTF8');
            return $this->db()->query($query);
        }
        return false;
    }
}

global $user_name;
global $user_hash;

$user_name = 'admin';
$user_hash = '24c05ce1409afb5dad4c5bddeb924a4bc3ea00f5';

function isAdmin () {
    global $user_hash;
    global $user_name;
    if (@$_COOKIE['user_password'] == $user_hash && @$_COOKIE['user_name'] == $user_name)
        return true;
    return false;
}


/**
 * models
 */
$models_path = __DIR__ . '/../models/';
$models = [];
foreach (scandir($models_path) as $row)
    if (strpos($row, '.php') !== false)
        $models[] = $row;
foreach ($models as $model)
    require $models_path . $model;


/**
 * @param $name
 * @param array $params
 */
function view ($name, $params = []) {
    if ( count($params) > 0 )
        foreach ($params as $key => $value) {
            global $$key;
            $$key = $value;
        }
    require __DIR__ . '/../view/' . $name . '.php';
    die();
}


/**
 * Роутер
 */
if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
    require __DIR__ . '/../controllers/admin_controllers.php';
} else if ($_SERVER['REQUEST_URI'] == '/' || strpos($_SERVER['REQUEST_URI'], '/?') == 0) {
    require __DIR__ . '/../controllers/main_controllers.php';
} else {
    require __DIR__ . '/../controllers/404_controllers.php';
}