<?php

class EnfermeroModel
{
    const PARAMS = ['id_enfermero', 'numero_identificacion', 'nombre', 'apellido', 'telefono', 'correo_electronico'];
    public $id_enfermero;
    public $numero_identificacion;
    public $nombre;
    public $apellido;
    public $telefono;
    public $correo_electronico;

    public function __construct()
    {
    }

    public static function GetAll()
    {
        return UISQL::TableToJSON('select * from get_enfermero();', EnfermeroModel::class);
    }

    public static function Post(EnfermeroModel $model)
    {
        $result = new TransactionEN();
        $sql = "Usp_post_enfermero";
        $prms = UIMODEL::CopyPartial($model, EnfermeroModel::PARAMS);
        $result = UISQL::Execute($sql, $prms);
        return $result;
    }
    public static function Delete(EnfermeroModel $model)
    {
        $result = new TransactionEN();
        $sql = "Usp_delete_enfermero";
        $prms = ["id_enfermero" => $model->id_enfermero];
        $result = UISQL::Execute($sql, $prms);
        return $result;
    }
}
