<?php
declare(strict_types=1);

namespace App\Servicios;

use App\Excepciones\CuentaNoEncontradaException;
use App\Excepciones\CredencialesInvalidasException;
use App\Excepciones\MismaCuentaException;
use App\Excepciones\SaldoInsuficienteException;
use App\Excepciones\ValorInvalidoException;
use App\Repositorios\RepositorioCuenta;
use App\Repositorios\RepositorioRetiro;
use App\Repositorios\RepositorioTransferencia;
use App\Repositorios\RepositorioUsuario;
use PDO;
use Throwable;

final class ServicioCuenta
{
    public function __construct(
        private readonly PDO $pdo,
        private readonly RepositorioCuenta $cuentas,
        private readonly RepositorioUsuario $usuarios,
        private readonly RepositorioRetiro $retiros,
        private readonly RepositorioTransferencia $transferencias
    ) {
    }

    public function obtenerPanel(int $cuentaId): array
    {
        $cuenta = $this->cuentas->obtenerPorId($cuentaId);

        if ($cuenta === null) {
            throw new CuentaNoEncontradaException('La cuenta no existe.');
        }

        return $cuenta;
    }

    public function retirar(int $cuentaId, string $valor, string $clave): void
    {
        $this->validarClave($cuentaId, $clave);
        $valor = $this->validarValor($valor);

        $cuenta = $this->cuentas->obtenerPorId($cuentaId);

        if ($cuenta === null) {
            throw new CuentaNoEncontradaException('La cuenta no existe.');
        }

        if ($this->compararDecimales($cuenta['saldo'], $valor) < 0) {
            throw new SaldoInsuficienteException(
                'Saldo insuficiente para realizar el retiro.'
            );
        }

        $this->pdo->beginTransaction();

        try {
            $this->cuentas->descontar($cuentaId, $valor);
            $this->retiros->registrar($cuentaId, $valor);
            $this->pdo->commit();
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    public function transferir(
        int $cuentaOrigenId,
        string $numeroCuentaDestino,
        string $valor,
        string $clave
    ): void {
        $this->validarClave($cuentaOrigenId, $clave);

        $destino = $this->cuentas->obtenerPorNumero($numeroCuentaDestino);

        if ($destino === null) {
            throw new CuentaNoEncontradaException(
                'La cuenta destino no existe.'
            );
        }

        $valor = $this->validarValor($valor);

        $cuentaOrigen = $this->cuentas->obtenerPorId($cuentaOrigenId);

        if ($cuentaOrigen === null) {
            throw new CuentaNoEncontradaException('La cuenta origen no existe.');
        }

        $cuentaDestinoId = (int) $destino['id'];

        if ($cuentaOrigenId === $cuentaDestinoId) {
            throw new MismaCuentaException(
                'La cuenta destino debe ser diferente a la cuenta origen.'
            );
        }

        if (bccomp($cuentaOrigen['saldo'], $valor, 2) < 0) {
            throw new SaldoInsuficienteException(
                'Saldo insuficiente para realizar la transferencia.'
            );
        }

        $this->pdo->beginTransaction();

        try {
            $this->cuentas->descontar($cuentaOrigenId, $valor);
            $this->cuentas->abonar($cuentaDestinoId, $valor);
            $this->transferencias->registrar(
                $cuentaOrigenId,
                $cuentaDestinoId,
                $valor
            );

            $this->pdo->commit();
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    private function validarClave(int $cuentaId, string $clave): void
    {
        $usuario = $this->usuarios->obtenerPorCuentaId($cuentaId);

        if ($usuario === null || !password_verify($clave, $usuario['clave_hash'])) {
            throw new CredencialesInvalidasException(
                'La contraseña es incorrecta.'
            );
        }
    }

    private function validarValor(string $valor): string
    {
        $valor = trim($valor);

        if ($valor === '' || !preg_match('/^\d+(\.\d{1,2})?$/', $valor)) {
            throw new ValorInvalidoException(
                'El valor debe ser numérico, mayor que 0 y tener máximo dos decimales.'
            );
        }

        [$entero, $decimal] = array_pad(explode('.', $valor, 2), 2, '0');
        $decimal = str_pad($decimal, 2, '0');
        $entero = ltrim($entero, '0') ?: '0';
        $valor = $entero . '.' . $decimal;

        if ($this->compararDecimales($valor, '0.00') <= 0) {
            throw new ValorInvalidoException(
                'El valor debe ser mayor que 0.'
            );
        }

        return $valor;
    }
    private function compararDecimales(string $a, string $b): int
    {
        $aCentavos = $this->decimalACentavos($a);
        $bCentavos = $this->decimalACentavos($b);

        return $aCentavos <=> $bCentavos;
    }

    private function decimalACentavos(string $valor): int
    {
        [$entero, $decimal] = array_pad(explode('.', $valor, 2), 2, '0');
        $decimal = str_pad(substr($decimal, 0, 2), 2, '0');
        return ((int) $entero * 100) + (int) $decimal;
    }

}
