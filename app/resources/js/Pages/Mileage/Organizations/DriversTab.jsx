import { useState, useEffect } from 'react';
import axios from 'axios';

export default function DriversTab() {
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


