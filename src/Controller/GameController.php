<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 26/10/20
 * Time: 9:00
 */

namespace App\Controller;

use App\Model\Troop;
use App\Model\TroopManager;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GameController extends AbstractController
{
    private $troopManager;

    private $troops;

    public function __construct()
    {
        parent::__construct();
        $this->troopManager = new TroopManager();
        //$this->troops[] = new Troop();
    }

    /**
     *  Initialization a new game
     */
    public function init(): string // Assigning the value to a card
    {
        if (false === $this->troopManager->deleteAll()) {
            header("HTTP/1.0 404 Not Found");
            echo '404 - Page not found';
            header('Location: /game/play');
        }

        /**
         *  Instantiates a Archer Object of the Troop class.
         */
        $troops[0] = new Troop();
        $troops[0]->setName("Archer");
        $troops[0]->setRandomLevel();
        
        /**
         *  Instantiates a Horseman Object of the Troop class.
         */
        $troops[1] = new Troop();
        $troops[1]->setName("Horseman");
        $troops[1]->setRandomLevel();
        
        /**
         *  Instantiates a Lancer Object of the Troop class.
         */
        $troops[2] = new Troop();
        $troops[2]->setName("Lancer");
        $troops[2]->setRandomLevel();
        shuffle($troops);


        /**
         *  If he does not find the troops return an error message and redirect to the game page.
         */
        foreach ($troops as $troop) {
            if (false === $this->troopManager->insert($troop)) {
                header("HTTP/1.0 404 Not Found");
                echo '404 - Page not found';
            }
        }
        header('Location: /game/play');
        return "";
    }

    /**
     *  Select troops by ID in the database.
     */
    public function select(int $id)
    {
        $this->troopManager->selectOneById($id);
        header('Location: /game/play');
    }

    /**
     *  Check with the try method and capture if there is an error rendered can be displayed otherwise
     */
    public function play()
    {
        $this->troops = $this->troopManager->selectAll();
        return $this->twig->render("Game/troop.html.twig", ["troops" => $this->troops]);
    }
}
