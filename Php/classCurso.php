<?php

class Curso
{
    private $nombre;
    private $costo_base;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->costo_base = $this->calcularCostoBase();
    }

    private function calcularCostoBase()
    {
        switch ($this->nombre) {
            case 'Programación':
                return 600000;
            case 'Diseño Gráfico':
                return 500000;
            case 'Marketing Digital':
                return 450000;
            case 'Finanzas':
                return 550000;
            case 'Ciberseguridad':
                return 700000;
            default:
                return 0;
        }
    }

    public function getCostoBase()
    {
        return $this->costo_base;
    }

    public function getCursosAdicionalesDisponibles()
    {
        return [
            "Inteligencia Artificial" => 500000,
            "UX/UI" => 350000,
            "Redes Sociales" => 300000,
            "Análisis de Datos" => 450000,
            "Gestión de Proyectos" => 400000
        ];
    }

    public function calcularCostoCursosAdicionales($cursosSeleccionados)
    {
        $cursosDisponibles = $this->getCursosAdicionalesDisponibles();
        $total = 0;

        foreach ($cursosSeleccionados as $curso) {
            if (isset($cursosDisponibles[$curso])) {
                $total += $cursosDisponibles[$curso];
            }
        }

        return $total;
    }
}
?>
