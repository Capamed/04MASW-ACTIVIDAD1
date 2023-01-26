<?php
    class especialidadModel{
        private $connection;
        
        public function __construct(){
            $host        = "host = isilo.db.elephantsql.com";
            $port        = "port = 5432";
            $dbname      = "dbname = ditixdvr";
            $credentials = "user = ditixdvr password=qya9L-taxxskDijE45c8_H711i4GulyE";

            $this->connection = pg_connect("$host $port $dbname $credentials");
            if(!$this->connection) {
                return "Error : Unable to open database\n";
            }
        }

        public function create($idEspecialidad,$nombreEspecialidad){
            $consultSQL="insert into especialidad values (".$idEspecialidad.",'".$nombreEspecialidad."')";
            $result=pg_query($this->connection, $consultSQL);

            if(!$result) {
                echo pg_last_error($this->connection);
                return false;
            } else {
                return $idEspecialidad;
            }  
        }

        public function read($idEspecialidad){
            if ($idEspecialidad==0){
                $consultSQL="select * from especialidad";
            }else{
                $consultSQL="select * from especialidad where id_especialidad=".$idEspecialidad."";
            }
            
            $result=pg_query($this->connection, $consultSQL);

            if(!$result) {
                echo pg_last_error($this->connection);
                return false;
            } else {
                return pg_fetch_all($result,PGSQL_NUM);
            }  
        }

        public function update($idEspecialidad,$nombreEspecialidad){
            $consultSQL="update especialidad set nombre='".$nombreEspecialidad."' where id_especialidad=".$idEspecialidad.")";
            echo $consultSQL;        
            $result=pg_query($this->connection, $consultSQL);

            if(!$result) {
                echo pg_last_error($this->connection);
                return false;
            } else {
                return $idEspecialidad;
            }  
        }
        
        public function delete($idEspecialidad){
            $consultSQL="delete from especialidad where id_especialidad=".$idEspecialidad."";
            $result=pg_query($this->connection, $consultSQL);
        
            if(!$result) {
                echo pg_last_error($this->connection);
                return false;
            } else {
                return true;
            }  
        }
    }
?>