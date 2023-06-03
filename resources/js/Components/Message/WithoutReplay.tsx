import { MessageEntity } from "@/types/entity";
import { useForm, usePage } from "@inertiajs/react";
import React, { FormEventHandler, useEffect } from "react";
import PrimaryButton from "../PrimaryButton";
import InputLabel from "../InputLabel";
import TextInput from "../TextInput";
import InputError from "../InputError";
import { PageProps } from "@/types";

type Props = {
    message: MessageEntity;
};

const WithoutReplay = (props: Props) => {
    const { message, ...rest } = props;
    const { user } = usePage<PageProps>().props;
    const { data, setData, post, processing, errors, reset } = useForm({
        replay: "",
        message_id: message.id,
        user_id: user.id,
    });
    useEffect(() => {
        return () => {
            reset("replay");
        };
    }, []);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route("messages.add-replay"));
    };
    return (
        <div className="flex w-full flex-col items-start justify-between bg-white rounded-md shadow-lg p-4">
            <div className="flex items-center gap-x-4 text-xs">
                <time dateTime={message.created_at} className="text-gray-500">
                    {message.created_at}
                </time>
                <a
                    href="#"
                    className="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100"
                >
                    {message.is_new ? "New" : ""}
                </a>
            </div>
            <div className="group relative">
                <div>
                    <h3 className="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                        <a href="#">
                            <span className="absolute inset-0"></span>
                            {message.message}
                        </a>
                    </h3>
                    <div className="mt-2 flex gap-3 items-center ">
                        <img
                            className="inline-block h-6 w-6 rounded-full ring-2 ring-white"
                            src={message.sender.profile_image.media_path ?? ""}
                            alt=""
                        />
                        <span>{message.sender.name}</span>
                    </div>
                </div>
            </div>
            <hr />
            <div className="w-full mt-4 pt-4 border-t-[1px] border-gray-300">
                <form onSubmit={submit}>
                    <div className="w-full">
                        <InputLabel htmlFor="replay" value="Replay" />

                        <TextInput
                            id="replay"
                            type="text"
                            name="replay"
                            value={data.replay}
                            className="mt-1 block w-full"
                            autoComplete="text"
                            isFocused={true}
                            onChange={(e) => setData("replay", e.target.value)}
                        />

                        <InputError message={errors.replay} className="mt-2" />
                    </div>

                    <div className="flex items-center justify-end mt-4">
                        <PrimaryButton className="ml-4" disabled={processing}>
                            Add replay
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default WithoutReplay;