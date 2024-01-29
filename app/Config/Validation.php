<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $spalten = [
        'spalte' => [
            'label' => 'Spaltenname',
            'rules' => 'required|min_length[3]|max_length[40]',
            'errors' => [
                'required' => 'Bitte geben Sie einen {field}n an.',
                'min_length' => 'Der {field} muss mindestens {param} Zeichen lang sein.',
                'max_length' => 'Der {field} darf maximal {param} Zeichen lang sein.',
            ],
        ],
        'boardsid' => [
            'label' => 'Board',
            'rules' => 'required|integer',
            'errors' => [
                'required' => 'Bitte wählen Sie ein {field} aus.',
                'integer' => 'Bitte wählen Sie ein {field} aus.',
            ],
        ],
        'sortid' => [
            'label' => 'Sortierungsnummer',
            'rules' => 'required|integer',
            'errors' => [
                'required' => 'Bitte geben Sie eine {field} an.',
                'integer' => 'Bitte geben Sie eine {field} an.',
            ],
        ],
        'spaltenbeschreibung' => [
            'label' => 'Spaltenbeschreibung',
            'rules' => 'max_length[60]',
            'errors' => [
                'max_length' => 'Die {field} darf maximal {param} Zeichen lang sein.',
            ],
        ],
    ];

    public array $tasks = [
        'task' => [
            'label' => 'Taskname',
            'rules' => 'required|min_length[3]|max_length[40]',
            'errors' => [
                'required' => 'Bitte geben Sie einen {field}n an.',
                'min_length' => 'Der {field} muss mindestens {param} Zeichen lang sein.',
                'max_length' => 'Der {field} darf maximal {param} Zeichen lang sein.',
            ],
        ],
        'taskartenid' => [
            'label' => 'Taskart',
            'rules' => 'required|integer',
            'errors' => [
                'required' => 'Bitte wählen Sie eine {field} aus.',
                'integer' => 'Bitte wählen Sie eine {field} aus.',
            ],
        ],
        'spaltenid' => [
            'label' => 'Spalte',
            'rules' => 'required|integer',
            'errors' => [
                'required' => 'Bitte wählen Sie eine {field} aus.',
                'integer' => 'Bitte wählen Sie eine {field} aus.',
            ],
        ],
        'personenid' => [
            'label' => 'Person',
            'rules' => 'required|integer',
            'errors' => [
                'required' => 'Bitte wählen Sie eine {field} aus.',
                'integer' => 'Bitte wählen Sie eine {field} aus.',
            ],
        ],
        'notizen' => [
            'label' => 'Notizen',
            'rules' => 'max_length[255]',
            'errors' => [
                'max_length' => 'Die {field} darf maximal {param} Zeichen lang sein.',
            ],
        ],
    ];

    public array $boards = [
        'board' => [
            'label' => 'Boardname',
            'rules' => 'required|min_length[3]|max_length[40]',
            'errors' => [
                'required' => 'Bitte geben Sie einen {field}n an.',
                'min_length' => 'Der {field} muss mindestens {param} Zeichen lang sein.',
                'max_length' => 'Der {field} darf maximal {param} Zeichen lang sein.',
            ],
        ],
    ];

    public array $personen = [
        'vorname' => [
            'label' => 'Vorname',
            'rules' => 'required|min_length[3]|max_length[40]',
            'errors' => [
                'required' => 'Bitte geben Sie einen {field} an.',
                'min_length' => 'Der {field} muss mindestens {param} Zeichen lang sein.',
                'max_length' => 'Der {field} darf maximal {param} Zeichen lang sein.',
            ],
        ],
        'nachname' => [
            'label' => 'Nachname',
            'rules' => 'required|min_length[3]|max_length[40]',
            'errors' => [
                'required' => 'Bitte geben Sie einen {field} an.',
                'min_length' => 'Der {field} muss mindestens {param} Zeichen lang sein.',
                'max_length' => 'Der {field} darf maximal {param} Zeichen lang sein.',
            ],
        ],
        'email' => [
            'label' => 'E-Mail',
            'rules' => 'required|valid_email|is_unique[personen.email]',
            'errors' => [
                'required' => 'Bitte geben Sie eine {field} an.',
                'valid_email' => 'Bitte geben Sie eine gültige {field} an.',
                'is_unique' => 'Diese {field} ist bereits vergeben.',
            ],
        ],
        'passwort' => [
            'label' => 'Passwort',
            'rules' => 'required|min_length[4]',
            'errors' => [
                'required' => 'Bitte geben Sie ein {field} an.',
                'min_length' => 'Das {field} muss mindestens {param} Zeichen lang sein.',
            ],
        ],
    ];


}
