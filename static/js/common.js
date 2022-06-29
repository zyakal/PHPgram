function encodeQueryString(params) {
  const keys = Object.keys(params);
  return keys.length
    ? "?" +
        keys
          .map(
            (key) =>
              encodeURIComponent(key) + "=" + encodeURIComponent(params[key])
          )
          .join("&")
    : "";
}

function getDateTimeInfo(dt) {
  const nowDt = new Date();
  const targetDt = new Date(dt);

  const nowDtSec = parseInt(nowDt.getTime() * 0.001);
  const targetDtSec = parseInt(targetDt.getTime() * 0.001);

  const diffSec = nowDtSec - targetDtSec;
  if (diffSec < 120) {
    return "1분 전";
  } else if (diffSec < 3600) {
    //분 단위 (60 * 60)
    return `${parseInt(diffSec / 60)}분 전`;
  } else if (diffSec < 86400) {
    //시간 단위 (60 * 60 * 24)
    return `${parseInt(diffSec / 3600)}시간 전`;
  } else if (diffSec < 2592000) {
    //일 단위 (60 * 60 * 24 * 30)
    return `${parseInt(diffSec / 86400)}일 전`;
  }
  return targetDt.toLocaleString();
}
