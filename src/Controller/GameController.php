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
use App\Model\EnemyManager;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GameController extends AbstractController
{
    private $troopManager;

    private $enemyManager;

    public function __construct()
    {
        parent::__construct();
        $this->troopManager = new TroopManager();
        $this->enemyManager = new EnemyManager();
    }

    /**
     *  Initialization a new game
     */
    public function init(): string // Assigning the value to a card
    {
        if (false === $this->troopManager->deleteAll()) {
            header("HTTP/1.1 503 Service Unavailable");
            echo '503 - Service Unavailable';
            return "";
        }

        if (false === $this->enemyManager->deleteAttacker()) {
             header("HTTP/1.1 503 Service Unavailable");
             echo '503 - Service Unavailable';
             return "";
        }

         /**
         *  Instantiates a Archer Object of the Troop class.
         */

        //-------------------------------------Archer------------------------------------
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
                header("HTTP/1.1 503 Service Unavailable");
                echo '503 - Service Unavailable';
                return "";
            }
        }
        header('Location: /game/play');
        return "";
    }

    /**
     *  Select troops by ID in the database.
     * @param int $id
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
        $enemy = $this->enemyManager->selectCurrent();

        if (null === $enemy) {
            $enemy = new Troop();
            $enemy->setRandomName();
            $enemy->setRandomLevel();
            $id = $this->enemyManager->insertEnemy($enemy);
            if (EnemyManager::ERROR === $id) {
                header("HTTP/1.1 503 Service Unavailable");
                echo '503 - Service Unavailable';
                return "";
            }
            $enemy->setId($id);
        }
            $troops = $this->troopManager->selectAll();
            return $this->twig->render("Game/troop.html.twig", ["troops" => $troops, "enemy" => $enemy]);
    }
}
