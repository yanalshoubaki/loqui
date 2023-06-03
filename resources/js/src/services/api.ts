import axios from "axios";

const useClient = () => {
    const instance = axios.create({
        baseURL: "http://loqui-backend.test/",
        timeout: 1000,
        headers: { "X-Custom-Header": "foobar" },
        withCredentials: true,
    });
    return instance;
};
export default useClient;
