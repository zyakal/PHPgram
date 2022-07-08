const ws = new WebSocket("ws://192.168.0.27:8090/");

(function () {
  const gData = document.querySelector("#gData");
  const totalDmUnreadCntParent = document.querySelector(
    "#totalDmUnreadCntParent"
  );
  const totalDmUnreadCnt = document.querySelector("#totalDmUnreadCnt");

  if (gData && gData.dataset.loginiuser) {
    const loginiuser = parseInt(gData.dataset.loginiuser);

    ws.onopen = function (e) {
      console.log("ws open!!");
      ws.send(
        JSON.stringify({
          type: "conn",
          iuser: loginiuser,
        })
      );
    };

    ws.onerror = function (e) {
      console.log(e);
    };
    ws.onmessage = function (e) {
      var json = JSON.parse(e.data);
      // 현재 json은 자바스크립트 객체
      console.log(json);

      switch (json.type) {
        case "dm":
          const inputIdm = document.querySelector("#inputIdm");
          if (inputIdm) {
            //현재 페이지가 dm페이지라면
            if (parseInt(inputIdm.value) === json.idm) {
              //현재 페이지가 dm페이지면서 해당 사람과 대화중이라면
              const div = makeDmMsgItem(loginiuser, json);
              const dmMsgContainerElem =
                document.querySelector(".dm_msg_container");
              dmMsgContainerElem.append(div);
              dmMsgContainerElem.scrollTop = dmMsgContainerElem.scrollHeight;
            } else {
              //현재 활성화된 대화상대 외의 사람이 나에게 메시지를 보냈을때
            }
          } else {
            //현재 페이지가 dm페이지가 아니라면, header에 있는 dm아이콘 작업
            if (loginiuser !== json.toiuser) {
              return;
            }

            const cnt = parseInt(totalDmUnreadCnt.innerText);
            totalDmUnreadCnt.innerText = cnt + 1;
            totalDmUnreadCntParent.classList.remove("d-none");
          }
          break;
      }
    };
  }
})();
