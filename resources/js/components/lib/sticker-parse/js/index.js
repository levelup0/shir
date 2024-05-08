import AngelIcon from "../icons/AngelIcon"
import ConfusedIcon from "../icons/ConfusedIcon"
import DisappointedIcon from "../icons/DisappointedIcon"
import DisappointedReleavedIcon from "../icons/DisappointedReleavedIcon"
import GreenIcon from "../icons/GreenIcon"
import HushedIcon from "../icons/HushedIcon"
import ImpIcon from "../icons/ImpIcon"
import KissingHeartIcon from "../icons/KissingHeartIcon"
import LaughingIcon from "../icons/LaughingIcon"
import NeutralFaceIcon from "../icons/NeutralFaceIcon"
import RageIcon from "../icons/RageIcon"
import SmileIcon from "../icons/SmileIcon"
import SunglassesIcon from "../icons/SunglassesIcon"
import ThumbsDownIcon from "../icons/ThumbsDownIcon"
import ThumbsUpIcon from "../icons/ThumbsUpIcon"
import UniCornIcon from "../icons/UniCornIcon"
import WearyIcon from "../icons/WearyIcon"
import WinkIcon from "../icons/WinkIcon"
import WinkingEyeIcon from "../icons/WinkingEyeIcon"
import YumIcon from "../icons/YumIcon"

export const findStickers = (text) => {
  if (text.length > 0) {
    if (text == ':angel:') {
      return (
        <div className="sticker-container-once">
          <AngelIcon w={60} h={60} />
        </div>
      )
    }
    if (text == ':unicorn_face:') {
      return (
        <div className="sticker-container-once">
          <UniCornIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':confused:') {
      return (
        <div className="sticker-container-once">
          <ConfusedIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':rage:') {
      return (
        <div className="sticker-container-once">
          <RageIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':imp:') {
      return (
        <div className="sticker-container-once">
          <ImpIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':disappointed:') {
      return (
        <div className="sticker-container-once">
          <DisappointedIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':kissing_heart:') {
      return (
        <div className="sticker-container-once">
          <KissingHeartIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':yum:') {
      return (
        <div className="sticker-container-once">
          <YumIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':disappointed_relieved:') {
      return (
        <div className="sticker-container-once">
          <DisappointedReleavedIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':weary:') {
      return (
        <div className="sticker-container-once">
          <WearyIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':grin:') {
      return (
        <div className="sticker-container-once">
          <GreenIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':laughing:') {
      return (
        <div className="sticker-container-once">
          <LaughingIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':wink:') {
      return (
        <div className="sticker-container-once">
          <WinkIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':sunglasses:') {
      return (
        <div className="sticker-container-once">
          <SunglassesIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':neutral_face:') {
      return (
        <div className="sticker-container-once">
          <NeutralFaceIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':winking_eye:') {
      return (
        <div className="sticker-container-once">
          <WinkingEyeIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':hushed:') {
      return (
        <div className="sticker-container-once">
          <HushedIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':thumbsup:') {
      return (
        <div className="sticker-container-once">
          <ThumbsUpIcon w={60} h={60} />
        </div>
      )
    }
    if (text == ':thumbsdown:') {
      return (
        <div className="sticker-container-once">
          <ThumbsDownIcon w={60} h={60} />
        </div>
      )
    }

    if (text == ':smile:') {
      return (
        <div className="sticker-container-once">
          <SmileIcon w={60} h={60} />
        </div>
      )
    }


    return null
  }
}

export const findStickersByText = (text) => {
  if (text == ':angel:') {
    return null
  }

  if (text == ':unicorn_face:') {
    return null
  }

  if (text == ':confused:') {
    return null
  }

  if (text == ':rage:') {
    return null
  }

  if (text == ':imp:') {
    return null
  }

  if (text == ':disappointed:') {
    return null
  }

  if (text == ':kissing_heart:') {
    return null
  }

  if (text == ':yum:') {
    return null
  }

  if (text == ':disappointed_relieved:') {
    return null
  }

  if (text == ':weary:') {
    return null
  }

  if (text == ':grin:') {
    return null
  }

  if (text == ':laughing:') {
    return null
  }
  if (text == ':wink:') {
    return null
  }
  if (text == ':sunglasses:') {
    return null
  }

  if (text == ':neutral_face:') {
    return null
  }
  if (text == ':winking_eye:') {
    return null
  }

  if (text == ':hushed:') {
    return null
  }
  if (text == ':thumbsup:') {
    return null
  }

  if (text == ':thumbsdown:') {
    return null
  }

  if (text == ':smile:') {
    return null
  }


  return text
}

export const getMatchIndexes = (str, toMatch) => {
  var toMatchLength = toMatch.length,
    indexMatches = [], match,
    i = 0;

  while ((match = str.indexOf(toMatch, i)) > -1) {
    indexMatches.push(match);
    i = match + toMatchLength;
  }

  return indexMatches;
}

export const findStickersResult = (text, mainUrl) => {
  if (text.length > 0) {
    let splited = text.split('');

    //Angel
    const angelStikers = getMatchIndexes(text, ':angel:');
    if (angelStikers.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikers.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/angel.svg)'
        splited.splice(angelStikers[i], 7, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //UniCorn
    const angelStikersUniCorn = getMatchIndexes(text, ':unicorn_face:');
    if (angelStikersUniCorn.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersUniCorn.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/unicorn.svg)'
        splited.splice(angelStikersUniCorn[i], 14, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //Confised
    const angelStikersConfisued = getMatchIndexes(text, ':confused:');
    if (angelStikersConfisued.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersConfisued.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/confised.svg)'
        splited.splice(angelStikersConfisued[i], 10, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //Rage
    const angelStikersRage = getMatchIndexes(text, ':rage:');
    if (angelStikersRage.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersRage.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/rage.svg)'
        splited.splice(angelStikersRage[i], 6, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //Imp
    const angelStikersImp = getMatchIndexes(text, ':imp:');
    if (angelStikersImp.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersImp.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/imp.svg)'
        splited.splice(angelStikersImp[i], 5, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //dissappointed
    const angelStikersDisappointed = getMatchIndexes(text, ':disappointed:');
    if (angelStikersDisappointed.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersDisappointed.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/dissappointed.svg)'
        splited.splice(angelStikersDisappointed[i], 14, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //kissing_heart
    const angelStikerskissing_heart = getMatchIndexes(text, ':kissing_heart:');
    if (angelStikerskissing_heart.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikerskissing_heart.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/kissing_heart.svg)'
        splited.splice(angelStikerskissing_heart[i], 15, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //yum
    const angelStikersYum = getMatchIndexes(text, ':yum:');
    if (angelStikersYum.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersYum.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/yum.svg)'
        splited.splice(angelStikersYum[i], 5, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //disappointed_relieved
    const angelStikersdisappointed_relieved = getMatchIndexes(text, ':disappointed_relieved:');
    if (angelStikersdisappointed_relieved.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersdisappointed_relieved.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/disappointed_relieved.svg)'
        splited.splice(angelStikersdisappointed_relieved[i], 23, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //weary
    const angelStikersweary = getMatchIndexes(text, ':weary:');
    if (angelStikersweary.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersweary.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/weary.svg)'
        splited.splice(angelStikersweary[i], 7, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //grin
    const angelStikersGrin = getMatchIndexes(text, ':grin:');
    if (angelStikersGrin.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersGrin.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/grin.svg)'
        splited.splice(angelStikersGrin[i], 6, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }


    //laughing
    const angelStikerslaughing = getMatchIndexes(text, ':laughing:');
    if (angelStikerslaughing.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikerslaughing.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/laughing.svg)'
        splited.splice(angelStikerslaughing[i], 10, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //wink
    const angelStikerswink = getMatchIndexes(text, ':wink:');
    if (angelStikerswink.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikerswink.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/wink.svg)'
        splited.splice(angelStikerswink[i], 6, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //sunglasses
    const angelStikerssunglasses = getMatchIndexes(text, ':sunglasses:');
    if (angelStikerssunglasses.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikerssunglasses.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px; background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/sunglasses.svg)'
        splited.splice(angelStikerssunglasses[i], 12, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }


    //neutral_face
    const angelStikersneutral_face = getMatchIndexes(text, ':neutral_face:');
    if (angelStikersneutral_face.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersneutral_face.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/neutral_face.svg)'
        splited.splice(angelStikersneutral_face[i], 14, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //winking_eye
    const angelStikerswinking_eye = getMatchIndexes(text, ':winking_eye:');
    if (angelStikerswinking_eye.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikerswinking_eye.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/winking_eye.svg)'
        splited.splice(angelStikerswinking_eye[i], 13, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //hushed
    const angelStikershushed = getMatchIndexes(text, ':hushed:');
    if (angelStikershushed.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikershushed.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/hushed.svg)'
        splited.splice(angelStikershushed[i], 8, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }
    //thumbsup
    const angelStikersthumbsup = getMatchIndexes(text, ':thumbsup:');
    if (angelStikersthumbsup.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersthumbsup.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/thumbsup.svg)'
        splited.splice(angelStikersthumbsup[i], 10, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //thumbsdown
    const angelStikersthumbsdown = getMatchIndexes(text, ':thumbsdown:');
    if (angelStikersthumbsdown.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersthumbsdown.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/thumbsdown.svg)'
        splited.splice(angelStikersthumbsdown[i], 12, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }

    //Smile
    const angelStikersSmile = getMatchIndexes(text, ':smile:');
    if (angelStikersSmile.length > 0) {
      //Цикл сработает с конца до начала
      for (let i = (angelStikersSmile.length - 1); i > -1; i--) {
        let styleBg = 'display: inline-block; width:18px; height:18px; position:relative; top: 4px; margin-left: 2px; margin-right: 2px;  background-repeat: no-repeat; background-image:url(' + mainUrl + '/skickers/smile.svg)'
        splited.splice(angelStikersSmile[i], 7, '<div style="' + styleBg + '"></div>');
      }
      text = splited.join("");
      splited = text.split('');
    }



    return (<div className="" dangerouslySetInnerHTML={{ __html: splited.join("") }}></div>)
  }
}

