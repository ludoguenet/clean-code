<?php

// BIEN NOMMER SES VARIABLES

// AVANT
$newArray = [];

foreach($data as $datum) {
    if ($datum->type === 2) {
        $newArray[] = $datum->id;
    }
}

return $newArray;

// APRES
$scienceFictionBooks = [];

foreach($books as $book) {
    if ($book->belongsToScienceFictionCategory()) {
        $scienceFictionBooks[] = $book->id;
    }
}

return $scienceFictionBooks;

// LES FONCTIONS DOIVENT FAIRE UNE CHOSE ET BIEN LE FAIRE

// AVANT
class User {

    public function __construct(
        private $name, 
        private $email, 
        private $age,
    ) {}

    public function save() {
        // ...
    }

    public function sendEmail() {
        // ...
    }

    public function validateAge() {
        // ...
    }
}

// APRES
class User {
    public function __construct(
        private $name, 
        private $email, 
        private $age,
    ) {}
}

class DB {
    public function save(User $user) {
        // ..
    }
}

class EmailSender {
    public function send($User $user) {
        // ...
    }
}

class AgeValidator {
    public function validate($User $user) {
        // ...
    }
}

// LE NOMBRE DE PARAMETRES

// Ne pas retourner NULL
// Ne pas passer NULL
// Ne pas passer de boolean

// AVANT
class ProductManager {
    public function getDiscountedPrice($price, $discount) {
        $discountedPrice = $price - ($price * ($discount / 100));
        
        if ($discountedPrice < 0) {
            $discountedPrice = 0;
        }
        
        return $discountedPrice;
    }
}

$productManager = new ProductManager();
$price = 100;
$discount = 20;
$discountedPrice = $productManager->getDiscountedPrice($price, $discount);

// APRES
class DiscountCalculator {

    public function __construct(
        private $price,
        private $discount,
    ) {}

    public function calculateDiscountedPrice() {
        $discountedPrice = $this->price - ($this->price * ($this->discount / 100));
        return max($discountedPrice, 0);
    }
}

class ProductManager {

    public function __construct(
        private DiscountCalculator $calculator,
    ) {}

    public function getDiscountedPrice() {
        return $this->calculator->calculateDiscountedPrice();
    }
}

$price = 100;
$discount = 20;
$calculator = new DiscountCalculator($price, $discount);

$productManager = new ProductManager($calculator);

$discountedPrice = $productManager->getDiscountedPrice();


// INPUT/OUTPUT ARGUMENT

// AVANT
function doubleAndTriple(&$num) {
    $num *= 2;
    $num *= 3;
}

$num = 5;
doubleAndTriple($num);
// $num vaut 30 et non 5


function doubleAndTriple($num) {
    $doubled = $num * 2;
    $tripled = $num * 3;
    return [$doubled, $tripled];
}

$num = 5;
[$doubled, $tripled] = doubleAndTriple($num);

// DATA STRUCTURE
class Shape {

}

class Circle extends Shape {
    public function __construct(public float $radius) {}
}

class Square extends Shape {
    public function __construct(public float $side) {}
}

class Geometry {
    public function area (Shape $shape) {
        return match (get_class($shape)) {
            Circle::class => pow($shape->radius, 2) * pi(),
            Square::class => pow($shape->side, 2),
            default => throw new NoSuchShapeException,
        }
    }
}

// OBJECTS
trait Shape {
    public function area(): float;
    public function volume(): float;
}

class Circle implements Shape {
    public function __construct(public float $radius) {}

    public function area(): float {
        return pow($this->radius, 2) * pi();
    }
}

class Square implements Shape {
    public function __construct(public float $side) {}

    public function area(): float {
       return pow($this->side, 2);
    }
}

class TemperatureVO {
    public function __construct(
        private $value,
        private $unit,
    ) {}

    public function convertToFahrenheit() {
        if ($this->unit === 'Celsius') {
            return ($this->value * 9/5) + 32;
        } elseif ($this->unit === 'Fahrenheit') {
            return $this->value;
        } else {
            return null;
        }
    }

    public function convertToCelsius() {
        if ($this->unit === 'Fahrenheit') {
            return ($this->value - 32) * 5/9;
        } elseif ($this->unit === 'Celsius') {
            return $this->value;
        } else {
            return null;
        }
    }
}

class TemperatureDTO {

    public function __construct(
        private TemperatureVO $temperature, 
        private $location,
        private $date,
    ) {}

    public function toArray(): array {
        return [
            'temperature' => $this->temperature,
            'location' => $this->location,
            'date' => $this->date,
        ];
    }

    public function convertToFahrenheit() {
        return $this->temperature->convertToFahrenheit();
    }

    public function convertToCelsius() {
        return $this->temperature->convertToCelsius();
    }
}