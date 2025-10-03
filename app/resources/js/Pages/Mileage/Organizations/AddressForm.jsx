import { useState, useEffect } from 'react';
import { 
    Form, 
    Input, 
    Button, 
    Space, 
    Divider,
    message 
} from 'antd';
import RightSidebar from '@/Layouts/RightSidebar';

export default function AddressForm({ 
    visible, 
    onClose, 
    address = null, 
    onSave,
    loading = false 
}) {
    const [form] = Form.useForm();

    useEffect(() => {
        if (visible && address) {
            form.setFieldsValue(address);
        } else if (visible && !address) {
            form.resetFields();
        }
    }, [visible, address, form]);

    const handleSave = async () => {
        try {
            const values = await form.validateFields();
            await onSave(values);
            message.success(address ? 'Adres zaktualizowany' : 'Adres dodany');
            onClose();
        } catch (error) {
            console.error('Validation failed:', error);
        }
    };

    const formContent = (
        <Form
            form={form}
            layout="vertical"
            requiredMark={false}
            className="h-full"
        >
            <Form.Item
                name="name"
                label="Nazwa adresu"
                rules={[
                    { required: true, message: 'Nazwa jest wymagana' },
                    { min: 2, message: 'Nazwa musi mieć co najmniej 2 znaki' }
                ]}
            >
                <Input placeholder="np. Biuro główne" />
            </Form.Item>

            <Form.Item
                name="street"
                label="Ulica i numer"
                rules={[
                    { required: true, message: 'Ulica jest wymagana' },
                    { min: 3, message: 'Ulica musi mieć co najmniej 3 znaki' }
                ]}
            >
                <Input placeholder="np. ul. Przykładowa 123" />
            </Form.Item>

            <Form.Item
                name="city"
                label="Miasto"
                rules={[
                    { required: true, message: 'Miasto jest wymagane' },
                    { min: 2, message: 'Miasto musi mieć co najmniej 2 znaki' }
                ]}
            >
                <Input placeholder="np. Warszawa" />
            </Form.Item>

            <Form.Item
                name="postal_code"
                label="Kod pocztowy"
                rules={[
                    { required: true, message: 'Kod pocztowy jest wymagany' },
                    { pattern: /^\d{2}-\d{3}$/, message: 'Kod pocztowy musi być w formacie XX-XXX' }
                ]}
            >
                <Input placeholder="00-000" />
            </Form.Item>

            <Form.Item
                name="country"
                label="Kraj"
                initialValue="Polska"
            >
                <Input placeholder="Polska" />
            </Form.Item>

            <Form.Item
                name="notes"
                label="Uwagi"
            >
                <Input.TextArea 
                    rows={4} 
                    placeholder="Dodatkowe informacje o adresie..."
                />
            </Form.Item>
        </Form>
    );

    const footer = (
        <div className="flex justify-end space-x-2">
            <Button onClick={onClose}>
                Anuluj
            </Button>
            <Button 
                type="primary" 
                onClick={handleSave}
                loading={loading}
            >
                {address ? 'Zaktualizuj' : 'Dodaj'}
            </Button>
        </div>
    );

    return (
        <RightSidebar
            visible={visible}
            onClose={onClose}
            title={address ? 'Edytuj adres' : 'Dodaj nowy adres'}
            footer={footer}
            loading={loading}
        >
            {formContent}
        </RightSidebar>
    );
}
