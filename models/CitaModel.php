<?php

    class CitaModel{
        const PARAMS = ['id_cita','nombre_medico', 'id_medico', 'nombre_paciente','id_paciente', 'estado','fecha_ingreso','fecha_modificacion'];
        public $id_cita;
        public $nombre_medico;  
        public $id_medico;
        public $nombre_paciente;
        public $id_paciente;
        public $estado;
        public $fecha_ingreso;
        public $fecha_modificacion;

        public function __construct(){
        }

        public static function GetAll()
        {
            return  UISQL::TableToJSON('select * from get_citas();', CitaModel::class);
        }
        public static function Post(CitaModel $model)
        {
            $result = new TransactionEN();
            $sql = "Usp_post_cita";
            $prms = UIMODEL::CopyPartial($model, CitaModel::PARAMS);
            $result = UISQL::Execute($sql, $prms);
            return $result;
        }
    }
?>