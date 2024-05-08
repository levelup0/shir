import AngelIcon from '.././lib/sticker-parse/icons/AngelIcon';
import UniCornIcon from '.././lib/sticker-parse/icons/UniCornIcon';
import ConfusedIcon from '.././lib/sticker-parse/icons/ConfusedIcon';
import RageIcon from '.././lib/sticker-parse/icons/RageIcon';
import ImpIcon from '.././lib/sticker-parse/icons/ImpIcon';
import DisappointedIcon from '.././lib/sticker-parse/icons/DisappointedIcon';
import KissingHeartIcon from '.././lib/sticker-parse/icons/KissingHeartIcon';
import YumIcon from '.././lib/sticker-parse/icons/YumIcon';
import DisappointedReleavedIcon from '.././lib/sticker-parse/icons/DisappointedReleavedIcon';
import WearyIcon from '.././lib/sticker-parse/icons/WearyIcon';
import GreenIcon from '.././lib/sticker-parse/icons/GreenIcon';
import LaughingIcon from '.././lib/sticker-parse/icons/LaughingIcon';
import WinkIcon from '.././lib/sticker-parse/icons/WinkIcon';
import SunglassesIcon from '.././lib/sticker-parse/icons/SunglassesIcon';
import NeutralFaceIcon from '.././lib/sticker-parse/icons/NeutralFaceIcon';
import WinkingEyeIcon from '.././lib/sticker-parse/icons/WinkingEyeIcon';
import HushedIcon from '.././lib/sticker-parse/icons/HushedIcon';
import ThumbsUpIcon from '.././lib/sticker-parse/icons/ThumbsUpIcon';
import ThumbsDownIcon from '.././lib/sticker-parse/icons/ThumbsDownIcon';
import SmileIcon from '.././lib/sticker-parse/icons/SmileIcon';

export default function StickerContainer({ setSticker }) {
  return (<>
    {
      <div className='algb-skickers-list-container'>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':angel:')}>
          <AngelIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':unicorn_face:')}>
          <UniCornIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':confused:')}>
          <ConfusedIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':rage:')}>
          <RageIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':imp:')}>
          <ImpIcon w={25} h={25} />
        </div>

        <div className='algb-skickers-list-items' onClick={() => setSticker(':disappointed:')}>
          <DisappointedIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':kissing_heart:')}>
          <KissingHeartIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':yum:')}>
          <YumIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':disappointed_relieved:')}>
          <DisappointedReleavedIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':weary:')}>
          <WearyIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':grin:')}>
          <GreenIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':laughing:')}>
          <LaughingIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':wink:')}>
          <WinkIcon w={25} h={25} />
        </div>

        <div className='algb-skickers-list-items' onClick={() => setSticker(':sunglasses:')}>
          <SunglassesIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':neutral_face:')}>
          <NeutralFaceIcon w={25} h={25} />

        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':winking_eye:')}>
          <WinkingEyeIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':hushed:')}>
          <HushedIcon w={25} h={25} />

        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':thumbsup:')}>
          <ThumbsUpIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':thumbsdown:')}>
          <ThumbsDownIcon w={25} h={25} />
        </div>
        <div className='algb-skickers-list-items' onClick={() => setSticker(':smile:')}>
          <SmileIcon w={25} h={25} />
        </div>
      </div>
    }

  </>)
}