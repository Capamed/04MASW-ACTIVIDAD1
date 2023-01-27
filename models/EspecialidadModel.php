<?php
class EspecialidadModel
{
    const PARAMS = ['id_especialidad', 'nombre'];
    public $id_especialidad;
    public $nombre;
    public function __construct()
    {
        // foreach (EspecialidadModel::PARAMS as $prop) {
        //     $this->{$prop} = null;
        // }
    }
    // public function createProperty($name, $value){
    //     $this->{$name} = $value;
    // }

    public static function GetAll()
    {
        return UISQL::TableToJSON('select * from get_especialidad();', EspecialidadModel::class);
    }

    public static function Post(EspecialidadModel $model)
    {
        $result = new TransactionEN();
        $sql = "Usp_post_especialidad";
        $prms = UIMODEL::CopyPartial($model, EspecialidadModel::PARAMS);
        $result = UISQL::Execute($sql, $prms);
        return $result;
    }
}
