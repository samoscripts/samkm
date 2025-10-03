import ModuleLayout from '@/Layouts/ModuleLayout';
import { useTranslations } from '@/utils/translations';
import { Head } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import axios from 'axios';
import mileageSidebarItems from './Sidebar';
import CompaniesTab from './Organizations/CompaniesTab';
import DriversTab from './Organizations/DriversTab';
import AddressesTab from './Organizations/AddressesTab';


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
        >
            <Head title={`${t('mileage.title')} - ${t('mileage.nav.organizations')}`} />

            {/* <div className="py-12"> */}
                {/* <div className="mx-auto max-w-7xl sm:px-6 lg:px-8"> */}
                    <div className="overflow-hidden bg-white">
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
                {/* </div> */}
            {/* </div> */}
        </ModuleLayout>
    );
}
