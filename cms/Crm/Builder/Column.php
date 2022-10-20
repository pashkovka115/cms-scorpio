<?php
namespace Crm\Builder;

class Column{
    private $sql = '';
    private $id_name;


    public function id(string $name = 'id', int $length = 11)
    {
        $this->id_name = $name;
        $sql = "\n$name INT($length) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,";
        $this->sql .= $sql;

        return $this;
    }

    public function string(string $name, int $length = 255)
    {
        $sql = "\n$name VARCHAR($length) NOT NULL,";
        $this->sql .= $sql;

        return $this;
    }

    public function text(string $name)
    {
        $sql = "\n$name TEXT NOT NULL,";
        $this->sql .= $sql;

        return $this;
    }

    public function enum(string $name, array $items)
    {
        $values = '';
        foreach($items as $item){
            $values .= "'$item', ";
        }
        $sql = "\n$name ENUM(".rtrim($values, ', ').") NOT NULL,";
        $this->sql .= $sql;

        return $this;
    }


    public function boolean(string $name, array $val = [1,0])
    {
        $this->enum($name, $val);

        return $this;
    }


    public function decimal(string $name, int $accuracy = 5, int $scale = 2)
    {
        $sql = "\n$name DECIMAL($accuracy, $scale) NOT NULL,";
        $this->sql .= $sql;

        return $this;
    }

    public function integer(string $name, int $length = 11)
    {
        $sql = "\n$name INT($length) NOT NULL,";
        $this->sql .= $sql;

        return $this;
    }

    public function tinyint(string $name, int $length = 3)
    {
        $sql = "\n$name TINYINT($length) NOT NULL,";
        $this->sql .= $sql;

        return $this;
    }

    public function bigint(string $name, int $length = 11)
    {
        $sql = "\n$name BIGINT($length) NOT NULL,";
        $this->sql .= $sql;

        return $this;
    }

    public function timestamps(string $name)
    {
        // $sql = "\n$name BIGINT($length) NOT NULL,";
        // $this->sql .= $sql;

        // return $this;
    }

    public function timestamp(string $name)
    {
        /* $sql = "\n$name BIGINT($length) NOT NULL,";
        $this->sql .= $sql;

        return $this; */
    }


    public function foreignKey(string $foreign_table, string $foreign_field, string $references_table, string $references_field)
    {
        $sql = '';
        $constraint = $foreign_table . '_' . $foreign_field . '_' . $references_table . '_' . $references_field . '_fk';
        $sql .= "\nCONSTRAINT $constraint";
        $sql .= "\nFOREIGN KEY ($foreign_field)  REFERENCES $references_table ($references_field), ";
        $this->sql .= $sql;

        return $this;
    }


/* ========================================================== */
    protected function getSql()
    {
        return rtrim($this->sql, ', ');
    }

    public function getColumns(){
        return $this->getSql();
    }

    public function nullable()
    {
        $sp = explode(',', $this->getSql());
        $sp[count($sp) - 1] = str_replace('NOT NULL', 'NULL', $sp[count($sp) - 1]);
        $this->sql = implode(',', $sp) . ',';

        return $this;
    }


    public function unique()
    {
        $sp = explode(',', $this->getSql());
        $sp[count($sp) - 1] = str_replace('NOT NULL', 'UNIQUE NOT NULL', $sp[count($sp) - 1]);
        $this->sql = implode(',', $sp) . ',';

        return $this;
    }


    public function unsigned()
    {
        $sp = explode(',', $this->getSql());
        $sp[count($sp) - 1] = str_replace('NOT NULL', 'UNSIGNED NOT NULL', $sp[count($sp) - 1]);
        $this->sql = implode(',', $sp) . ',';

        return $this;
    }
}
