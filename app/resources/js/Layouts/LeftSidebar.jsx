import { useState, useMemo } from 'react';
import { Bars3Icon } from '@heroicons/react/24/outline';
import { Layout, Menu, Drawer, Button } from 'antd';
import { Link } from '@inertiajs/react';
import { useTranslations } from '@/utils/translations';
import { usePage } from '@inertiajs/react';

export default function LeftSidebar({ sidebarItems = [] }) {
    const { t } = useTranslations();
    const [isSidebarCollapsed, setIsSidebarCollapsed] = useState(false);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const { url } = usePage();

    const currentRoute = useMemo(() => {
        if (!url || url === "/") return "";
        return url.split("/").filter(Boolean).join(".");
    }, [url]);

    const handleSidebarToggle = (collapsed) => {
        setIsSidebarCollapsed(collapsed);
    };

    const toggleMobileMenu = () => {
        setIsMobileMenuOpen(!isMobileMenuOpen);
    };

    const menuItemsAnt = useMemo(() => {
        return (sidebarItems || []).map((section, sectionIndex) => ({
            type: 'group',
            key: `group-${sectionIndex}`,
            label: t(section.title),
            children: (section.items || []).map((item) => ({
                key: item.route,
                label: (
                    <Link href={route(item.route)}>
                        {t(item.label)}
                    </Link>
                ),
                icon: item.icon ? <item.icon className="h-5 w-5" /> : undefined,
            })),
        }));
    }, [sidebarItems, t]);

    return (
        <>
            <Layout.Sider
                collapsible
                collapsed={isSidebarCollapsed}
                onCollapse={handleSidebarToggle}
                width={256}
                breakpoint="md"
                collapsedWidth={64}
                theme="light"
                className="hidden md:block"
                style={{ 
                    borderRight: '1px solid #e5e7eb'
                }}
            >
                <Menu
                    mode="inline"
                    selectedKeys={[currentRoute]}
                    items={menuItemsAnt}
                    style={{ 
                        borderRight: '0px solid #e5e7eb'
                    }}
                />
            </Layout.Sider>

            {/* Mobile Header with menu button */}
            <Layout.Header 
            className="md:hidden bg-gray" style={{ height: 56, lineHeight: '56px' }}>
                <Button
                    type="text"
                    onClick={toggleMobileMenu}
                    icon={<Bars3Icon className="h-6 w-6" />}
                />
                
            </Layout.Header>

            {/* Mobile Drawer Menu */}
            <Drawer
                open={isMobileMenuOpen}
                onClose={() => setIsMobileMenuOpen(false)}
                placement="left"
                width={256}
                bodyStyle={{ padding: 0 }}
            >
                <Menu
                    mode="inline"
                    selectedKeys={[currentRoute]}
                    items={menuItemsAnt}
                    style={{ height: '100%', borderRight: 0 }}
                    onClick={() => setIsMobileMenuOpen(false)}
                />
            </Drawer>
        </>
    );
}

