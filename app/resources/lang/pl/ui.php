<?php

return [
    // Auth module
    'auth' => [
        'login' => 'Zaloguj się',
        'register' => 'Zarejestruj się',
        'logout' => 'Wyloguj się',
        'email' => 'Email',
        'password' => 'Hasło',
        'confirm_password' => 'Potwierdź hasło',
        'name' => 'Imię',
        'remember_me' => 'Zapamiętaj mnie',
        'forgot_password' => 'Zapomniałeś hasła?',
        'already_registered' => 'Masz już konto?',
        'reset_password' => 'Resetuj hasło',
        'confirm_password_text' => 'Potwierdź swoje hasło przed kontynuowaniem.',
        'confirm' => 'Potwierdź',
        'cancel' => 'Anuluj',
        'send_reset_link' => 'Wyślij link resetujący',
        'verify_email' => 'Zweryfikuj adres email',
        'verification_sent' => 'Nowy link weryfikacyjny został wysłany na Twój adres email.',
        'resend_verification' => 'Wyślij ponownie',
    ],
    
    // Dashboard module
    'dashboard' => [
        'title' => 'Panel główny',
        'logged_in' => 'Jesteś zalogowany!',
    ],
    
    // Mileage module
    'mileage' => [
        'title' => 'Kilometrówka',
        'welcome' => 'Witaj w module kilometrówki',
        'description' => 'Tutaj będziesz mógł zarządzać swoimi przejazdami służbowymi i rozliczać kilometry.',
        'coming_soon' => 'Funkcjonalność w przygotowaniu...',
        
        // Sidebar navigation
        'nav' => [
            'browsing' => 'Przeglądanie',
            'configuration' => 'Konfiguracja',
            'list' => 'Lista',
            'vehicles' => 'Pojazdy',
            'organizations' => 'Organizacje',
            'routes' => 'Trasy',
        ],

        // Organizations / Companies, Drivers, Addresses
        'labels' => [
            'company_list' => 'Lista firm',
            'driver_list' => 'Lista kierowców',
            'address_list' => 'Lista adresów',
            'name' => 'Nazwa',
            'nip' => 'NIP',
            'phone' => 'Telefon',
            'full_name' => 'Imię i nazwisko',
            'license_number' => 'Nr prawa jazdy',
            'street' => 'Ulica',
            'city' => 'Miasto',
            'postal_code' => 'Kod pocztowy',
            'company' => 'Firma',
        ],
        'actions' => [
            'add_company' => 'Dodaj firmę',
            'add_driver' => 'Dodaj kierowcę',
            'add_address' => 'Dodaj adres',
        ],
        'errors' => [
            'fetch_companies' => 'Błąd podczas pobierania danych firm',
            'fetch_drivers' => 'Błąd podczas pobierania danych kierowców',
            'fetch_addresses' => 'Błąd podczas pobierania danych adresów',
        ],
        'messages' => [
            'no_companies' => 'Brak firm do wyświetlenia',
            'no_drivers' => 'Brak kierowców do wyświetlenia',
            'no_addresses' => 'Brak adresów do wyświetlenia',
        ],
    ],
    
    // Profile module
    'profile' => [
        'title' => 'Profil',
        'information' => 'Informacje profilu',
        'information_desc' => 'Zaktualizuj informacje profilu i adres email swojego konta.',
        'update_password' => 'Aktualizuj hasło',
        'update_password_desc' => 'Upewnij się, że Twoje konto używa długiego, losowego hasła, aby pozostać bezpieczne.',
        'current_password' => 'Obecne hasło',
        'new_password' => 'Nowe hasło',
        'delete_account' => 'Usuń konto',
        'delete_account_desc' => 'Po usunięciu konta wszystkie jego zasoby i dane zostaną trwale usunięte. Przed usunięciem konta pobierz wszelkie dane lub informacje, które chcesz zachować.',
        'delete_account_confirm' => 'Czy na pewno chcesz usunąć swoje konto?',
        'delete_account_warning' => 'Po usunięciu konta wszystkie jego zasoby i dane zostaną trwale usunięte. Wprowadź swoje hasło, aby potwierdzić, że chcesz trwale usunąć swoje konto.',
    ],
    
    // Settings module
    'settings' => [
        'title' => 'Ustawienia',
        'language' => 'Język',
        'language_updated' => 'Język został zaktualizowany.',
        'polish' => 'Polski',
        'english' => 'Angielski',
    ],
    
    // Navigation module
    'nav' => [
        'welcome' => 'Witaj',
        'home' => 'Strona główna',
    ],
    
    // Common module
    'common' => [
        'save' => 'Zapisz',
        'saved' => 'Zapisano.',
        'update' => 'Aktualizuj',
        'edit' => 'Edytuj',
        'close' => 'Zamknij',
        'delete' => 'Usuń',
        'cancel' => 'Anuluj',
        'loading' => 'Ładowanie...',
    ],
];
