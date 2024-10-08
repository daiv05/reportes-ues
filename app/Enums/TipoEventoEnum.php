<?php

namespace App\Enums;

enum TipoEventoEnum: string
{
    case CONFERENCIA = 'Conferencia';
    case SEMINARIO = 'Seminario';
    case CONGRESO = 'Congreso';
    case DIPLOMADO = 'Diplomado';
    case TALLER = 'Taller';
    case PARCIAL = 'Parcial';
    case LABORATORIO_EVALUADO = 'Laboratorio evaluado';
    case CORTO = 'Corto evaluado';
    case DEFENSA = 'Defensa evaluada';
    case WEBINAR = 'Webinar';
}
