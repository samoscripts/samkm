import { useState, useEffect } from 'react';
import { 
    Drawer, 
    Button, 
    Space, 
    Typography 
} from 'antd';
import { XMarkIcon, ArrowsPointingOutIcon, ArrowsPointingInIcon } from '@heroicons/react/24/outline';

const { Title } = Typography;

export default function RightSidebar({ 
    visible, 
    onClose, 
    title,
    children,
    footer,
    loading = false,
    minWidth = 40, // 40% = 2/5
    maxWidth = 80, // 80% = 4/5
    defaultWidth = 40
}) {
    const [sidebarWidth, setSidebarWidth] = useState(defaultWidth);
    const [isResizing, setIsResizing] = useState(false);

    const handleMouseDown = (e) => {
        setIsResizing(true);
        e.preventDefault();
    };

    const handleMouseMove = (e) => {
        if (!isResizing) return;
        
        const windowWidth = window.innerWidth;
        const newWidth = ((windowWidth - e.clientX) / windowWidth) * 100;
        
        // Clamp between minWidth and maxWidth
        const clampedWidth = Math.min(Math.max(newWidth, minWidth), maxWidth);
        setSidebarWidth(clampedWidth);
    };

    const handleMouseUp = () => {
        setIsResizing(false);
    };

    useEffect(() => {
        if (isResizing) {
            document.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', handleMouseUp);
            return () => {
                document.removeEventListener('mousemove', handleMouseMove);
                document.removeEventListener('mouseup', handleMouseUp);
            };
        }
    }, [isResizing]);

    const toggleWidth = () => {
        setSidebarWidth(prev => prev === minWidth ? maxWidth : minWidth);
    };

    return (
        <Drawer
            title={
                <div className="flex items-center justify-between">
                    <Title level={4} style={{ margin: 0 }}>
                        {title}
                    </Title>
                    <Space>
                        <Button
                            type="text"
                            icon={sidebarWidth === minWidth ? <ArrowsPointingOutIcon className="h-4 w-4" /> : <ArrowsPointingInIcon className="h-4 w-4" />}
                            onClick={toggleWidth}
                            title={sidebarWidth === minWidth ? 'Rozszerz' : 'Zwiń'}
                        />
                        <Button
                            type="text"
                            icon={<XMarkIcon className="h-4 w-4" />}
                            onClick={onClose}
                        />
                    </Space>
                </div>
            }
            open={visible}
            onClose={onClose}
            width={`${sidebarWidth}%`}
            placement="right"
            closable={false}
            maskClosable={false}
            styles={{
                body: { padding: 0 }
            }}
        >
            <div className="relative h-full">
                {/* Resize handle */}
                <div
                    className="absolute left-0 top-0 w-1 h-full bg-gray-200 hover:bg-gray-300 cursor-col-resize z-10"
                    onMouseDown={handleMouseDown}
                />
                
                <div className="p-6 h-full overflow-y-auto">
                    {children}
                </div>

                {footer && (
                    <div className="absolute bottom-0 left-0 right-0 p-6 bg-white border-t border-gray-200">
                        {footer}
                    </div>
                )}
            </div>
        </Drawer>
    );
}
