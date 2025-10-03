import { useState, useEffect } from 'react';
import axios from 'axios';
import { Table, Button, Spin, Alert, Space, Typography, Input, Tooltip } from 'antd';
import AddressForm from './AddressForm';
import ButtonIcon from '@/Components/Ant/ButtonIcon';

export default function AddressesTab() {
    const [addresses, setAddresses] = useState([]);
    const [tableColumns, setTableColumns] = useState([]);
    const [actions, setActions] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [pagination, setPagination] = useState({ current: 1, pageSize: 10, total: 0 });
    const [sorter, setSorter] = useState({ field: null, order: null });
    const [filters, setFilters] = useState({});
    const [search, setSearch] = useState('');
    const [formVisible, setFormVisible] = useState(false);
    const [editingAddress, setEditingAddress] = useState(null);
    const [formLoading, setFormLoading] = useState(false);
    const [allAddresses, setAllAddresses] = useState([]); // Wszystkie dane
    const [filteredAddresses, setFilteredAddresses] = useState([]); // Filtrowane dane

    // Pobierz dane tylko raz przy załadowaniu
    useEffect(() => {
        fetchAddresses({
            page: 1,
            pageSize: 1000, // Pobierz wszystkie dane
            sortField: null,
            sortOrder: null,
            search: '',
            ...filters,
        });
    }, []);

    // Filtruj dane po stronie klienta
    useEffect(() => {
        let filtered = [...allAddresses];

        // Wyszukiwanie
        if (search) {
            const searchLower = search.toLowerCase();
            filtered = filtered.filter(address => 
                address.name?.toLowerCase().includes(searchLower) ||
                address.street?.toLowerCase().includes(searchLower) ||
                address.city?.toLowerCase().includes(searchLower) ||
                address.postal_code?.toLowerCase().includes(searchLower)
            );
        }

        // Filtry kolumn
        if (filters && Object.keys(filters).length > 0) {
            Object.entries(filters).forEach(([field, filterValues]) => {
                if (filterValues && filterValues.length > 0) {
                    filtered = filtered.filter(address => 
                        filterValues.includes(address[field])
                    );
                }
            });
        }

        // Sortowanie
        if (sorter.field && sorter.order) {
            filtered.sort((a, b) => {
                const aVal = a[sorter.field];
                const bVal = b[sorter.field];
                
                if (sorter.order === 'ascend') {
                    return aVal > bVal ? 1 : -1;
                } else {
                    return aVal < bVal ? 1 : -1;
                }
            });
        }

        setFilteredAddresses(filtered);
        setPagination(prev => ({ ...prev, total: filtered.length }));
    }, [allAddresses, search, sorter.field, sorter.order, filters]);

    const fetchAddresses = async (params = {}) => {
        try {
            setLoading(true);
            const response = await axios.get('/mileage/api/addresses', { params });
            if (response.data.success) {
                const rows = response.data.rows || [];
                setAllAddresses(rows); // Zapisz wszystkie dane
                const colsFromApi = response.data.columns || [];
                const actionsFromApi = response.data.actions || [];
                setActions(actionsFromApi);

                if (colsFromApi.length > 0) {
                    setTableColumns(buildAntColumns(colsFromApi, actionsFromApi));
                } else {
                    setError(t('mileage.errors.fetch_addresses'));
                }

                // Ustaw paginację na podstawie wszystkich danych
                setPagination((prev) => ({
                    ...prev,
                    current: 1,
                    pageSize: prev.pageSize,
                    total: rows.length,
                }));
            } else {
                setError(t('mileage.errors.fetch_addresses'));
            }
        } catch (err) {
            setError(t('mileage.errors.fetch_addresses'));
            console.error('Error fetching addresses:', err);
        } finally {
            setLoading(false);
        }
    };

    const buildAntColumns = (cols, actionsFromApi) => {
        const mapped = cols.map((c) => ({
            title: c.title,
            dataIndex: c.dataIndex,
            key: c.key || c.dataIndex,
            sorter: c.sorter || false,
            filters: c.filters || undefined,
            render: c.render || undefined,
        }));

        if (actionsFromApi && actionsFromApi.length > 0) {
            mapped.push({
                title: 'Akcje',
                key: 'actions',
                render: (_, record) => (
                    <Space>
                        {actionsFromApi.map((a) => (
                            a.icon && (
                                <ButtonIcon 
                                    iconName={a.icon} 
                                    type={a.type === 'danger' ? 'link' : 'link'}
                                    danger={a.type === 'danger'}
                                    tooltip={a.label} 
                                    onClick={() => handleAction(a, record)} 
                                />
                            ) || (
                                <Button
                                    key={a.key}
                                    type={a.type === 'danger' ? 'link' : 'link'}
                                    danger={a.type === 'danger'}
                                    onClick={() => handleAction(a, record)}
                                >
                                    {a.label}
                                </Button>
                            )
                        ))}
                    </Space>
                ),
            });
        } 
        return mapped;
    };

    const handleAction = (action, record) => {
        if (action?.onClick === 'edit') {
            setEditingAddress(record);
            setFormVisible(true);
        } else if (action?.onClick === 'delete') {
            console.log('delete', record);
        } else if (action?.onClickUrl) {
            window.location.href = action.onClickUrl.replace(':id', record.id);
        }
    };

    const handleAddAddress = () => {
        setEditingAddress(null);
        setFormVisible(true);
    };

    const handleFormClose = () => {
        setFormVisible(false);
        setEditingAddress(null);
    };

    const handleFormSave = async (values) => {
        setFormLoading(true);
        try {
            const url = editingAddress 
                ? `/mileage/api/addresses/${editingAddress.id}` 
                : '/mileage/api/addresses';
            const method = editingAddress ? 'put' : 'post';
            
            const response = await axios[method](url, values);
            if (response.data.success) {
                // Refresh the table - pobierz wszystkie dane ponownie
                fetchAddresses({
                    page: 1,
                    pageSize: 1000,
                    sortField: null,
                    sortOrder: null,
                    search: '',
                    ...filters,
                });
            }
        } catch (error) {
            console.error('Error saving address:', error);
        } finally {
            setFormLoading(false);
        }
    };

    const handleTableChange = (paginationInfo, filtersInfo, sorterInfo) => {
        setPagination({
            current: paginationInfo.current,
            pageSize: paginationInfo.pageSize,
            total: pagination.total,
        });
        const nextSorter = {
            field: sorterInfo.field || sorterInfo.columnKey || null,
            order: sorterInfo.order || null,
        };
        setSorter(nextSorter);
        setFilters(filtersInfo || {});
        // Nie odpytywaj API - sortowanie, filtrowanie i wyszukiwanie jest po stronie klienta
    };

    if (loading) {
        return (
            <div className="flex justify-center items-center py-8">
                <Spin />
            </div>
        );
    }

    if (error) {
        return (
            <Alert type="error" message={error} showIcon />
        );
    }

    return (
        <div className="space-y-4">
            <div className="flex justify-between items-center">
                <Typography.Title level={4} style={{ margin: 0 }}>Lista adresów</Typography.Title>
                <Space>
                    <Input.Search
                        allowClear
                        placeholder="Szukaj..."
                        onSearch={(val) => setSearch(val)}
                        onChange={(e) => {
                            const value = e.target.value;
                            if (!value) {
                                setSearch('');
                            } else if (value.length >= 2) {
                                setSearch(value);
                            }
                        }}
                        style={{ width: 260 }}
                    />
                    <Button type="primary" onClick={handleAddAddress}>Dodaj adres</Button>
                </Space>
            </div>

            <Table
                rowKey="id"
                columns={tableColumns.length ? tableColumns : []}
                dataSource={filteredAddresses}
                pagination={{ 
                    current: pagination.current, 
                    pageSize: pagination.pageSize, 
                    total: pagination.total, 
                    showSizeChanger: true,
                    showQuickJumper: true,
                    showTotal: (total, range) => `${range[0]}-${range[1]} z ${total} adresów`
                }}
                onChange={handleTableChange}
            />

            <AddressForm
                visible={formVisible}
                onClose={handleFormClose}
                address={editingAddress}
                onSave={handleFormSave}
                loading={formLoading}
            />
        </div>
    );
}


