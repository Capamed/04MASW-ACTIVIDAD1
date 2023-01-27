<?php
class MedicoModel
{
    const PARAMS = ['id_medico', 'numero_identificacion', 'nombre', 'apellido', 'telefono', 'correo_electronico', 'id_especialidad'];
    public $id_medico;
    public $numero_identificacion;
    public $nombre;
    public $apellido;
    public $telefono;
    public $correo_electronico;
    public $id_especialidad;

    public static function GetAll()
    {
        return UISQL::TableToJSON("select * from get_medico();", MedicoModel::class);
    }

    public static function Post(MedicoModel $model)
    {
        $result = new TransactionEN();
        $sql = "Usp_post_medico";
        $prms = UIMODEL::CopyPartial($model, MedicoModel::PARAMS);
        $result = UISQL::Execute($sql, $prms);
        return $result;
    }
}
