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
        'spalte' => 'required|min_length[3]|max_length[40]',
        'boardsid' => 'required|integer',
        'sortid' => 'required|integer',
    ];

    public array $spaltenBearbeiten = [
        'spalte' => 'required|min_length[3]|max_length[40]',
        'boardsid' => 'required|integer',
        'sortid' => 'required|integer',
    ];

    public array $spaltenErstellen_errors = [
        'spalte' => [
            'required' => 'Bitte geben Sie einen Spaltenname ein.',
            'min_length' => 'Der Spaltenname muss mindestens 3 Zeichen lang sein.',
            'max_length' => 'Der Spaltenname darf maximal 40 Zeichen lang sein.',
        ],
        'boardsid' => [
            'required' => 'Bitte wählen Sie ein Board aus.',
            'integer' => 'Bitte wählen Sie ein Board aus.',
        ],
        'sortid' => [
            'required' => 'Bitte geben Sie eine Sortierungsnummer ein.',
            'integer' => 'Bitte geben Sie eine Sortierungsnummer ein.',
        ],
    ];

    public array $spaltenBearbeiten_errors = [
        'spalte' => [
            'required' => 'Bitte geben Sie einen Spaltenname ein.',
            'min_length' => 'Der Spaltenname muss mindestens 3 Zeichen lang sein.',
            'max_length' => 'Der Spaltenname darf maximal 40 Zeichen lang sein.',
        ],
        'boardsid' => [
            'required' => 'Bitte wählen Sie ein Board aus.',
            'integer' => 'Bitte wählen Sie ein Board aus.',
        ],
        'sortid' => [
            'required' => 'Bitte geben Sie eine Sortierungsnummer ein.',
            'integer' => 'Bitte geben Sie eine Sortierungsnummer ein.',
        ],
    ];


}
