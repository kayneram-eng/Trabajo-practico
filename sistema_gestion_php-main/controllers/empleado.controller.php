<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/empleado.model.php';
require_once __DIR__ . '/../helpers/toast.php';

class EmpleadoController {
    private $model;

    public function __construct() {
        global $pdo; // USAMOS LA VARIABLE $pdo DE database.php
        $this->model = new EmpleadoModel($pdo);
    }

    // MOSTRARR TODO LOS EMPLEADOS (SE ABRE EN UN MODAL)
    public function index() {
        $empleados = $this->model->getAll();
        require __DIR__ . '/../views/gestion_empleados.view.php';
    }

    // CREAR PRODUCTO NUEVO
    public function store($data) {
        $dni = $data['dni'];
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];
        $contraseña = $data['contraseña'];
        $rol_id = $data['rol_id'];
        $estado = $data['estado'];

        //CAPTURO EL RESULTADO DEL PRODUCTO CREADO
        $result = $this->model->create($dni, $nombre, $apellido, $email, $contraseña, $rol_id, $estado);

        //MUESTRA UNA NOTIFICACION SI SE CREO O NO SATISFACTORIAMENTE
        if($result) {
            Toast::success('EMPLEADO CREADO EXITOSAMENTE'); //VERDE
        } else {
            Toast::info('⚠️ERROR AL CREAR EMPLEADO'); //AZUL
        }

        header("Location: index.php?page=gestion_empleados"); // REDIRIGE A ...
        exit;
    }

    // ACTUALIZAR DATOS DEL EMPLEADO
    public function update($id, $data) {
        $dni = $data['dni'];
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];
        $contraseña = $data['contraseña'];
        $rol_id = $data['rol_id'];
        $estado = $data['estado'];

        //CAPTURO EL RESULTADO DEL PRODUCTO ACTUALIZADO
        $result = $this->model->update($id, $dni, $nombre, $apellido, $email, $contraseña, $rol_id, $estado);

        //MUESTRA UNA NOTIFICACION SI SE ACTUALIZO O NO SATISFACTORIAMENTE
        if($result) {
            Toast::warning('EMPLEADO ACTUALIZADO CORRECTAMENTE'); //AMARILLO
        } else {
            Toast::info('⚠️ERROR AL ACTUALIZAR EMPLEADO'); //AZUL
        }

        header("Location: index.php?page=gestion_empleados"); // REDIRIGE A ...
        exit;
    }

    // ELIMINAR EMPLEADO
    public function delete($id) {
        //CAPTURO EL RESULTADO DEL PRODUCTO A ELIMINAR
        $result = $this->model->delete($id);

        //MUESTRA UNA NOTIFICACION SI SE ELIMINO O NO SATISFACTORIAMENTE
        if($result) {
            Toast::error('EMPLEADO ELIMINADO CORRECTAMENTE');//ROJO
        } else {
            Toast::info('⚠️ERROR AL ELIMINAR EMPLEADO');//AZUL
        }

        header("Location: index.php?page=gestion_empleados"); // REDIRIGE A ...
        exit;
    }

    public function handleRequest() {
        // ESTE ES EL "CEREBRO"

        if (isset($_POST['create'])) {
            $this->store($_POST);
            return;
        }

        if (isset($_POST['update']) && isset($_POST['id'])) {
            $this->update($_POST['id'], $_POST);
            return;
        }

        if (isset($_POST['delete']) && isset($_POST['id'])) {
            $this->delete($_POST['id']);
            return;
        }

        // Por defecto, mostrar la vista
        $this->index();
    }
}
?>