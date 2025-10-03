import { 
    ListBulletIcon, 
    TruckIcon, 
    UserGroupIcon, 
    MapIcon 
} from '@heroicons/react/24/outline';

export const mileageSidebarItems = [
    {
        title: 'mileage.nav.browsing',
        items: [
            { label: 'mileage.nav.list', route: 'mileage.list', icon: ListBulletIcon },
        ]
    },
    {
        title: 'mileage.nav.configuration',
        items: [
            { label: 'mileage.nav.vehicles', route: 'mileage.vehicles', icon: TruckIcon },
            { label: 'mileage.nav.organizations', route: 'mileage.drivers', icon: UserGroupIcon },
            { label: 'mileage.nav.routes', route: 'mileage.routes', icon: MapIcon },
        ]
    }
];
