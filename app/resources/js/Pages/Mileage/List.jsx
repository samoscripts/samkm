import ModuleLayout from '@/Layouts/ModuleLayout';
import { useTranslations } from '@/utils/translations';
import { Head } from '@inertiajs/react';
import mileageSidebarItems from './Sidebar';

export default function MileageList() {
    const { t } = useTranslations();
    
    return (
        <ModuleLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    {t('mileage.title')} - {t('mileage.nav.list')}
                </h2>
            }
            sidebarItems={mileageSidebarItems}
            currentRoute="mileage.list"
        >
            <Head title={`${t('mileage.title')} - ${t('mileage.nav.list')}`} />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h3 className="text-lg font-medium mb-4">
                                {t('mileage.nav.list')}
                            </h3>
                            <p className="text-gray-600 mb-4">
                                Lista wszystkich przejazdów służbowych.
                            </p>
                            
                            <div className="mt-6 p-4 bg-gray-50 rounded-lg">
                                <p className="text-sm text-gray-500">
                                    {t('mileage.coming_soon')}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </ModuleLayout>
    );
}
