<?php

// src/Model/Entity/Rol.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Rol extends Entity
{
    // List of accessible fields
    protected $_accessible = [
        'id' => true,
        'name' => true,
        'description' => true,
        'isVisible' => true,
        'idStatus' => true,
        'dateCreate' => true,
        'dateUpdate' => true
    ];
}
