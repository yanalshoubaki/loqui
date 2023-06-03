import { AxiosInstance } from "axios";
import Echo from "laravel-echo";
import Pusher from "pusher-js";
import ziggyRoute, { Config as ZiggyConfig } from "ziggy-js";

declare global {
    interface Window {
        axios: AxiosInstance;
        Pusher: typeof Pusher;
        Echo: Echo;
    }

    var route: typeof ziggyRoute;
    var Ziggy: ZiggyConfig;
}
