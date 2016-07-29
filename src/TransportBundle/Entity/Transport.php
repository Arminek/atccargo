<?php

namespace TransportBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Transport
 */
class Transport
{
    private $id;
    private $userId;
    private $identificator;
    private $startCity;
    private $endCity;
    private $startDate;
    private $endDate;
    private $cargo;
    private $distance;
    private $weight;
    private $damage;
    private $burnedFuel;
    private $fueled;
    private $country;
    private $score;
    private $screenshot;
    private $active;

    public function __construct()
    {
        $this->active = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->UserId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getIdentificator()
    {
        return $this->identificator;
    }

    public function setIdentificator($identificator)
    {
        $this->identificator = $identificator;
    }

    public function getStartCity()
    {
        return $this->startCity;
    }

    public function setStartCity($startCity)
    {
        $this->startCity = $startCity;
    }

    public function getEndCity()
    {
        return $this->endCity;
    }

    public function setEndCity($endCity)
    {
        $this->endCity = $endCity;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getDamage()
    {
        return $this->damage;
    }

    public function setDamage($damage)
    {
        $this->damage = $damage;
    }

    public function getBurnedFuel()
    {
        return $this->burnedFuel;
    }

    public function setBurnedFuel($burnedFuel)
    {
        $this->burnedFuel = $burnedFuel;
    }

    public function getFueled()
    {
        return $this->fueled;
    }

    public function setFueled($fueled)
    {
        $this->fueled = $fueled;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function getScreenshot()
    {
        return $this->screenshot;
    }

    public function setScreenshot($screenshot)
    {
        $this->screenshot = $screenshot;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }
}
