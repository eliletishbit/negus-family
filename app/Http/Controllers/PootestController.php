<?php
namespace App\Http\Controllers;
use App\Services\CurrencyConverter;

class PootestController extends Controller {


protected $converter;

public function __construct(CurrencyConverter $converter){

    $this->converter = $converter;

}

public function afficherConversion($montant, $devise){
    //calculer le montant converti
    $montantconvertit = $this->converter->convert($montant,$devise);
    return 'le montat convertir est' .$montantconvertit;
     
}

}







// Dans votre TestController :Le Constructeur :
// Modifiez ou créez le constructeur pour qu'il injecte automatiquement ce service CurrencyConverter. 
// Stockez-le dans une propriété $this->converter.La Route : Créez une route GET du type /convertir/{montant}/{devise}
// qui pointe vers une méthode afficherConversion de votre contrôleur.La Méthode afficherConversion :Elle doit recevoir
// les paramètres de l'URL ($montant et $devise).Elle doit utiliser l'outil stocké dans le constructeur pour calculer 
// le montant converti.Pour l'instant, pas besoin de vue Blade, 
// faites un simple return d'une phrase textuelle (ex: "Le montant converti est de XXXXX").
// Écrivez ce code sans IA, en faisant attention aux imports (use) en haut du fichier, aux parenthèses et aux flèches ->. 

