import { useTranslations } from '@/utils/translations';
import { useState, useEffect } from 'react';
import axios from 'axios';

export default function CompaniesTab() {
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


