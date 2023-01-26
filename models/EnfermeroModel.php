<?php

    class EnfermeroModel{
        const PARAMS = ['id_enfermero','numero_identificacion', 'nombre', 'apellido', 'telefono','correo_electronico'];
        private $idEnfermero;
        private $numeroIdentificacion;
        private $nombreEnfermero;
        private $apellidoEnfermero;
        private $telefonoEnfermero;
        private $correoEnfermero;

        public function __construct(){
        }

        public static function GetAll()
        {
            return  UISQL::TableToJSON('select * from get_enfermero();', EnfermeroModel::class);
        }

        public static function Post(EnfermeroModel $model)
        {
            $result = new TransactionEN();
            $sql = "Usp_post_enfermero";
            $prms = UIMODEL::CopyPartial($model, EnfermeroModel::PARAMS);
            $result = UISQL::Execute($sql, $prms);
            return $result;
        } 
    }
?>