
<?php

require_once 'models/TransactionEN.php';

class UI
{
}
class UIMENU
{
    static function BUTTONS($href, $src, $text)
    {
        return "<a class='btn btn-light btn-menu-principal fw700' href='$href'>"
            . "<img src='$src' class='img-fluid d-block' style='max-height: 110px;'>"
            . $text
            . "</a>";
    }
}

class UIHTML
{
    static function HEADER($view)
    {

        $PHP1 = '';
        $PHP2 = '';
        $PHP3 = '';

        // $d2 = new DateTime();
        // $random = $d2->format('YmdHisu');

        $PHP1 .= "<link rel='stylesheet' href='{$view->path}/assets/css/menu.css?v={$view->random}' />";
        $PHP1 .= "<link rel='stylesheet' href='{$view->path}/assets/css/core.css?v={$view->random}' />";

        $PHP2 .= "$view->breadcrumb";

        $PHP3 .= "<div id='divBackground'><img src='{$view->path_img}simbolo-de-la-medicina.png'></div>";

        $HTML = file_get_contents($view->path_header, true);
        $HTML = str_replace("{{URL}}", $view->path, $HTML);
        $HTML = str_replace("<!--PHP1-->", $PHP1, $HTML);
        $HTML = str_replace("<!--PHP2-->", $PHP2, $HTML);
        $HTML = str_replace("<!--PHP3-->", $PHP3, $HTML);

        echo $HTML;
    }

    static function FOOTER($view)
    {
        // $d2 = new DateTime();
        // $random = $d2->format('YmdHisu');

        $HTML = file_get_contents($view->path_footer, true);
        $HTML = str_replace("{{URL}}", $view->path, $HTML);
        $HTML = str_replace("{{RANDOM}}", $view->random, $HTML);
        echo $HTML;
    }
}

class UISQL
{
    private $conexion;
    private $servidor;
    private $puerto;
    private $controlador;
    private $bd;
    private $usuario;
    private $clave;
    private $dsn;
    private $opciones;
    private function __construct()
    {
        $this->servidor = 'isilo.db.elephantsql.com';
        $this->puerto = 5432;
        $this->controlador = 'pgsql';
        $this->bd = 'ditixdvr';
        $this->usuario = 'ditixdvr';
        $this->clave = 'qya9L-taxxskDijE45c8_H711i4GulyE';
        // $this->dsn = "$this->controlador:Server=$this->servidor,$this->puerto;Database=$this->bd";
        $this->dsn = "$this->controlador:host=$this->servidor,$this->puerto;dbname=$this->bd";
        $this->opciones = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    }
    private function conectar()
    {
        $this->conexion = new PDO($this->dsn, $this->usuario, $this->clave, $this->opciones);
    }

    private function desconectar()
    {
        $this->conexion = null;
    }

    public static function Table($sql, $model = null)
    {
        $conector = new UISQL();
        try {
            $conector->conectar();
            $sentencia = $conector->conexion->prepare($sql);
            $sentencia->execute();
            if (empty($model)) {
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $resultado = $sentencia->fetchAll(PDO::FETCH_CLASS, $model);
            }
            $sentencia->closeCursor();
            return $resultado;
        } catch (Exception $e) {
            return "Error ==> {$e->getMessage()}";
        } finally {
            $conector->desconectar();
        }
    }
    public static function TableToJSON($sql, $model = null)
    {
        return json_encode(UISQL::Table($sql, $model));
    }

    public static function Execute($sp, $params = array())
    {
        $resultado = new TransactionEN();
        $conector = new UISQL();
        try {
            $conector->conectar();
            $sp_prepare = UISQL::PrepareSP($sp, $params);
            $stmt = $conector->conexion->prepare($sp_prepare);
            if (!empty($params) && count($params)) {
                foreach ($params as $key => &$val) {
                    $stmt->bindParam(":p_" . $key, $val);
                }
            }
            $stmt->execute();
            // return $stmt->rowCount();
            $resultado->success = true;
            array_push($resultado->mensaje, 'Ok');
        } catch (Exception $e) {
            $mensaje_error = $e->getMessage();
            if (str_contains($mensaje_error, 'dm_email_check')) {
                array_push($resultado->mensaje, 'El correo es inválido');
            } else {
                array_push($resultado->mensaje, $e->getMessage());
            }
            // array_push($resultado->mensaje, 'as');
        } finally {
            $conector->desconectar();
        }
        return $resultado;
    }

    public static function PrepareSP($sp, $params = array())
    {
        $resultado = "";
        try {
            $resultado .= "CALL {$sp}";
            if (!empty($params) && count($params)) {
                // $resultado .= " ( :p_";
                // $resultado .= join(',:p_',$params);
                // $resultado .= " ) ";
                $resultado .= " ( ";
                foreach ($params as $key => $val) {
                    $resultado .= ":p_$key,";
                }
                // $resultado .= trim($resultado, ',');
                $resultado = substr($resultado, 0, -1);
                // trim($resultado, ',');
                $resultado .= " ) ";
            }
            $resultado .= ";";
        } catch (Exception $e) {
        }
        return $resultado;
    }
}

class UIHTTP
{
    static function Validate(TransactionEN $result, array $params)
    {
        $prms = [];
        $data = json_decode(file_get_contents('php://input'), true);
        if (!empty($data)) {
            foreach ($params as $value) {
                if (empty($data[$value])) {
                    array_push($result->mensaje, "Falta el parametro '{$value}'.");
                } else {
                    $prms[$value] = $data[$value];
                }
            }
        } else
            array_push($result->mensaje, 'No se recibieron parámetros');
        return array($data, $prms);
    }
    static function ValidateWithModel(TransactionEN $result, array $params, $model)
    {

        $prms = [];
        $mdl = new $model;
        $refl = new ReflectionClass($mdl);
        $data = json_decode(file_get_contents('php://input'), true);
        if (!empty($data)) {
            foreach ($params as $value) {
                if (empty($data[$value])) {
                    array_push($result->mensaje, "Falta el parametro '{$value}'.");
                } else {
                    $property = $refl->getProperty($value);
                    $prms[$value] = $data[$value];
                    $property->setValue($mdl, $data[$value]);
                }
            }
        } else
            array_push($result->mensaje, 'No se recibieron parámetros');
        return array($data, $prms, $mdl);
    }
}

class UIMODEL
{
    static function CopyPartial($model, array $params)
    {
        $prms = [];
        // $refl = new ReflectionClass($model);
        if (!empty($model) && !empty($params)) {
            foreach ($params as $value) {
                if (property_exists($model, $value)) {
                    // $model->{$value} = $value;
                    $prms[$value] = $model->{$value};
                }
                // if (!empty($model[$value])) {
                //     $prms[$value] = $model[$value];
                // }
            }
        }
        return $prms;
    }
}
