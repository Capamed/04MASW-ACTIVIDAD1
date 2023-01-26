<?php
    class especialidadController{
        private $model;

        public function __construct()
        {
            require_once ("/Users/marcotintinduran/Desktop/prueba1/model/especialidadModel.php");   
            $this->model=new especialidadModel();
        }

        public function create($idEspecialidad,$nombreEspecialidad){
            $id=$this->model->create($idEspecialidad,$nombreEspecialidad);
            if ($id!=false){
                return header("Location:read.php?id=".$id);
            }else{
                return header("Location:create.php");
            }
        }

        public function read($idEspecialidad){
            if ($this->model->read($idEspecialidad)!=false){
                return $this->model->read($idEspecialidad);
            }else{
                return header("Location:read.php");
            };
        }

        public function update($idEspecialidad,$nombreEspecialidad){
            $id=$this->model->update($idEspecialidad,$nombreEspecialidad);
            echo "controller";
            if ($id!=false){
                return header("Location:read.php?id=".$id);
            }else{
                return header("Location:update.php");
            }
        }

        public function delete($idEspecialidad){
            if ($this->model->delete($idEspecialidad)!=false){
                return header("Location:read.php?id=0");
            }else{
                return header("Location:read.php?id=0");
            };
        }
    }
?>