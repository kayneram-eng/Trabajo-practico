<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/product.model.php';
require_once __DIR__ . '/../helpers/toast.php';

class ProductoController {
    private $model;

    public function __construct() {
        global $pdo; // USAMOS LA VARIABLE $pdo DE database.php
        $this->model = new ProductoModel($pdo);
    }

    // MOSTRARR TODO LOS PRODUCTOS (ESTA ES LA VISTA PRINCIPAL AL ABRIRLO)
    public function index() {
        $productos = $this->model->getAll();
        require __DIR__ . '/../views/product.view.php';
    }

    // CREAR PRODUCTO NUEVO
    public function store($data) {
        $animal = $data['animal'];
        $nombre = $data['nombre'];
        $presentacion = $data['presentacion'];
        $descripcion = $data['descripcion'];
        $precio = $data['precio'];
        $stock = $data['stock'];

        //CAPTURO EL RESULTADO DEL PRODUCTO CREADO
        $result = $this->model->create($animal, $nombre, $presentacion, $descripcion, $precio, $stock);

        //MUESTRA UNA NOTIFICACION SI SE CREO O NO SATISFACTORIAMENTE
        if($result) {
            Toast::success('PRODUCTO CREADO EXITOSAMENTE'); //VERDE
        } else {
            Toast::info('⚠️ERROR AL CREAR EL PRODUCTO'); //AZUL
        }

        header("Location: index.php?page=productos"); // REDIRIGE A LA MISMA VISTA
        exit;
    }

    // ACTUALIZAR PRODUCTO
    public function update($id, $data) {
        $animal = $data['animal'];
        $nombre = $data['nombre'];
        $presentacion = $data['presentacion'];
        $descripcion = $data['descripcion'];
        $precio = $data['precio'];
        $stock = $data['stock'];

        //CAPTURO EL RESULTADO DEL PRODUCTO ACTUALIZADO
        $result = $this->model->update($id, $animal, $nombre, $presentacion, $descripcion, $precio, $stock);

        //MUESTRA UNA NOTIFICACION SI SE ACTUALIZO O NO SATISFACTORIAMENTE
        if($result) {
            Toast::warning('PRODUCTO ACTUALIZADO CORRECTAMENTE'); //AMARILLO
        } else {
            Toast::info('⚠️ERROR AL ACTUALIZAR EL PRODUCTO'); //AZUL
        }

        header("Location: index.php?page=productos"); // REDIRIGE A LA MISMA VISTA
        exit;
    }

    // ELIMINAR PRODUCTO
    public function delete($id) {
        //CAPTURO EL RESULTADO DEL PRODUCTO A ELIMINAR
        $result = $this->model->delete($id);

        //MUESTRA UNA NOTIFICACION SI SE ELIMINO O NO SATISFACTORIAMENTE
        if($result) {
            Toast::error('PRODUCTO ELIMINADO CORRECTAMENTE');//ROJO
        } else {
            Toast::info('⚠️ERROR AL ELIMINAR EL PRODUCTO');//AZUL
        }

        header("Location: index.php?page=productos"); // REDIRIGE A LA MISMA VISTA
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