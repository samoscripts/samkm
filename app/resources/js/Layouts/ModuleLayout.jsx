import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Layout } from 'antd';
import LeftSidebar from '@/Layouts/LeftSidebar';


export default function ModuleLayout({ header, children, sidebarItems = [] }) {

    return (
        <AuthenticatedLayout header={header} sidebarItems={sidebarItems} >
            <Layout style={{ minHeight: '100vh' }}>
                <Layout>
                <LeftSidebar sidebarItems={sidebarItems} />
                    <Layout.Content>
                        

            {header && (
                <header className="bg-white shadow">
                    <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {header}
                    </div>
                </header>
            )}
                        {children}
                    </Layout.Content>
                </Layout>
            </Layout>
        </AuthenticatedLayout>
    );
}
