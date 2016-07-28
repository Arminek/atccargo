<?php

namespace TransportBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Transport
 */
class Transport
{
    private $id;
    private $employeeId;
    private $startCity;
    private $endCity;
    private $cargo;
    private $distance;
    private $weight;
    private $damage;
    private $fuel;
    private $fueled;
    private $country;
    private $score;
    private $transportId;
    private $screenshot;
    private $active;
    private $startDate;
    private $endDate;
    private $user;

    public function __construct()
    {
        $this->active = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
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

    public function getFuel()
    {
        return $this->fuel;
    }

    public function setFuel($fuel)
    {
        $this->fuel = $fuel;
    }

    public function getFueled()
    {
        return $this->fuel;
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

    public function getTransportId()
    {
        return $this->transportId;
    }

    public function setTransportId($transportId)
    {
        $this->transportId = $transportId;
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
}
