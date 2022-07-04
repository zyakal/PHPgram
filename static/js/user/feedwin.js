const url = new URL(location.href);

function getFeedList() {
  if (!feedObj) {
    return;
  }

  feedObj.showLoading();
  const param = {
    page: feedObj.currentPage++,
    iuser: url.searchParams.get("iuser"),
  };
  fetch("/user/feed" + encodeQueryString(param))
    .then((res) => res.json())
    .then((list) => {
      feedObj.makeFeedList(list);
    })
    .catch((e) => {
      console.error(e);
      feedObj.hideLoading();
    });
}
getFeedList();

(function () {
  const btnFollow = document.querySelector("#btnFollow");
  if (btnFollow) {
    btnFollow.addEventListener("click", () => {
      const param = {
        toiuser: gData.dataset.toiuser,
      };
      console.log(param);
      const follow = btnFollow.dataset.follow;
      const followUrl = "/user/follow";
      console.log("follow :" + follow);
      console.log(followUrl);
      console.log(encodeQueryString(param));
      switch (follow) {
        case "1": //팔로우취소
          fetch(followUrl + encodeQueryString(param), { method: "DELETE" })
            .then((res) => res.json())
            .then((res) => {
              console.log("res : " + res);
              if (res.result) {
                btnFollow.dataset.follow = "0";
                btnFollow.classList.remove("btn-outline-secondary");
                btnFollow.classList.add("btn-primary");
                if (btnFollow.dataset.youme === "1") {
                  btnFollow.innerText = "맞팔로우 하기";
                } else {
                  btnFollow.innerText = "팔로우";
                }
              }
            });
          break;
        case "0": //팔로우 등록
          fetch(followUrl, { method: "POST", body: JSON.stringify(param) })
            .then((res) => res.json())
            .then((res) => {
              console.log("res : " + res);
              if (res.result) {
                btnFollow.dataset.follow = "1";
                btnFollow.classList.remove("btn-primary");
                btnFollow.classList.add("btn-outline-secondary");
                btnFollow.innerText = "팔로우 취소";
              }
            });
          break;
      }
    });
  }
})();
