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

    public array $spaltenErstellen = [
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
    ];

    public array $spaltenBearbeiten = [
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
    ];


}
