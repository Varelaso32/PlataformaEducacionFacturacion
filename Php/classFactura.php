<?php

class Factura
{
    private $estudiante;
    private $curso_principal;
    private $costo_base;
    private $cursos_adicionales;
    private $descuento;
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
        $subtotal = $this->costo_base;
        $costoCursosAdicionales = 0;
        $numCursosAdicionales = count($this->cursos_adicionales);

        for ($i = 0; $i < $numCursosAdicionales; $i++) {
            $costoCursosAdicionales += $this->cursos_adicionales[$i]['costo'];
        }

        $subtotal += $costoCursosAdicionales;

        $descuento = 0;

        switch (true) {
            case ($numCursosAdicionales >= 9):
                $descuento = 0.15;
                break;
            case ($numCursosAdicionales >= 6):
                $descuento = 0.10;
                break;
            case ($numCursosAdicionales >= 3):
                $descuento = 0.05;
                break;
        }

        $subtotal -= $subtotal * $descuento;
        $this->descuento = $descuento * 100; 

        $this->iva = $subtotal * 0.19;
        $this->total = $subtotal + $this->iva;
    }

    public function getResumenFactura()
    {
        return [
            "Estudiante" => $this->estudiante,
            "Curso Principal" => $this->curso_principal,
            "Costo Base" => $this->costo_base,
            "Cursos Adicionales" => $this->cursos_adicionales,
            "Descuento Aplicado (%)" => $this->descuento,
            "IVA (19%)" => $this->iva,
            "Total a Pagar" => $this->total
        ];
    }
}

?>
