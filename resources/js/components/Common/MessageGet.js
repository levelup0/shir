import { findStickers, findStickersByText, findStickersResult } from "../lib/sticker-parse/js";

/* eslint-disable react/prop-types */
export default function MessageGet({ data, userData, mainUrl }) {
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

    return (
        <>
            <div className="albg-view-7">
                <div>
                    {userData != null && userData != '' ? <img className="albg-avatar-image-2" alt="Image" src={userData?.avatar} /> : null}
                </div>
                <div className="albg-view-8">
                    {findStickers(data?.msg)}
                    {

                        findStickersByText(data?.msg) != null ?
                            <div className="albg-div-wrapper">

                                <div className="albg-p">
                                    {findStickersResult(data?.msg, mainUrl)}
                                </div>  </div> : null
                    }
                    {/* <div className="albg-div-wrapper">

                        <div className="albg-p">
                            {data?.msg}
                            
                            </div>
                    </div> */}
                    <div className="albg-text-wrapper-4">{resultDate}</div>
                </div>
            </div>
        </>
    );
}
