<?php

class Factura
{
    private $estudiante;
    private $curso_principal;
    private $costo_base;
    private $cursos_adicionales;
    private $costo_cursos_adicionales;
    private $descuento;
    private $subtotal;
    private $iva;
    private $total;

    public function __construct($estudiante, $curso, $cursosAdicionales)
    {
        $this->estudiante = $estudiante;
        $this->curso_principal = $curso;
        $this->costo_base = $curso->getCostoBase();
        $this->cursos_adicionales = $cursosAdicionales;
        $this->calcularTotal();
    }

    private function calcularTotal()
    {
        $this->costo_cursos_adicionales = $this->curso_principal->calcularCostoCursosAdicionales($this->cursos_adicionales);
        $this->subtotal = $this->costo_base + $this->costo_cursos_adicionales;

        // Aplicación de descuentos
        $numCursosAdicionales = count($this->cursos_adicionales);
        $this->descuento = 0;

        if ($numCursosAdicionales >= 9) {
            $this->descuento = 0.15; // 15%
        } elseif ($numCursosAdicionales >= 6) {
            $this->descuento = 0.10; // 10%
        } elseif ($numCursosAdicionales >= 3) {
            $this->descuento = 0.05; // 5%
        }

        $descuentoAplicado = $this->subtotal * $this->descuento;
        $this->subtotal -= $descuentoAplicado;
        $this->iva = $this->subtotal * 0.19;
        $this->total = $this->subtotal + $this->iva;
    }

    public function getResumenFactura()
    {
        return [
            "Estudiante" => $this->estudiante,
            "Curso Principal" => $this->curso_principal->getNombre(),
            "Costo Base" => $this->costo_base,
            "Cursos Adicionales" => $this->cursos_adicionales,
            "Costo Cursos Adicionales" => $this->costo_cursos_adicionales,
            "Descuento Aplicado (%)" => $this->descuento * 100,
            "Subtotal" => $this->subtotal,
            "IVA (19%)" => $this->iva,
            "Total a Pagar" => $this->total
        ];
    }
}

?>
