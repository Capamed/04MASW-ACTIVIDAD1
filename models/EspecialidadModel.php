<?php
class EspecialidadModel
{
    const PARAMS = ['id_especialidad', 'nombre'];
    public $id_especialidad;
    public $nombre;
    public function __construct()
    {
    }
    

    public static function GetAll()
    {
        return UISQL::TableToJSON("select * from get_especialidad('A');", EspecialidadModel::class);
    }

    public static function Post(EspecialidadModel $model)
    {
        $result = new TransactionEN();
        $sql = "Usp_post_especialidad";
        $prms = UIMODEL::CopyPartial($model, EspecialidadModel::PARAMS);
        $result = UISQL::Execute($sql, $prms);
        return $result;
    }

    public static function Delete(EspecialidadModel $model)
    {
        $result = new TransactionEN();
        $sql = "Usp_delete_especialidad";
        $prms = ["id_especialidad" => $model->id_especialidad];
        $result = UISQL::Execute($sql, $prms);
        return $result;
    }
}
