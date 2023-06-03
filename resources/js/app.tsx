import "./bootstrap";
import "../css/app.css";

import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import AuthenticatedLayout from "./Layouts/AuthenticatedLayout";
import GuestLayout from "./Layouts/GuestLayout";
import { UserEntity } from "./types/entity";
const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.tsx`,
            import.meta.glob("./Pages/**/*.tsx")
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);
        const queryClient = new QueryClient();
        const pageProps = props.initialPage.props;
        root.render(
            <QueryClientProvider client={queryClient}>
                {pageProps.is_logged_in ? (
                    <AuthenticatedLayout user={pageProps.user as UserEntity}>
                        <App {...props} />
                    </AuthenticatedLayout>
                ) : (
                    <GuestLayout>
                        <App {...props} />
                    </GuestLayout>
                )}
            </QueryClientProvider>
        );
    },
    progress: {
        color: "#4B5563",
    },
});
