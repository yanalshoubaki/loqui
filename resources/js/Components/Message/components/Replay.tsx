import { ReplayEntity } from "@/types/entity";

type Props = {
    replay: ReplayEntity;
};

const Replay = (props: Props) => {
    const { replay, ...rest } = props;
    return (
        <ul role="list" className="divide-y divide-gray-100 px-4">
            <li
                key={replay.id}
                className="flex flex-col justify-start items-start gap-x-6 py-4"
            >
                <div className="flex gap-x-2">
                    <img
                        className="h-6 w-6 flex-none rounded-full bg-gray-50"
                        src={replay.user.profile_image.media_path ?? ""}
                        alt=""
                    />
                    <div className="min-w-0 flex-auto">
                        <p className="text-sm font-semibold leading-3 text-gray-900">
                            {replay.user.name}
                        </p>
                        <p className="mt-1 truncate text-xs leading-5 text-gray-500">
                            {"@" + replay.user.username}
                        </p>
                    </div>
                </div>
                <div className="hidden mt-4 sm:flex sm:flex-col sm:items-end">
                    <p className="text-lg  leading-6 text-gray-900">
                        {replay.replay}
                    </p>
                </div>
            </li>
        </ul>
    );
};

export default Replay;
