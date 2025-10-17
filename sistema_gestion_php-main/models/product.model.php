<?php
require_once __DIR__ . '../../config.php';

class ProductoModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo; // RECIBE LA CONEXION PDO DESDE AFUERA
    }

    // OBTENEMOS TODO LOS PRODUCTOS
    public function getAll() {
        // $stmt = $this->pdo->query("SELECT * FROM productos ORDER BY ID DESC");
        $stmt = $this->pdo->query("SELECT ID as id, Animal as animal, Nombre as nombre, Presentacion as presentacion, Descripcion as descripcion, Precio as precio, Stock as stock, Creacion as creacion, Actualizacion as actualizacion FROM productos ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    // OBETENEMOS UN PRODUCTO POR ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT ID as id, Animal as animal, Nombre as nombre, Descripcion as descripcion, Precio as precio, Stock as stock FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // INSERTAMOS PRODUCTO
    public function create($animal, $nombre, $presentacion, $descripcion, $precio, $stock) {
        $stmt = $this->pdo->prepare("INSERT INTO productos (Animal, Nombre, Presentacion, Descripcion, Precio, Stock) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$animal, $nombre, $presentacion, $descripcion, $precio, $stock]);
    }

    // ACTUALIZAMOS PRODUCTO
    public function update($id, $animal, $nombre, $presentacion, $descripcion, $precio, $stock) {
        $stmt = $this->pdo->prepare("UPDATE productos SET Animal=?, Nombre=?, Presentacion=?, Descripcion=?, Precio=?, Stock=? WHERE id=?");
        return $stmt->execute([$animal, $nombre, $presentacion, $descripcion, $precio, $stock, $id]);
    }

    // ELIMINAMOS PRODUCTO
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM productos WHERE id=?");
        return $stmt->execute([$id]);
    }
}

?>