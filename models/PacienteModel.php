<?php
class PacienteModel
{
    const PARAMS = ['id_paciente', 'nombre', 'apellido', 'sexo', 'telefono', 'direccion', 'correo_electronico', 'fecha_nacimiento', 'estado'];
    public $id_paciente;
    public $nombre;
    public $apellido;
    public $sexo;
    public $telefono;
    public $direccion;
    public $correo_electronico;
    public $fecha_nacimiento;
    public $estado;

    public static function GetAll($estado)
    {
        return UISQL::TableToJSON("select * from get_paciente('{$estado}');", PacienteModel::class);
    }

    public static function Post(PacienteModel $model)
    {
        $result = new TransactionEN();
        $sql = "Usp_post_paciente";
        $prms = UIMODEL::CopyPartial($model, PacienteModel::PARAMS);
        $result = UISQL::Execute($sql, $prms);
        return $result;
    }
}
