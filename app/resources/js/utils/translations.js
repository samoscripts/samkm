import { usePage } from '@inertiajs/react';

export function useTranslations() {
    const { translations } = usePage().props;
    
    const t = (key, fallback = key) => {
        // Support nested keys like 'auth.login' or 'profile.title'
        const keys = key.split('.');
        let value = translations;
        
        for (const k of keys) {
            if (value && typeof value === 'object' && k in value) {
                value = value[k];
            } else {
                return fallback;
            }
        }
        
        return value || fallback;
    };
    
    return { t, translations };
}

export function trans(key, fallback = key) {
    // For use outside of React components
    if (typeof window !== 'undefined' && window.translations) {
        const keys = key.split('.');
        let value = window.translations;
        
        for (const k of keys) {
            if (value && typeof value === 'object' && k in value) {
                value = value[k];
            } else {
                return fallback;
            }
        }
        
        return value || fallback;
    }
    return fallback;
}
