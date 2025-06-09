<?php

class DB
{
    private static $instance = null;
    private $bindingindex = 0;
    private $bindingarray = [];
    private $type;
    private $host;
    private $port;
    private $user;
    private $password;
    private $dbname;
    private $tableName;
    private $columnNames = [];
    private $whereQuery;
    
    public $connection;
    public $statement;
    public $data;

    private function __construct()
    {
        $this->type = env('DB_TYPE');
        $this->host = env('DB_HOST');
        $this->port = env('DB_PORT', '3306');
        $this->user = env('DB_USER');
        $this->password = env('DB_PASSWORD');
        $this->dbname = env('DB_NAME');

        $dsn = "$this->type:host=$this->host;port=$this->port;dbname=$this->dbname;charset=utf8mb4";
        $this->connection = new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function table($name)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        self::$instance->resetQueryState();

        self::$instance->tableName = $name;  

        return self::$instance;
    }

    private function resetQueryState()
    {
        $this->statement = null;
        $this->data = null;
        $this->tableName = null;
        $this->columnNames = null;
        $this->whereQuery = null;
    }

    public function rawQuery($query, $value)
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($value);
        return $this;
    }

    public function column($name)
    {
        $this->columnNames = $this->columnNames ? "$this->columnNames, $name" : $name;
        return $this;
    }

    public function where($column, $operator = '=', $value = null)
    {
        if(!$value && $operator){
            $value = $operator;
            $operator = '=';
        }
        $binding_key = "value$this->bindingindex";
        $this->bindingindex++;
        $this->bindingarray[$binding_key] = $value;
        $this->whereQuery = $this->whereQuery
        ? "$this->whereQuery AND $column $operator :$binding_key"
        : "WHERE $column $operator :$binding_key";
        return $this;
    }
    
    public function orWhere($column, $operator = '=', $value = null)
    {
        if(!$value && $operator){
            $value = $operator;
            $operator = '=';
        }
        if (!$this->whereQuery) {
            die('Use where() before orWhere()');
        }
        $binding_key = "value$this->bindingindex";
        $this->bindingarray[$binding_key] = $value;
        $this->bindingindex++;
        $this->whereQuery .= " OR $column $operator :$binding_key";
        return $this;
    }
    
    public function run()
    {
        if (!$this->tableName) {
            die('Table not specified!');
        }
        
        $query = "SELECT ";
        $query .= $this->columnNames ?: '*';
        $query .= " FROM $this->tableName ";
        $query .= $this->whereQuery ?: '';
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($this->bindingarray);
        return $this;
    }
    
    public function get($type = "assoc", $clean_up = true)
    {
        $this->run();
        $fetchMode = $type === "index" ? PDO::FETCH_NUM : PDO::FETCH_ASSOC;
        $this->data = $this->statement->fetchAll($fetchMode);
        $result = $this->data;

        if ($clean_up)
            $this->resetQueryState();

        return $result;
    }

    public function first()
    {
        $this->run();
        $this->data = $this->statement->fetch(PDO::FETCH_ASSOC);
        $result = $this->data;
        $this->resetQueryState();
        return $result;
    }
    public function find($id){
        if (!$this->tableName) {
            die('Table not specified!');
        }
        $query = "SELECT ";
        $query .= $this->columnNames ?: '*';
        $query .= " FROM $this->tableName ";
        $query .= "WHERE id = :id";
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute(["id" => $id]);
        $result = $this->statement->fetch(PDO::FETCH_ASSOC);
        $this->resetQueryState();
        return $result;
    }
}
// dd(DB::table('posts')->find(2));