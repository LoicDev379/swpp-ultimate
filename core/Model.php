<?php

class Model
{
    public static array $connections = [];
    public string $conf = "default";
    public object $db;
    public $table = false;
    public $primaryKey = "id";
    public $id;

    public function __construct()
    {
        // J'initialise quelques variables
        if ($this->table === false) {
            $this->table = strtolower(get_class($this)) . "s";
        }

        // Je me connecte a la bd
        $conf = Conf::$databases[$this->conf];
        try {
            if (isset(Model::$connections[$this->conf])) {
                $this->db = Model::$connections[$this->conf];
                return true;
            }
            $pdo = new PDO(
                "mysql:host=" . $conf["host"] . ";dbname=" . $conf["dbname"] . "",
                $conf["login"],
                $conf["passwd"],
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
                ]
            );
            Model::$connections[$this->conf] = $pdo;
            $this->db = $pdo;
        } catch (PDOException $e) {
            if (Conf::$debug >= 1) {
                $e->getMessage();
            } else {
                echo "Oups!... Impossible de se connecter a la base de donnees!";
            }
        }
    }

    /**
     * findAll      | Permet de recuperer tous les enregistrement en bd
     * @param array $req
     * @return void
     */
    public function findAll(array $req)
    {
        // Requete initiale
        $sql = "SELECT ";
        // Construction de la condition
        if (isset($req["fields"])) {
            !is_array($req["fields"])
                ? $sql .= $req["fields"]
                : implode(", ", $req["fields"]);
        } else {
            $sql .= "*";
        }
        $sql .= " FROM " . $this->table . " AS " . get_class($this);

        if (isset($req["conditions"])) {
            $sql .= " WHERE ";
            if (!is_array($req["conditions"])) {
                $sql .= $req["conditions"];
            } else {
                $cond = [];
                foreach ($req["conditions"] as $k => $v) {
                    if (!is_numeric($v)) {
                        $v = $this->db->quote($v);
                    }
                    $cond[] = "$k=$v";
                }
                $sql .= implode(" AND ", $cond);
            }
        }
        if (isset($req["limit"])) {
            $sql .= " LIMIT " . $req["limit"];
        }
        // die($sql);

        $pre = $this->db->prepare($sql);
        $pre->execute();
        return $pre->fetchAll();
    }

    /**
     * findFirst    | Permet de recuperer un enregistrement en particulier
     * @param array $req    |
     * @return void
     */
    public function findFirst(array $req)
    {
        /** @var array $array */
        $array = $this->findAll($req);
        return current($array);
    }

    /**
     * findCount    | permet de recuperer le nombre total de post (pour la pagination)
     * @param array $conditions
     * @return void
     */
    public function findCount(array $conditions)
    {
        /** @var object $res */
        $res = $this->findFirst([
            "fields" => "COUNT($this->primaryKey) AS count",
            "conditions" => $conditions
        ]);
        return $res->count;
    }

    public function save($data)
    {
        $key = $this->primaryKey;

        $fields = [];
        $d = [];
        foreach ($data as $k => $v) {
            $fields[] = " $k=:$k";
            $d[":$k"] = $v;
        }

        if (isset($data->$key) && !empty($data->$key)) {
            $sql = "UPDATE {$this->table} SET" . implode(',', $fields) . " WHERE {$key}=:{$key}";
            $this->id = $this->$key;
        }
        $pre = $this->db->prepare($sql);
        $pre->execute($d);
        $this->id = $this->db->lastInsertId();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} =" . $id;
        $this->db->query($sql);
        // $pre->execute();
    }
}
