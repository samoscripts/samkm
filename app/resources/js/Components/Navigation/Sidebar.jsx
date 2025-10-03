import { Link } from '@inertiajs/react';
import { useTranslations } from '@/utils/translations';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/react/24/outline';
import { useState } from 'react';

export default function Sidebar({ 
    menuItems = [], 
    currentRoute = '', 
    onToggle,
    isMobileOpen = false,
    onMobileToggle
}) {
    const { t } = useTranslations();
    const [isCollapsed, setIsCollapsed] = useState(false);

    const handleToggle = () => {
        const newCollapsedState = !isCollapsed;
        setIsCollapsed(newCollapsedState);
        if (onToggle) {
            onToggle(newCollapsedState);
        }
    };

    return (
        <>
            {/* Mobile Overlay */}
            {isMobileOpen && (
                <div 
                    className="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"
                    onClick={() => onMobileToggle && onMobileToggle(false)}
                />
            )}
            
            {/* Sidebar */}
            <div className={`
                ${isCollapsed ? 'w-16' : 'w-64'} 
                bg-white shadow-sm border-r border-gray-200 min-h-screen 
                transition-all duration-300 ease-in-out relative
                md:relative md:translate-x-0
                ${isMobileOpen ? 'fixed z-30 translate-x-0' : 'fixed z-30 -translate-x-full md:translate-x-0'}
            `}>
            {/* Toggle Button */}
            <button
                onClick={handleToggle}
                className="absolute -right-3 top-6 bg-white border border-gray-200 rounded-full p-1.5 shadow-sm hover:shadow-md transition-shadow duration-200 z-10"
                title={isCollapsed ? 'Rozwiń menu' : 'Zwiń menu'}
            >
                {isCollapsed ? (
                    <ChevronRightIcon className="h-4 w-4 text-gray-600" />
                ) : (
                    <ChevronLeftIcon className="h-4 w-4 text-gray-600" />
                )}
            </button>

            <div className={`${isCollapsed ? 'p-2' : 'p-6'} transition-all duration-300`}>
                {menuItems.map((section, sectionIndex) => (
                    <div key={sectionIndex} className="mb-8">
                        {/* Section Title */}
                        {!isCollapsed && (
                            <h3 className="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 transition-opacity duration-300">
                                {t(section.title)}
                            </h3>
                        )}
                        
                        {/* Section Items */}
                        <nav className="space-y-1">
                            {section.items.map((item, itemIndex) => {
                                const isActive = currentRoute === item.route || 
                                               (item.activeRoutes && item.activeRoutes.includes(currentRoute));
                                
                                return (
                                    <Link
                                        key={itemIndex}
                                        href={route(item.route)}
                                        className={`
                                            group flex items-center ${isCollapsed ? 'px-2 py-3 justify-center' : 'px-3 py-2'} 
                                            text-sm font-medium rounded-md transition-all duration-200
                                            ${isActive 
                                                ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' 
                                                : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50'
                                            }
                                        `}
                                        title={isCollapsed ? t(item.label) : ''}
                                    >
                                        {/* Icon (if provided) */}
                                        {item.icon && (
                                            <item.icon 
                                                className={`
                                                    ${isCollapsed ? '' : 'mr-3'} h-5 w-5 flex-shrink-0
                                                    ${isActive ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'}
                                                `}
                                            />
                                        )}
                                        
                                        {/* Label */}
                                        {!isCollapsed && (
                                            <span className="transition-opacity duration-300">
                                                {t(item.label)}
                                            </span>
                                        )}
                                    </Link>
                                );
                            })}
                        </nav>
                    </div>
                ))}
            </div>
        </div>
        </>
    );
}