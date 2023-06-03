import { FormEventHandler, useEffect } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import { UserInfo } from "@/Components/UserInfo";
import { MessageEntity, UserEntity } from "@/types/entity";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";

type Props = {
    messages: {
        data: MessageEntity[];
    };
    user: UserEntity;
    currentUser: UserEntity;

    stats: {
        following: number;
        messages: number;
        followers: number;
    };
};

const Sent = (props: Props) => {
    const { user, currentUser, stats, messages, ...rest } = props;

    const { data, setData, post, processing, errors, reset } = useForm({
        message: "",
        user_id: user.id,
        is_anon: false,
        sender_id: currentUser.id,
    });
    useEffect(() => {
        return () => {
            reset("message");
        };
    }, []);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route("messages.store"));
    };
    return (
        <AuthenticatedLayout user={currentUser}>
            <Head title="Inbox" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex gap-12 flex-wrap flex-col md:flex-row justify-between">
                        <UserInfo className="w-2/6" user={user} stats={stats} />
                        <div className="w-7/12">
                            <div className="p-4 bg-white rounded-lg">
                                <form onSubmit={submit}>
                                    <div className="w-full">
                                        <InputLabel
                                            htmlFor="message"
                                            value="Message"
                                        />

                                        <TextInput
                                            id="message"
                                            type="text"
                                            name="message"
                                            value={data.message}
                                            className="mt-1 block w-full"
                                            autoComplete="text"
                                            isFocused={true}
                                            onChange={(e) =>
                                                setData(
                                                    "message",
                                                    e.target.value
                                                )
                                            }
                                        />

                                        <InputError
                                            message={errors.message}
                                            className="mt-2"
                                        />
                                    </div>

                                    <div className="flex items-center justify-end mt-4">
                                        <PrimaryButton
                                            className="ml-4"
                                            disabled={processing}
                                        >
                                            Send
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Sent;
