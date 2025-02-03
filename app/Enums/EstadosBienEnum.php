<?php

namespace App\Enums;

enum EstadosBienEnum: int
{
    case ACTIVO = 1;
    case INACTIVO = 2;
    case DESCARGO = 3;
}