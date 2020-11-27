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
    private int $id;
    private string $name;
    private int $strength;
    private int $tiredness;

    public const NAMES = ["Archer", "Horseman", "Knight"];
    public const LEVEL_MIN = 20;
    public const LEVEL_MAX = 100;
    public const TIREDNESS_MIN = 0;
    public const TIREDNESS_MAX = 100;
    public const BONUS = 30;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function setRandomStrength(): void
    {
        $this->strength = random_int(self::LEVEL_MIN, self::LEVEL_MAX);
    }

    public function setStrength(int $strength): void
    {
        $this->strength = $strength;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function resetTiredness(): void
    {
        $this->tiredness = self::TIREDNESS_MAX;
    }
    public function getTiredness(): int
    {
        return $this->tiredness;
    }

    public static function bonus($enemyName, $troopName)
    {
        if (
            ($enemyName === 'Knight' && $troopName === 'Archer') ||
            ($enemyName === 'Horseman' && $troopName === 'Knight') ||
            ($enemyName === 'Archer' && $troopName === 'Horseman')
        ) {
            return self::BONUS;
        } else {
            return 0;
        }
    }

    public static function tirednessImpact($tiredness)
    {
        switch ($tiredness) {
            case ">= 80":
                $tirednessImpact = 10;
                break;
            case ">= 50":
                $tirednessImpact = 25;
                break;
            default:
                $tirednessImpact = 40;
        }
        return $tirednessImpact;
    }
}
