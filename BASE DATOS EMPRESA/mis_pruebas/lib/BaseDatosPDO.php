<?php
namespace lib;
use PDO;
use PDOException;

class BaseDatosPDO {

    private PDO $conexion;
    private mixed $resultado;

    public function __construct(
        private string $servidor = SERVIDOR,
        private string $usuario = USUARIO,
        private string $pass = PASS,
        private string $base_datos = BASE_DATOS
    ) {
        $this->conexion = $this->conectar();
    }

    private function conectar(): PDO {
        $dsn = "mysql:host=$this->servidor;dbname=$this->base_datos;charset=utf8mb4";
        try {
            $pdo = new PDO($dsn, $this->usuario, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    public function consulta(string $sql, array $params = []): bool {
        try {
            $stmt = $this->conexion->prepare($sql);
            $ok = $stmt->execute($params);
            if ($ok){$this->resultado = $stmt;}
            return $ok;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }
    public function extraer_registro(): mixed {
        return $this->resultado->fetch(PDO::FETCH_ASSOC) ?: false;
    }
    public function extraer_todos(): array|bool {
        return $this->resultado ? $this->resultado->fetchAll(PDO::FETCH_ASSOC) : false;
    }
    public function id_ultimo_insertado(): string {
        return $this->conexion->lastInsertId();
    }
}
