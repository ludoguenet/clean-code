<?php

// BIEN NOMMER SES VARIABLES

$newArray = [];

foreach($data as $datum) {
    if ($datum->type === 2) {
        $newArray[] = $datum->id;
    }
}

return $newArray;

echo 'after';

$scienceFictionBooks = [];

foreach($books as $book) {
    if ($book->belongsToScienceFictionCategory()) {
        $scienceFictionBooks[] = $book->id;
    }
}

return $scienceFictionBooks;

// FONCTIONS DOIVENT FAIRE UNE CHOSE ET BIEN LE FAIRE ; SWITCH => VOIR VIDEO
class User {
    private $name;
    private $email;
    private $age;

    public function __construct($name, $email, $age) {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
    }

    public function save() {
        // Code pour sauvegarder l'utilisateur dans la base de données
    }

    public function sendEmail() {
        // Code pour envoyer un e-mail à l'utilisateur
    }

    public function validateAge() {
        // Code pour valider l'âge de l'utilisateur
    }
}


class User {
    private $name;
    private $email;
    private $age;

    public function __construct($name, $email, $age) {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
    }
}

class DB {
    public function save() {
        //
    }
}

class EmailSender {
    public function send($user) {
        // Code pour envoyer un e-mail à l'utilisateur
    }
}

class AgeValidator {
    public function validate($user) {
        // Code pour valider l'âge de l'utilisateur
    }
}

// Don't pass boolean !

// NBRE DE PARAMETRE IDEAL => ZERO
declare(strict_types=1);

echo 'avant refactorisation';

class ProductManager {
    public function getDiscountedPrice($price, $discount) {
        // Logique de calcul du prix réduit
        $discountedPrice = $price - ($price * ($discount / 100));
        
        // Gestion des limites minimales de prix
        if ($discountedPrice < 0) {
            $discountedPrice = 0;
        }
        
        return $discountedPrice;
    }
}

// Utilisation
$productManager = new ProductManager();
$price = 100;
$discount = 20;
$discountedPrice = $productManager->getDiscountedPrice($price, $discount);
echo $discountedPrice; // Affiche le prix réduit


echo 'exemple après refactorisation';

class DiscountCalculator {
    private $price;
    private $discount;

    public function __construct($price, $discount) {
        $this->price = $price;
        $this->discount = $discount;
    }

    public function calculateDiscountedPrice() {
        $discountedPrice = $this->price - ($this->price * ($this->discount / 100));
        return max($discountedPrice, 0); // Gestion de la limite minimale de prix
    }
}

class ProductManager {
    private $calculator;

    public function __construct(DiscountCalculator $calculator) {
        $this->calculator = $calculator;
    }

    public function getDiscountedPrice() {
        return $this->calculator->calculateDiscountedPrice();
    }
}

// Utilisation
$price = 100;
$discount = 20;
$calculator = new DiscountCalculator($price, $discount);
$productManager = new ProductManager($calculator);
$discountedPrice = $productManager->getDiscountedPrice();
echo $discountedPrice; // Affiche le prix réduit

// INPUT OUTPUT ARGUMENT
// CF DISCOUNT PRICE

// DATA STRUCTURE

// Procedural code (code using data structures) makes it easy to add new functions without changing the existing data structures. OO code, on the other hand, makes it easy to add new classes without changing existing functions.

// In any complex system, there are going to be times when we want to add new data types rather than new functions. For these cases, objects and OO are most appropriate. On the other hand, there will also be times when we'll want to add new functions as opposed to data types. In that case, procedural code and data structures will be more appropriate.


// TIPS

// Use unchecked Exceptions. The price of using checked exceptions is an Open/Closed Principle violation. If you throw a checked exception from a method in your code and the catch is three levels above, you must declare that exception in the signature of each method between you and the catch. This means that a change at a low level of the software can force signature changes on many higher levels. The changed modules must be rebuilt and redeployed, even though nothing they care about changed.
// Don't return NULLWhen we return null, we are essentially creating work for ourselves and foisting problems for our callers. All it takes is one missing null check to send an application spinning out of control.
// Don't pass NULLReturning null from methods is bad, but passing null into methods is worse. Unless you are working with an API which expects you to pass null, you should avoid passing null in your code whenever possible.