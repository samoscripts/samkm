import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Sidebar from '@/Components/Navigation/Sidebar';
import { useState } from 'react';
import { Bars3Icon } from '@heroicons/react/24/outline';
import { 
    ListBulletIcon, 
    TruckIcon, 
    UserGroupIcon, 
    MapIcon 
} from '@heroicons/react/24/outline';

export default function ModuleLayout({ header, children, sidebarItems = [], currentRoute = '' }) {
    const [isSidebarCollapsed, setIsSidebarCollapsed] = useState(false);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

    const handleSidebarToggle = (collapsed) => {
        setIsSidebarCollapsed(collapsed);
    };

    const toggleMobileMenu = () => {
        setIsMobileMenuOpen(!isMobileMenuOpen);
    };

    return (
        <AuthenticatedLayout header={header}>
            {/* Mobile Menu Button */}
            <div className="md:hidden bg-white border-b border-gray-200 px-4 py-2">
                <button
                    onClick={toggleMobileMenu}
                    className="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100"
                >
                    <Bars3Icon className="h-6 w-6" />
                </button>
            </div>

            <div className="flex">
                {/* Sidebar */}
                <Sidebar 
                    menuItems={sidebarItems} 
                    currentRoute={currentRoute}
                    onToggle={handleSidebarToggle}
                    isMobileOpen={isMobileMenuOpen}
                    onMobileToggle={setIsMobileMenuOpen}
                />
                
                {/* Main Content */}
                <div className={`
                    flex-1 transition-all duration-300 ease-in-out
                    ${isSidebarCollapsed ? 'md:ml-0' : 'md:ml-0'}
                    w-full md:w-auto
                `}>
                    {children}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
