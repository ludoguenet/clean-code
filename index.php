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

// Procedural code (code using data structures) makes it easy to add new functions without changing the existing data structures. OO code, on the other hand, makes it easy to add new classes without changing existing functions.

// In any complex system, there are going to be times when we want to add new data types rather than new functions. For these cases, objects and OO are most appropriate. On the other hand, there will also be times when we'll want to add new functions as opposed to data types. In that case, procedural code and data structures will be more appropriate.

// TIPS
// Ne pas retourner NULL
// Ne pas passer NULL
// Ne pas passer de boolean