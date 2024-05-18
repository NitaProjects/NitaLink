<?php
declare(strict_types=1);

class Checker {
    
    public static function StringValidator(string $s, int $size): int {
        if ($s == null) {
            return -1;
        }
        if (trim($s) === "") {
            return -2;
        }
        if (strlen(trim($s)) < $size) {
            return -3;
        }
        return 0;
    }
    
    public static function NumberValidator($i): int {
        if ($i == 0) {
            return -1;
        }
        if ($i < 0) {
            return -2;
        }
        if ($i == "") {
            return -3;
        }
        if ($i == null) {
            return -4;
        }
        return 0;
    }
    
    public static function EmailValidator(string $email): int {
        // Expresión regular para validar un email
        $pattern = '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.' // Comienza con caracteres alfanuméricos y símbolos especiales permitidos en la parte local.
            . '[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*' // Subdominios de la parte local separados por puntos
            . '@' // Separador '@'
            . '(?:[a-z0-9]' // Parte del dominio principal
            . '(?:[a-z0-9-]*[a-z0-9])?\.)+' // Los subdominios dentro del dominio principal (con - permitido).
            . '[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$' // Dominio de nivel superior
            . '/i';

        // Verificar si el correo coincide con el patrón
        if (!preg_match($pattern, $email)) {
            return -1; // Email no válido
        }

        // Validar el dominio utilizando `filter_var`, es un filtro mas
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return -2; // Formato incorrecto
        }

        return 0; // Email válido
    }

    public static function PhoneNumberValidator(string $phoneNumber): int {
        // Expresión regular para validar el formato de un número de teléfono
        $pattern = '/^' // Comienzo del patrón
            . '\+?(\d{1,3})?' // Prefijo internacional opcional con + seguido de hasta 3 dígitos
            . '[-.\s]?' // Separador opcional (-, ., o espacio)
            . '\(?\d{1,3}\)?' // Código de área opcional entre paréntesis
            . '[-.\s]?' // Separador opcional (-, ., o espacio)
            . '\d{3}' // Tres primeros dígitos del número
            . '[-.\s]?' // Separador opcional (-, ., o espacio)
            . '\d{4}' // Últimos cuatro dígitos
            . '$/';
        /*
            * Ejemplos de Números Válidos:
            Números Internacionales:
            Con Prefijo de País: +34 912345678 (España)
            Con Separadores: +44-20-1234-5678 (Reino Unido)
            Sin Separadores: +14155552671 (Estados Unidos)
            Números Nacionales Españoles:
            Móvil: 612345678
            Fijo con Código de Área: 91 123 4567
            Formato Variado: 912-345-678
        */
        
        // Comprobar si el número coincide con el patrón
        if (!preg_match($pattern, $phoneNumber)) {
            return -1; // Número de teléfono no válido
        }

        return 0; // Número de teléfono válido
    }
    
    public static function checkDNI(string $dni): int {
        // Expresión regular para validar el formato: 8 dígitos seguidos de una letra
        if (!preg_match('/^\d{8}[A-Z]$/i', $dni)) {
            return -1; // Formato incorrecto
        }
        // Extraer el número y la letra del DNI
        $numero = substr($dni, 0, 8);
        $letraIngresada = strtoupper(substr($dni, -1)); // Convertir a mayúscula

        // Tabla de letras correspondientes
        $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';

        // Calcular el índice de la letra correcta
        $indice = (int)$numero % 23;
        $letraCorrecta = $letras[$indice];

        // Comparar la letra calculada con la letra proporcionada
        if ($letraCorrecta != $letraIngresada) {
            return -2; // Letra incorrecta
        }

        return 0; // DNI válido
    }
    
    public static function checkISBN(string $isbn): int {
        // Expresión regular para validar el formato del ISBN-13 (prefijo + 10 dígitos)
        if (!preg_match('/^(978|979)\d{10}$/', $isbn)) {
            return -1; // Formato incorrecto
        }

        // Validar el dígito de comprobación usando el algoritmo del ISBN-13
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int)$isbn[$i];
            $weight = ($i % 2 === 0) ? 1 : 3; // Alternar peso de 1 y 3
            $sum += $digit * $weight;
        }

        // Calcular el dígito de control
        $remainder = $sum % 10;
        $checkDigit = ($remainder == 0) ? 0 : (10 - $remainder);

        // Comparar con el último dígito del ISBN
        if ((int)$isbn[12] != $checkDigit) {
            return -2; // Dígito de control incorrecto
        }

        return 0; // ISBN válido
    }
  
    public static function checkDate(string $date): int {
        // Expresión regular básica para validar el formato general dd/mm/yyyy
        $pattern = '/^\d{2}\-\d{2}\-\d{4}$/';

        // Verificar si el formato general es válido
        if (!preg_match($pattern, $date)) {
            return -1; // Formato inválido
        }

        // Dividir la fecha en día, mes y año
        list($day, $month, $year) = explode('-', $date);

        // Convertir a enteros
        $day = (int)$day;
        $month = (int)$month;
        $year = (int)$year;

        // Verificar el rango de los valores
        if ($year < 1900 || $year > 2100) {
            return -1; // Año fuera de rango
        }
        if ($month < 1 || $month > 12) {
            return -1; // Mes fuera de rango
        }

        // Verificar el día del mes
        if (!checkdate($month, $day, $year)) {
            return -1; // Día fuera de rango
        }

        // Verificación específica para los años bisiestos
        if ($month == 2 && $day == 29) {
            if (!($year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0))) {
                return -1; // No es un año bisiesto
            }
        }
        return 0; // Fecha válida
    }

    
    public static function checkDateTimeLarga(string $date): int {
        // Expresión regular básica para validar el formato general dd/mm/yyyy HH:mm:ss
        $pattern = '/^\d{2}\-\d{2}\-\d{4} \d{2}:\d{2}:\d{2}$/';

        // Verificar si el formato general es válido
        if (!preg_match($pattern, $date)) {
            return -1; // Formato inválido
        }

        // Dividir la fecha y hora
        list($datePart, $timePart) = explode(' ', $date);

        // Dividir la fecha en día, mes y año
        list($day, $month, $year) = explode('-', $datePart);

        // Convertir a enteros
        $day = (int)$day;
        $month = (int)$month;
        $year = (int)$year;

        // Verificar el rango de los valores de la fecha
        if ($year < 1900 || $year > 2100) {
            return -1; // Año fuera de rango
        }
        if ($month < 1 || $month > 12) {
            return -1; // Mes fuera de rango
        }
        if (!checkdate($month, $day, $year)) {
            return -1; // Día fuera de rango
        }

        // Verificar el formato de la hora
        $patternTime = '/^\d{2}:\d{2}:\d{2}$/';
        if (!preg_match($patternTime, $timePart)) {
            return -1; // Formato de hora inválido
        }

        // Dividir la hora en horas, minutos y segundos
        list($hour, $minute, $second) = explode(':', $timePart);

        // Convertir a enteros
        $hour = (int)$hour;
        $minute = (int)$minute;
        $second = (int)$second;

        // Verificar el rango de los valores de la hora
        if ($hour < 0 || $hour > 23) {
            return -1; // Hora fuera de rango
        }
        if ($minute < 0 || $minute > 59) {
            return -1; // Minuto fuera de rango
        }
        if ($second < 0 || $second > 59) {
            return -1; // Segundo fuera de rango
        }
        return 0; // Fecha y hora válidas
        }


    public static function UserTypeValidator(string $type): int {
        // Lista de tipos permitidos, todos en minúsculas
        $allowedTypes = ['client', 'employee', 'provider'];
        
        // Convertir el tipo ingresado a minúsculas y eliminar espacios
        $normalizedType = strtolower(trim($type));
        
        // Verificar si el tipo normalizado está en la lista de permitidos
        if (!in_array($normalizedType, $allowedTypes, true)) {
            return -1;  // Tipo no permitido
        }
        
        return 0;  // Tipo permitido
    }
    
    public static function MembershipTypeValidator(string $membershipType): int {
        // Lista de tipos de membresía permitidos, todos en minúsculas
        $allowedTypes = ['standard', 'gold', 'premium'];

        // Convertir el tipo de membresía ingresado a minúsculas y eliminar espacios
        $normalizedType = strtolower(trim($membershipType));

        // Verificar si el tipo normalizado está en la lista de permitidos
        if (!in_array($normalizedType, $allowedTypes, true)) {
            return -1;  // Tipo no permitido
        }

        return 0;  // Tipo permitido
    }
    
    public static function AccountBalanceValidator(float $accountBalance, float $minBalance = -5000.00): int {
        // Verificar si el balance es un número finito
        if (!is_finite($accountBalance) || !is_float($accountBalance)) {
            return -1; // Tipo incorrecto o valor no finito
        }

        // Verificar si el balance es menor al mínimo permitido
        if ($accountBalance < $minBalance) {
            return -2; // Balance inferior al mínimo permitido
        }

        // Limitar el balance a dos decimales
        $formattedBalance = round($accountBalance, 2);

        // Verificar si el balance formateado coincide con el original
        if ($formattedBalance != $accountBalance) {
            return -3; // Balance no tiene exactamente dos decimales
        }

        return 0; // Balance válido
    }
    
    public static function DeliveryDaysValidator(array $deliveryDays): int {
        // Lista de días válidos en minúsculas
        $validDays = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes'];

        // Comprobar cada día ingresado
        foreach ($deliveryDays as $day) {
            // Convertir el día a minúsculas para una comparación insensible a mayúsculas
            $normalizedDay = strtolower(trim($day));

            // Verificar si el día normalizado está en la lista de válidos
            if (!in_array($normalizedDay, $validDays, true)) {
                return -1; // Día no válido
            }
        }

        return 0; // Todos los días son válidos
    }
    
    public static function PercentageValidator(int $percentage): int {
        if ($percentage < 0 || $percentage > 100) {
            return -1; 
        }
        return 0; 
    }

    public static function QuantityValidator(int $quantity, int $currentStock = null): int {
        if ($quantity < 0) {
            return -1; 
        }
        if ($currentStock !== null && $quantity > $currentStock) {
            return -2; 
        }
        return 0; 
    }
    
    public static function OperationTypeValidator(string $type): int {
        $allowedTypes = ['Compra', 'Venta', 'Devolución', 'Cambio'];
        if (!in_array($type, $allowedTypes)) {
            return -1;  
        }
        return 0; 
    }
    
    // MÉTODOS PARA ERRORES

    public static function PhoneNumberErrorCode(int $error): string {
        switch ($error) {
            case -1: return "El número de teléfono proporcionado no es válido. Debe seguir un formato reconocido.";
            default: return "Error desconocido con el número de teléfono.";
        }
    }

    public static function EmailErrorCode(int $error): string {
        switch ($error) {
            case -1: return "El formato del email proporcionado no es válido.";
            case -2: return "El email no pasó la validación adicional.";
            default: return "Error desconocido con el email.";
        }
    }

    public static function DNIErrorCode(int $error): string {
        switch ($error) {
            case -1: return "El formato del DNI proporcionado no es válido.";
            case -2: return "La letra del DNI no coincide con el número.";
            default: return "Error desconocido con el DNI.";
        }
    }

    public static function ISBNErrCode(int $error): string {
        switch ($error) {
            case -1: return "El formato del ISBN no es válido. Debe comenzar con '978' o '979' seguido de 10 dígitos.";
            case -2: return "El dígito de control del ISBN no es correcto.";
            default: return "Error desconocido con el ISBN.";
        }
    }

    public static function DateErrorCode(int $error): string {
        switch ($error) {
            case -1: return "La fecha proporcionada no es válida. Asegúrese de que esté en el formato correcto (dd/mm/yyyy) y sea una fecha real.";
            case -2: return "La fecha proporcionada está en el pasado.";
            default: return "Error desconocido con la fecha.";
        }
    }

    public static function StringErrorCode(int $error): string {
        switch ($error) {
            case -1: return "Se ha introducido una cadena nula.";
            case -2: return "Se ha introducido una cadena vacía.";
            case -3: return "Se ha introducido una cadena demasiado corta.";
            default: return "Error desconocido con la cadena.";
        }
    }

    public static function UserTypeErrorCode(int $error): string {
        switch ($error) {
            case -1: return "Tipo de usuario no permitido. Los tipos permitidos son 'client', 'employee', 'provider'.";
            default: return "Error desconocido con el tipo de usuario.";
        }
    }

    public static function MembershipTypeErrorCode(int $error): string {
        switch ($error) {
            case -1: return "Tipo de membresía no permitido. Los tipos permitidos son 'standard', 'gold', 'premium'.";
            default: return "Error desconocido con el tipo de membresía.";
        }
    }

    public static function AccountBalanceErrorCode(int $error): string {
        switch ($error) {
            case -1: return "El saldo de la cuenta es incorrecto o no es un valor numérico válido.";
            case -2: return "El saldo es inferior al mínimo permitido.";
            case -3: return "El saldo tiene más de dos decimales.";
            default: return "Error desconocido con el saldo de la cuenta.";
        }
    }

    public static function NumberErrorCode(int $error): string {
        switch ($error) {
            case -1: return "El número no puede ser cero.";
            case -2: return "El número no puede ser negativo.";
            case -3: return "El número no puede estar vacío.";
            case -4: return "El número no puede ser nulo.";
            default: return "Error desconocido con el número.";
        }
    }

    public static function DeliveryDaysErrorCode(int $error): string {
        switch ($error) {
            case -1: return "Día(s) de entrega no válido(s). Los días válidos son 'lunes', 'martes', 'miércoles', 'jueves', 'viernes'.";
            default: return "Error desconocido con los días de entrega.";
        }
    }

    public static function PercentageErrorCode(int $error): string {
        switch ($error) {
            case -1: return "El porcentaje debe estar entre 0 y 100.";
            default: return "Error desconocido con el porcentaje.";
        }
    }

    public static function QuantityErrorCode(int $error): string {
        switch ($error) {
            case -1: return "La cantidad no puede ser negativa.";
            case -2: return "La cantidad no puede ser mayor al stock actual.";
            default: return "Error desconocido con la cantidad.";
        }
    }

    public static function OperationTypeErrorCode(int $error): string {
        switch ($error) {
            case -1: return "Tipo de operación no permitido. Los tipos permitidos son 'Compra', 'Venta', 'Devolución', 'Cambio'.";
            default: return "Error desconocido con el tipo de operación.";
        }
    }
}
  