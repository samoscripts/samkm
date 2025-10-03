import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import { useTranslations } from '@/utils/translations';
import { Transition } from '@headlessui/react';
import { useForm, usePage } from '@inertiajs/react';

export default function UpdateLanguageForm({ className = '' }) {
    const user = usePage().props.auth.user;
    const { status } = usePage().props;
    const { t } = useTranslations();
    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        language: user.language || 'pl',
    });

    const submit = (e) => {
        e.preventDefault();
        patch(route('settings.language.update'));
    };

    return (
        <section className={className}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">
                    {t('settings.language')}
                </h2>
                <p className="mt-1 text-sm text-gray-600">
                    {t('settings.language') === 'Język' ? 'Wybierz preferowany język interfejsu.' : 'Choose your preferred interface language.'}
                </p>
            </header>

            <form onSubmit={submit} className="mt-6 space-y-6">
                <div>
                    <InputLabel htmlFor="language" value={t('settings.language')} />
                    <select
                        id="language"
                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        value={data.language}
                        onChange={(e) => setData('language', e.target.value)}
                    >
                        <option value="pl">{t('settings.polish')}</option>
                        <option value="en">{t('settings.english')}</option>
                    </select>
                    <InputError message={errors.language} className="mt-2" />
                </div>

                <div className="flex items-center gap-4">
                    <PrimaryButton disabled={processing}>{t('common.save')}</PrimaryButton>

                    <Transition
                        show={recentlySuccessful}
                        enter="transition ease-in-out"
                        enterFrom="opacity-0"
                        leave="transition ease-in-out"
                        leaveTo="opacity-0"
                    >
                        <p className="text-sm text-gray-600">
                            {status || 'Zapisano. / Saved.'}
                        </p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
