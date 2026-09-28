
mysql> CREATE DATABASE db_banco_adso;
mysql> USE db_banco_adso;

mysql> CREATE TABLE clientes (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     nombre VARCHAR(100) NOT NULL
    -> ) 

mysql> CREATE TABLE cuentas (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     numero_cuenta VARCHAR(30) NOT NULL UNIQUE,
    ->     saldo DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    ->     cliente_id INT NOT NULL,
    ->
    ->     CONSTRAINT fk_cuentas_cliente
    ->         FOREIGN KEY (cliente_id)
    ->         REFERENCES clientes(id)
    ->         ON DELETE RESTRICT
    -> )

mysql> CREATE TABLE usuarios (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     cuenta_id INT NOT NULL UNIQUE,
    ->     clave_hash VARCHAR(255) NOT NULL,
    ->
    ->     CONSTRAINT fk_usuarios_cuenta
    ->         FOREIGN KEY (cuenta_id)
    ->         REFERENCES cuentas(id)
    ->         ON DELETE RESTRICT
    -> )

mysql> CREATE TABLE retiros (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     cuenta_id INT NOT NULL,
    ->     valor DECIMAL(12,2) NOT NULL,
    ->     fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ->
    ->     CONSTRAINT fk_retiros_cuenta
    ->         FOREIGN KEY (cuenta_id)
    ->         REFERENCES cuentas(id)
    ->         ON DELETE RESTRICT
    -> ) 

mysql> CREATE TABLE transferencias (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     cuenta_origen_id INT NOT NULL,
    ->     cuenta_destino_id INT NOT NULL,
    ->     valor DECIMAL(12,2) NOT NULL,
    ->     fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ->
    ->     CONSTRAINT fk_transferencias_origen
    ->         FOREIGN KEY (cuenta_origen_id)
    ->         REFERENCES cuentas(id)
    ->         ON DELETE RESTRICT,
    ->
    ->     CONSTRAINT fk_transferencias_destino
    ->         FOREIGN KEY (cuenta_destino_id)
    ->         REFERENCES cuentas(id)
    ->         ON DELETE RESTRICT
    -> ) 