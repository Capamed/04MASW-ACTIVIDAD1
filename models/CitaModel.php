<?php

    class CitaModel{
        const PARAMS = ['id_cita','nombre_medico', 'id_medico', 'nombre_paciente','id_paciente', 'estado','fecha_ingreso','fecha_modificacion'];
        private $idCita;
        private $nombreMedico;  
        private $idMedico;
        private $nombrePaciente;
        private $idPaciente;
        private $estado;
        private $fechaIngreso;
        private $fechaModificacion;

        public function __construct(){
        }

        public static function GetAll()
        {
            return  UISQL::TableToJSON('select * from ger_citas();', CitaModel::class);
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