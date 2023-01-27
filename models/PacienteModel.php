<?php
class PacienteModel
{
    const PARAMS = ['id_paciente', 'nombre', 'apellido', 'sexo', 'telefono', 'direccion', 'correo_electronico', 'fecha_nacimiento'];
    public $id_paciente;
    public $nombre;
    public $apellido;
    public $sexo;
    public $telefono;
    public $direccion;
    public $correo_electronico;
    public $fecha_nacimiento;
    public $estado;

    public static function GetAll()
    {
        return UISQL::TableToJSON("select * from get_paciente('A');", PacienteModel::class);
    }

    public static function Post(PacienteModel $model)
    {
        $result = new TransactionEN();
        $sql = "Usp_post_paciente";
        $prms = UIMODEL::CopyPartial($model, PacienteModel::PARAMS);
        $result = UISQL::Execute($sql, $prms);
        return $result;
    }
    public static function Delete(PacienteModel $model)
    {
        $result = new TransactionEN();
        $sql = "Usp_delete_paciente";
        $prms = ["id_paciente" => $model->id_paciente];
        $result = UISQL::Execute($sql, $prms);
        return $result;
    }
}
