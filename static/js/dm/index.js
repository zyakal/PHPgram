(function () {
  function sendMsg(msg) {
    if (ws) {
      ws.send(
        JSON.stringify({
          type: "dm",
          idm: gIdm,
          iuser: loginiuser,
          toiuser: oppoiuser,
          msg: msg,
        })
      );
    }
  }

  let gIdm = 0;
  const gData = document.querySelector("#gData");
  const loginiuser = parseInt(gData.dataset.loginiuser);

  const url = window.location.href;
  const urlObj = new URL(url);

  let oppoiuser = urlObj.searchParams.get("oppoiuser")
    ? parseInt(urlObj.searchParams.get("oppoiuser"))
    : 0;

  const dmUserListContainerElem = document.querySelector(
    ".dm_user_list_container"
  );
  const dmMsgContainerElem = document.querySelector(".dm_msg_container");
  const msgInput = document.querySelector("#msg_input");
  const dmMsgSendBtn = document.querySelector("#button-send");
  const inputIdm = document.querySelector("#inputIdm");

  function setIdm(idm) {
    gIdm = idm;
    inputIdm.value = idm;
  }

  //사용자 리스트 가져오기
  function getDmUserList() {
    fetch("/dm/dmlist")
      .then((res) => res.json())
      .then((res) => {
        makeDmUserList(res);
      });
  }

  function makeDmUserList(userList) {
    let isNonExistent = true;
    userList.forEach(function (item) {
      const div = makeDmUserItem(item);
      dmUserListContainerElem.append(div);

      if (oppoiuser === item.opponent.iuser) {
        isNonExistent = false;
        //방등록 안하게끔 false
        getDmMsgList(item.idm);
        //대화상대 클릭시 대화내용 뿌리기
      }
    });

    if (oppoiuser !== 0 && isNonExistent) {
        //방만들기
      fetch("/dm/reg", {
        method: "POST",
        body: JSON.stringify({
          toiuser: oppoiuser,
        }),
      })
        .then((res) => res.json())
        .then((res) => {
          setIdm(res.idm);
          const div = makeDmUserItem(res);
          dmUserListContainerElem.append(div);
        });
    }
  }
  function makeDmUserItem(item) {
    const div = document.createElement("div");
    div.className = "pointer d-flex flex-row w-full";
    div.innerHTML = `
            <div class="w100">
                <img src="/static/img/profile/${item.opponent.iuser}/${
      item.opponent.mainimg
    }" class="profile w30 h30" 
                 onerror="this.onerror=null; this.src='/static/img/profile/defaultProfileImg.png'">
            </div>
            <div class="flex-grow-1">
                <div>${item.opponent.nm}</div>
                <div>${item.lastmsg == null ? "&nbsp;" : item.lastmsg}</div>
            </div>
        `;
    div.addEventListener("click", function () {
      dmMsgContainerElem.innerHTML = null;
      isFirst = true;
      msgParam.page = 0;
      msgParam.isNoMore = false;
      getDmMsgList(item.idm);
      setIdm(item.idm);
      oppoiuser = item.opponent.iuser;
    });
    return div;
  }
  getDmUserList();

  dmMsgContainerElem.addEventListener("scroll", (e) => {
    if (e.target.scrollTop === 0) {
      getDmMsgList();
    }
  });

  msgInput.addEventListener("keyup", (e) => {
    if (e.key === "Enter") {
      dmMsgSendBtn.click();
    }
  });

  dmMsgSendBtn.addEventListener("click", function () {
    if (gIdm && msgInput.value) {
      sendMsg(msgInput.value);
      msgInput.value = "";
    }
  });

  // 메세지 리스트 가져오기
  const msgParam = {
    isNoMore: false,
    idm: 0,
    page: 0,
    limit: 50,
  };
  let isFirst = true;

  function getDmMsgList(idm) {
    isFirst = false;
    if (msgParam.isNoMore) {
      return;
    }
    if (idm) {
      msgParam.idm = idm;
    }
    msgParam.page++;
    msgParam.isNoMore = true;
    fetch("/dm/msglist" + encodeQueryString(msgParam))
      .then((res) => res.json())
      .then((res) => {
        if (res.length > 0) {
          if (res.length === msgParam.limit) {
            msgParam.isNoMore = false;
          }
          makeDmMsgList(res);
        }
      });
  }

  function makeDmMsgList(msgList) {
    msgList.forEach(function (item) {
      const div = makeDmMsgItem(loginiuser, item);
      dmMsgContainerElem.prepend(div);
    });

    if (isFirst) {
      dmMsgContainerElem.scrollTop = dmMsgContainerElem.scrollHeight;
    } else {
      dmMsgContainerElem.scrollTop = msgList.length * 72;
    }
  }
})();

function makeDmMsgItem(loginiuser, item) {
  //로그인 한 클라이언트와 타 클라이언트를 분류하기 위함
  const div = document.createElement("div");
  div.className = "col-6";

  const inClassName =
    loginiuser === item.iuser ? "alert-warning" : "alert-secondary";

  div.innerHTML = `
        <div class='alert ${inClassName}'>
            <b>${item.msg}</b>
        </div>
    `;
  return div;
}
