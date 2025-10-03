import ModuleLayout from '@/Layouts/ModuleLayout';
import { useTranslations } from '@/utils/translations';
import { Head } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import axios from 'axios';
import mileageSidebarItems from './Sidebar';

function CompaniesTab() {
    const { t } = useTranslations();
    const [companies, setCompanies] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetchCompanies();
    }, []);

    const fetchCompanies = async () => {
        try {
            setLoading(true);
            const response = await axios.get('/mileage/api/companies');
            if (response.data.success) {
                setCompanies(response.data.data);
            } else {
                setError(t('mileage.errors.fetch_companies'));
            }
        } catch (err) {
            setError(t('mileage.errors.fetch_companies'));
            console.error('Error fetching companies:', err);
        } finally {
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <div className="flex justify-center items-center py-8">
                <div className="text-gray-500">{t('common.loading')}</div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="bg-red-50 border border-red-200 rounded-md p-4">
                <div className="text-red-800">{error}</div>
            </div>
        );
    }

    return (
        <div className="space-y-4">
            <div className="flex justify-between items-center">
                <h4 className="text-lg font-medium">{t('mileage.labels.company_list')}</h4>
                <button className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    {t('mileage.actions.add_company')}
                </button>
            </div>
            <div className="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div className="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div className="grid grid-cols-4 gap-4 text-sm font-medium text-gray-700">
                        <div>{t('mileage.labels.name')}</div>
                        <div>{t('mileage.labels.nip')}</div>
                        <div>{t('mileage.labels.phone')}</div>
                        <div>{t('common.actions')}</div>
                    </div>
                </div>
                <div className="divide-y divide-gray-200">
                    {companies.length > 0 ? (
                        companies.map((company) => (
                            <div key={company.id} className="px-6 py-4">
                                <div className="grid grid-cols-4 gap-4 text-sm">
                                    <div className="font-medium text-gray-900">{company.name}</div>
                                    <div className="text-gray-600">{company.nip}</div>
                                    <div className="text-gray-600">{company.phone}</div>
                                    <div className="flex space-x-2">
                                        <button className="text-blue-600 hover:text-blue-800 text-sm">{t('common.edit')}</button>
                                        <button className="text-red-600 hover:text-red-800 text-sm">{t('common.delete')}</button>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="px-6 py-8 text-center text-gray-500">
                            <p>{t('mileage.messages.no_companies')}</p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}

// Podobnie DriversTab i AddressesTab – zastępujemy wszystkie teksty t('klucz')


function DriversTab() {
    const [drivers, setDrivers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetchDrivers();
    }, []);

    const fetchDrivers = async () => {
        try {
            setLoading(true);
            const response = await axios.get('/mileage/api/drivers');
            if (response.data.success) {
                setDrivers(response.data.data);
            } else {
                setError('Błąd podczas pobierania danych kierowców');
            }
        } catch (err) {
            setError('Błąd podczas pobierania danych kierowców');
            console.error('Error fetching drivers:', err);
        } finally {
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <div className="flex justify-center items-center py-8">
                <div className="text-gray-500">Ładowanie...</div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="bg-red-50 border border-red-200 rounded-md p-4">
                <div className="text-red-800">{error}</div>
            </div>
        );
    }

    return (
        <div className="space-y-4">
            <div className="flex justify-between items-center">
                <h4 className="text-lg font-medium">Lista kierowców</h4>
                <button className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Dodaj kierowcę
                </button>
            </div>
            
            <div className="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div className="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div className="grid grid-cols-5 gap-4 text-sm font-medium text-gray-700">
                        <div>Imię i nazwisko</div>
                        <div>Nr prawa jazdy</div>
                        <div>Telefon</div>
                        <div>Firma</div>
                        <div>Akcje</div>
                    </div>
                </div>
                <div className="divide-y divide-gray-200">
                    {drivers.length > 0 ? (
                        drivers.map((driver) => (
                            <div key={driver.id} className="px-6 py-4">
                                <div className="grid grid-cols-5 gap-4 text-sm">
                                    <div className="font-medium text-gray-900">{driver.full_name}</div>
                                    <div className="text-gray-600">{driver.license_number}</div>
                                    <div className="text-gray-600">{driver.phone}</div>
                                    <div className="text-gray-600">{driver.company_name}</div>
                                    <div className="flex space-x-2">
                                        <button className="text-blue-600 hover:text-blue-800 text-sm">Edytuj</button>
                                        <button className="text-red-600 hover:text-red-800 text-sm">Usuń</button>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="px-6 py-8 text-center text-gray-500">
                            <p>Brak kierowców do wyświetlenia</p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}

function AddressesTab() {
    const [addresses, setAddresses] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetchAddresses();
    }, []);

    const fetchAddresses = async () => {
        try {
            setLoading(true);
            const response = await axios.get('/mileage/api/addresses');
            if (response.data.success) {
                setAddresses(response.data.data);
            } else {
                setError('Błąd podczas pobierania danych adresów');
            }
        } catch (err) {
            setError('Błąd podczas pobierania danych adresów');
            console.error('Error fetching addresses:', err);
        } finally {
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <div className="flex justify-center items-center py-8">
                <div className="text-gray-500">Ładowanie...</div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="bg-red-50 border border-red-200 rounded-md p-4">
                <div className="text-red-800">{error}</div>
            </div>
        );
    }

    return (
        <div className="space-y-4">
            <div className="flex justify-between items-center">
                <h4 className="text-lg font-medium">Lista adresów</h4>
                <button className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Dodaj adres
                </button>
            </div>
            
            <div className="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div className="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div className="grid grid-cols-5 gap-4 text-sm font-medium text-gray-700">
                        <div>Nazwa</div>
                        <div>Ulica</div>
                        <div>Miasto</div>
                        <div>Kod pocztowy</div>
                        <div>Akcje</div>
                    </div>
                </div>
                <div className="divide-y divide-gray-200">
                    {addresses.length > 0 ? (
                        addresses.map((address) => (
                            <div key={address.id} className="px-6 py-4">
                                <div className="grid grid-cols-5 gap-4 text-sm">
                                    <div className="font-medium text-gray-900">{address.name}</div>
                                    <div className="text-gray-600">{address.street}</div>
                                    <div className="text-gray-600">{address.city}</div>
                                    <div className="text-gray-600">{address.postal_code}</div>
                                    <div className="flex space-x-2">
                                        <button className="text-blue-600 hover:text-blue-800 text-sm">Edytuj</button>
                                        <button className="text-red-600 hover:text-red-800 text-sm">Usuń</button>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="px-6 py-8 text-center text-gray-500">
                            <p>Brak adresów do wyświetlenia</p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}

export default function MileageDrivers() {
    const { t } = useTranslations();
    const [activeTab, setActiveTab] = useState('companies');

    const tabs = [
        { id: 'companies', name: 'Firmy', component: CompaniesTab },
        { id: 'drivers', name: 'Kierowcy', component: DriversTab },
        { id: 'addresses', name: 'Adresy', component: AddressesTab },
    ];
    
    return (
        <ModuleLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    {t('mileage.title')} - {t('mileage.nav.organizations')}
                </h2>
            }
            sidebarItems={mileageSidebarItems}
            currentRoute="mileage.drivers"
        >
            <Head title={`${t('mileage.title')} - ${t('mileage.nav.organizations')}`} />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h3 className="text-lg font-medium mb-6">
                                Zarządzanie danymi
                            </h3>
                            
                            {/* Tab Navigation */}
                            <div className="border-b border-gray-200 mb-6">
                                <nav className="-mb-px flex space-x-8">
                                    {tabs.map((tab) => (
                                        <button
                                            key={tab.id}
                                            onClick={() => setActiveTab(tab.id)}
                                            className={`py-2 px-1 border-b-2 font-medium text-sm ${
                                                activeTab === tab.id
                                                    ? 'border-blue-500 text-blue-600'
                                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                            }`}
                                        >
                                            {tab.name}
                                        </button>
                                    ))}
                                </nav>
                            </div>

                            {/* Tab Content */}
                            <div className="mt-6">
                                {tabs.map((tab) => {
                                    if (activeTab === tab.id) {
                                        const Component = tab.component;
                                        return <Component key={tab.id} />;
                                    }
                                    return null;
                                })}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </ModuleLayout>
    );
}
