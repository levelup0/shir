import { useEffect } from "react";
import StatusMark from "../Icons/StatusMark";
import StatusViewed from "../Icons/StatusViewed";
import { findStickers, findStickersByText, findStickersResult } from "../lib/sticker-parse/js";

/* eslint-disable react/prop-types */
export default function MessageSend({ data, userProfile, mainUrl }) {
    const d = new Date(data?.created_at)
    const getFullMinutes = (d) => {
        if (d.getMinutes() < 10) {
            return '0' + d.getMinutes();
        }
        return d.getMinutes();
    };

    const getFullHours = (d) => {
        if (d.getHours() < 10) {
            return '0' + d.getHours();
        }
        return d.getHours();
    };

    const resultDate = getFullHours(d) + ':' + getFullMinutes(d);

    return (<>
        <div className="algb-view-wrapper">
            <div className="albg-container-view-send">

                {findStickers(data?.msg)}
                {
                    findStickersByText(data?.msg) != null ?
                        <div
                            style={{ backgroundColor: userProfile?.bg_color }}
                            className="albg-frame"
                        >
                            {findStickersResult(data?.msg, mainUrl)}
                        </div> : null
                }

                <div className="algb-footer-messages-send-container">
                    <div className="albg-text-wrapper-4">{resultDate}</div>
                    <div className="algb-status-sender-message">
                        {
                            data?.status == 'in_progress' ?
                                <StatusMark w={18} h={18} /> : null

                        }

                        {
                            data?.status == 'deliver' ?
                                <div className="algb-deliver-status-send-message-container">
                                    <div className="algb-deliver-status-send-message">
                                        <StatusMark w={18} h={18} />
                                    </div>
                                    <div className="algb-deliver-status-send-message-second">
                                        <StatusMark w={18} h={18} />
                                    </div>
                                </div>
                                : null
                        }

                        {
                            data?.status == 'viewed' ?
                                <div className="algb-deliver-status-send-message-container">
                                    <div className="algb-deliver-status-send-message">
                                        <StatusViewed bgColor={userProfile?.bg_color} w={18} h={18} />
                                    </div>
                                    <div className="algb-deliver-status-send-message-second">
                                        <StatusViewed bgColor={userProfile?.bg_color} w={18} h={18} />
                                    </div>
                                </div>
                                : null
                        }
                    </div>
                </div>
            </div>
        </div>
    </>
    );
}
