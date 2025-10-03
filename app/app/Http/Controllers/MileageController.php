<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MileageController extends Controller
{
    /**
     * Display the mileage dashboard.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Mileage/Index');
    }

    /**
     * Display the mileage list.
     */
    public function list(Request $request): Response
    {
        return Inertia::render('Mileage/List');
    }

    /**
     * Display vehicles management.
     */
    public function vehicles(Request $request): Response
    {
        return Inertia::render('Mileage/Vehicles');
    }

    /**
     * Display Organizations management.
     */
    public function organizations(Request $request): Response
    {
        return Inertia::render('Mileage/Organizations');
    }

    /**
     * Display routes management.
     */
    public function routes(Request $request): Response
    {
        return Inertia::render('Mileage/Routes');
    }

    /**
     * Get companies list (API endpoint).
     */
    public function getCompanies(Request $request)
    {
        $companies = [
            [
                'id' => 1,
                'name' => 'Przykładowa Firma Sp. z o.o.',
                'nip' => '1234567890',
                'phone' => '+48 123 456 789',
                'email' => 'kontakt@przykladowafirma.pl',
                'address' => 'ul. Biznesowa 123, 00-001 Warszawa',
                'created_at' => '2024-01-15T10:30:00Z',
                'updated_at' => '2024-01-15T10:30:00Z'
            ],
            [
                'id' => 2,
                'name' => 'Transport Solutions Sp. z o.o.',
                'nip' => '9876543210',
                'phone' => '+48 987 654 321',
                'email' => 'biuro@transportsolutions.pl',
                'address' => 'ul. Logistyczna 456, 02-002 Kraków',
                'created_at' => '2024-02-01T14:20:00Z',
                'updated_at' => '2024-02-01T14:20:00Z'
            ],
            [
                'id' => 3,
                'name' => 'Szybka Dostawa S.A.',
                'nip' => '5555666677',
                'phone' => '+48 555 666 777',
                'email' => 'info@szybkadostawa.pl',
                'address' => 'ul. Kurierska 789, 80-001 Gdańsk',
                'created_at' => '2024-02-10T09:15:00Z',
                'updated_at' => '2024-02-10T09:15:00Z'
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $companies,
            'total' => count($companies)
        ]);
    }

    /**
     * Get drivers list (API endpoint).
     */
    public function getDrivers(Request $request)
    {
        $drivers = [
            [
                'id' => 1,
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'full_name' => 'Jan Kowalski',
                'license_number' => 'ABC123456',
                'phone' => '+48 987 654 321',
                'email' => 'jan.kowalski@email.pl',
                'company_id' => 1,
                'company_name' => 'Przykładowa Firma Sp. z o.o.',
                'hire_date' => '2023-06-15',
                'license_expiry' => '2028-06-15',
                'created_at' => '2023-06-15T08:00:00Z',
                'updated_at' => '2023-06-15T08:00:00Z'
            ],
            [
                'id' => 2,
                'first_name' => 'Anna',
                'last_name' => 'Nowak',
                'full_name' => 'Anna Nowak',
                'license_number' => 'DEF789012',
                'phone' => '+48 111 222 333',
                'email' => 'anna.nowak@email.pl',
                'company_id' => 2,
                'company_name' => 'Transport Solutions Sp. z o.o.',
                'hire_date' => '2023-08-01',
                'license_expiry' => '2029-03-20',
                'created_at' => '2023-08-01T10:30:00Z',
                'updated_at' => '2023-08-01T10:30:00Z'
            ],
            [
                'id' => 3,
                'first_name' => 'Piotr',
                'last_name' => 'Wiśniewski',
                'full_name' => 'Piotr Wiśniewski',
                'license_number' => 'GHI345678',
                'phone' => '+48 444 555 666',
                'email' => 'piotr.wisniewski@email.pl',
                'company_id' => 1,
                'company_name' => 'Przykładowa Firma Sp. z o.o.',
                'hire_date' => '2023-09-10',
                'license_expiry' => '2027-12-05',
                'created_at' => '2023-09-10T12:15:00Z',
                'updated_at' => '2023-09-10T12:15:00Z'
            ],
            [
                'id' => 4,
                'first_name' => 'Maria',
                'last_name' => 'Kaczmarek',
                'full_name' => 'Maria Kaczmarek',
                'license_number' => 'JKL901234',
                'phone' => '+48 777 888 999',
                'email' => 'maria.kaczmarek@email.pl',
                'company_id' => 3,
                'company_name' => 'Szybka Dostawa S.A.',
                'hire_date' => '2024-01-05',
                'license_expiry' => '2030-01-15',
                'created_at' => '2024-01-05T14:45:00Z',
                'updated_at' => '2024-01-05T14:45:00Z'
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $drivers,
            'total' => count($drivers)
        ]);
    }

    /**
     * Get addresses list (API endpoint).
     */
    public function getAddresses_v1(Request $request)
    {
        $addresses = [
            [
                'id' => 1,
                'name' => 'Siedziba główna',
                'street' => 'ul. Przykładowa 123',
                'city' => 'Warszawa',
                'postal_code' => '00-001',
                'country' => 'Polska',
                'type' => 'company',
                'company_id' => 1,
                'company_name' => 'Przykładowa Firma Sp. z o.o.',
                'is_default' => true,
                'created_at' => '2024-01-15T10:30:00Z',
                'updated_at' => '2024-01-15T10:30:00Z'
            ],
            [
                'id' => 2,
                'name' => 'Magazyn centralny',
                'street' => 'ul. Magazynowa 456',
                'city' => 'Warszawa',
                'postal_code' => '02-456',
                'country' => 'Polska',
                'type' => 'warehouse',
                'company_id' => 1,
                'company_name' => 'Przykładowa Firma Sp. z o.o.',
                'is_default' => false,
                'created_at' => '2024-01-20T11:00:00Z',
                'updated_at' => '2024-01-20T11:00:00Z'
            ],
            [
                'id' => 3,
                'name' => 'Oddział krakowski',
                'street' => 'ul. Krakowska 789',
                'city' => 'Kraków',
                'postal_code' => '30-001',
                'country' => 'Polska',
                'type' => 'branch',
                'company_id' => 2,
                'company_name' => 'Transport Solutions Sp. z o.o.',
                'is_default' => true,
                'created_at' => '2024-02-01T14:20:00Z',
                'updated_at' => '2024-02-01T14:20:00Z'
            ],
            [
                'id' => 4,
                'name' => 'Terminal gdański',
                'street' => 'ul. Portowa 321',
                'city' => 'Gdańsk',
                'postal_code' => '80-001',
                'country' => 'Polska',
                'type' => 'terminal',
                'company_id' => 3,
                'company_name' => 'Szybka Dostawa S.A.',
                'is_default' => true,
                'created_at' => '2024-02-10T09:15:00Z',
                'updated_at' => '2024-02-10T09:15:00Z'
            ],
            [
                'id' => 5,
                'name' => 'Punkt odbioru - Wrocław',
                'street' => 'ul. Wrocławska 654',
                'city' => 'Wrocław',
                'postal_code' => '50-001',
                'country' => 'Polska',
                'type' => 'pickup_point',
                'company_id' => 2,
                'company_name' => 'Transport Solutions Sp. z o.o.',
                'is_default' => false,
                'created_at' => '2024-02-15T16:30:00Z',
                'updated_at' => '2024-02-15T16:30:00Z'
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $addresses,
            'total' => count($addresses)
        ]);
    }

    public function getAddresses(Request $request)
    {
        $json = <<<EOL
        {
    "success": true,
    "rows": [
        {
        "id": 1,
        "name": "Biuro główne",
        "street": "ul. Przykładowa 123",
        "city": "Warszawa",
        "postal_code": "00-001",
        "country": "Polska",
        "notes": "Główne biuro firmy",
        "created_at": "2024-01-15T10:30:00Z",
        "updated_at": "2024-01-15T10:30:00Z"
        },
        {
        "id": 2,
        "name": "Magazyn",
        "street": "ul. Przemysłowa 45",
        "city": "Kraków",
        "postal_code": "30-001",
        "country": "Polska",
        "notes": "Magazyn główny",
        "created_at": "2024-01-16T14:20:00Z",
        "updated_at": "2024-01-16T14:20:00Z"
        },
        {
        "id": 3,
        "name": "Oddział",
        "street": "ul. Krakowska 789",
        "city": "Kraków",
        "postal_code": "30-001",
        "country": "Polska",
        "notes": "Oddział główny",
        "created_at": "2024-01-17T10:30:00Z",
        "updated_at": "2024-01-17T10:30:00Z"
        },
        {
        "id": 4,
        "name": "Terminal",
        "street": "ul. Portowa 321",
        "city": "Gdańsk",
        "postal_code": "80-001",
        "country": "Polska",
        "notes": "Terminal główny",
        "created_at": "2024-01-18T10:30:00Z",
        "updated_at": "2024-01-18T10:30:00Z"
        },
        {
        "id": 5,
        "name": "Punkt odbioru",
        "street": "ul. Wrocławska 654",
        "city": "Wrocław",
        "postal_code": "50-001",
        "country": "Polska",
        "notes": "Punkt odbioru główny",
        "created_at": "2024-01-19T10:30:00Z",
        "updated_at": "2024-01-19T10:30:00Z"
        },
        {
        "id": 6,
        "name": "Punkt odbioru",
        "street": "ul. Wrocławska 654",
        "city": "Wrocław",
        "postal_code": "50-001",
        "country": "Polska",
        "notes": "Punkt odbioru główny",
        "created_at": "2024-01-19T10:30:00Z",
        "updated_at": "2024-01-19T10:30:00Z"
        },
        {
        "id": 7,
        "name": "Punkt odbioru",
        "street": "ul. Wrocławska 654",
        "city": "Wrocław",
        "postal_code": "50-001",
        "country": "Polska",
        "notes": "Punkt odbioru główny",
        "created_at": "2024-01-19T10:30:00Z",
        "updated_at": "2024-01-19T10:30:00Z"
        },
        {
        "id": 8,
        "name": "Punkt odbioru",
        "street": "ul. Wrocławska 654",
        "city": "Wrocław",
        "postal_code": "50-001",
        "country": "Polska",
        "notes": "Punkt odbioru główny",
        "created_at": "2024-01-19T10:30:00Z",
        "updated_at": "2024-01-19T10:30:00Z"
        },
        {
        "id": 9,
        "name": "Punkt odbioru",
        "street": "ul. Wrocławska 654",
        "city": "Wrocław",
        "postal_code": "50-001",
        "country": "Polska",
        "notes": "Punkt odbioru główny",
        "created_at": "2024-01-19T10:30:00Z",
        "updated_at": "2024-01-19T10:30:00Z"
        },
        {
        "id": 10,
        "name": "Punkt odbioru",
        "street": "ul. Wrocławska 654",
        "city": "Wrocław",
        "postal_code": "50-001",
        "country": "Polska",
        "notes": "Punkt odbioru główny",
        "created_at": "2024-01-19T10:30:00Z",
        "updated_at": "2024-01-19T10:30:00Z"
        },
        {
        "id": 11,
        "name": "Punkt odbioru",
        "street": "ul. Wrocławska 654",
        "city": "Wrocław",
        "postal_code": "50-001",
        "country": "Polska",
        "notes": "Punkt odbioru główny",
        "created_at": "2024-01-19T10:30:00Z",
        "updated_at": "2024-01-19T10:30:00Z"
        },
        {
        "id": 12,
        "name": "Punkt odbioru",
        "street": "ul. Wrocławska 654",
        "city": "Wrocław",
        "postal_code": "50-001",
        "country": "Polska",
        "notes": "Punkt odbioru główny",
        "created_at": "2024-01-19T10:30:00Z",
        "updated_at": "2024-01-19T10:30:00Z"
        }
    ],
    "columns": [
        {
        "title": "Nazwa",
        "dataIndex": "name",
        "key": "name",
        "sorter": true,
        "filters": [
            { "text": "Biuro", "value": "biuro" },
            { "text": "Magazyn", "value": "Magazyn" }
        ]
        },
        {
        "title": "Ulica",
        "dataIndex": "street",
        "key": "street",
        "sorter": true
        },
        {
        "title": "Miasto",
        "dataIndex": "city",
        "key": "city",
        "sorter": true,
        "filters": [
            { "text": "Warszawa", "value": "warszawa" },
            { "text": "Kraków", "value": "kraków" }
        ]
        },
        {
        "title": "Kod pocztowy",
        "dataIndex": "postal_code",
        "key": "postal_code",
        "sorter": true
        }
    ],
    "actions": [
        {
        "key": "edit",
        "label": "Edytuj",
        "type": "primary",
        "onClick": "edit",
        "icon": "Pencil"
        },
        {
        "key": "delete",
        "label": "Usuń",
        "type": "danger",
        "onClick": "delete",
        "icon": "Trash"
        }
    ],
    "pagination": {
        "current": 1,
        "pageSize": 5,
        "total": 12,
        "showSizeChanger": true,
        "pageSizeOptions": ["5", "10", "15", "20"]
    }
}
EOL;

        return response()->json(json_decode($json, true));
        
    }
}
