<?php

namespace App\Helpers;

class RegexHelper{
    public const TEXTO_SIMPLE = '/^[a-zA-ZÁáÉéÍíÓóÚúÜü]+( [a-zA-ZÁáÉéÍíÓóÚúÜü]+)*$/'; // textos que contienen solo letras y espacios
    public const DNI = '/^[MF]?\d{7,8}$/'; // 8 dígitos o empezar con M/F seguido de 7 dígitos
    public const TELEFONO = '/^\d{8,12}$/'; // entre 8 y 12 dígitos:
    public const PASSWORD = '/^(?=.*[A-Za-z])(?=.*\d).{6,8}$/'; // al menos 5 números y 1 letras
    // por ejemplo ABC123 (3 letras, 3 dígitos) o AB123CD (2 letras, 3 dígitos y 2 letras nuevamente) sólo mayúsculas
     public const PATENTE = '/^[A-Z]{3}\d{3}|[A-Z]{2}\d{3}[A-Z]{2}$/';
}