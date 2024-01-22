export const isProduction = () => import.meta.env.VITE_APP_ENV === 'production';

export const settings = () => {
    return {
        logo: "https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500",
        name: "My Company",
        slogan: null,
        app: {
            env: `${import.meta.env.VITE_APP_ENV}`,
            debugOn: !!(import.meta.env.VITE_APP_DEBUG),
            isProduction: import.meta.env.VITE_APP_ENV === 'production',
        },
        colors: {
            // main: 'indigo', /*
            main: 'sky',/** */
            secondary: null,
        },
    }
}
