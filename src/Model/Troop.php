<?php

/**
 * Created by PhpStorm.
 * User: Max
 * Date: 26/10/20
 * Time: 9:00
 */

namespace App\Model;

class Troop
{
    /**
     * @var int
     */
    private $level;

    /**
     * @var int
     */
    private $tiredness;

    /**
     * @var string
     */
    private $name;

    private $id;

    public const NAMES = ['Archer', 'Horseman', 'Lancer'];
    public const LEVEL_MIN = 20;
    public const LEVEL_MAX = 100;
    public const TIREDNESS_MAX = 100; /* Defined a Tiredness Max on troupes */
    public const TIREDNESS_MIN = 0; /* Defined a Tiredness Min on troupes */

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setRandomLevel(): void
    {
        $this->level = random_int(self::LEVEL_MIN, self::LEVEL_MAX);
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setRandomName(): void
    {
        $this->name = self::NAMES[random_int(0, 2)];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setTiredness(): void
    {
        $this->tiredness = self::TIREDNESS_MAX;
    }
    public function getTiredness(): int
    {
        return $this->tiredness;
    }
}
