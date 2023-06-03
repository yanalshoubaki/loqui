import { MessageEntity } from "@/types/entity";
import React from "react";

type Props = {
    message: MessageEntity;
};

const MessageCard = (props: Props) => {
    const { message, ...rest } = props;
    return (
        <div className="flex w-full flex-col items-start justify-between bg-white rounded-md shadow-lg p-4">
            <div className="flex items-center gap-x-4 text-xs">
                <time dateTime="2020-03-16" className="text-gray-500"></time>
            </div>
            <div className="group relative">
                <div>
                    <h3 className="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                        <a href="#">
                            <span className="absolute inset-0"></span>
                            Boost your conversion rate
                        </a>
                    </h3>
                    <img
                        className="inline-block h-6 w-6 rounded-full ring-2 ring-white"
                        src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt=""
                    />
                </div>

                <p className="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                    Illo sint voluptas. Error voluptates culpa eligendi. Hic vel
                    totam vitae illo. Non aliquid explicabo necessitatibus unde.
                    Sed exercitationem placeat consectetur nulla deserunt vel.
                    Iusto corrupti dicta.
                </p>
            </div>
            <div className="relative mt-8 flex items-center gap-x-4">
                <div className="text-sm leading-6">
                    <p className="font-semibold text-gray-900">
                        <a href="#">
                            <span className="absolute inset-0"></span>
                            Michael Foster
                        </a>
                    </p>
                    <p className="text-gray-600">Co-Founder / CTO</p>
                </div>
            </div>
        </div>
    );
};

export default MessageCard;
