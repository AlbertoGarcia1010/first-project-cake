<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class RolesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Table configuration
        $this->setTable('roles'); // Ensure this is the correct table name
        $this->setPrimaryKey('rol_id'); // Set the primary key if applicable
        $this->setDisplayField('name');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_create' => 'new', // 'created' solo para nuevas entradas
                    'date_update' => 'always' // 'modified' para nuevas y actualizaciones
                ]
            ]
        ]);

    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('name', 'El nombre es requerido')
            ->notEmptyString('description', 'La descripción es requerida');

        return $validator;
    }
}
