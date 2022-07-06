const url = new URL(location.href);

if (feedObj) {
  const url = new URL(location.href);
  feedObj.iuser = parseInt(url.searchParams.get("iuser"));
  feedObj.getFeedUrl = "/user/feed";
  feedObj.setScrollInfinity();
  feedObj.getFeedList();
}

// function getFeedList() {
//   if (!feedObj) {
//     return;
//   }

//   feedObj.showLoading();
//   const param = {
//     page: feedObj.currentPage++,
//     iuser: url.searchParams.get("iuser"),
//   };
//   fetch("/user/feed" + encodeQueryString(param))
//     .then((res) => res.json())
//     .then((list) => {
//       feedObj.makeFeedList(list);
//     })
//     .catch((e) => {
//       console.error(e);
//       feedObj.hideLoading();
//     });
// }
// getFeedList();

(function () {
  const lData = document.querySelector("#lData");
  const btnFollow = document.querySelector("#btnFollow");
  const btnDelCurrentProfilePic = document.querySelector(
    "#btnDelCurrentProfilePic"
  );
  const btnProfileImgModalClose = document.querySelector(
    "#btnProfileImgModalClose"
  );
  if (btnFollow) {
    btnFollow.addEventListener("click", () => {
      const param = {
        toiuser: lData.dataset.toiuser,
      };
      const follow = btnFollow.dataset.follow;
      const follower_sel = document.querySelector(".follower");
      const follower = ~~follower_sel.innerText;

      const followUrl = "/user/follow";

      switch (follow) {
        case "1": //팔로우취소
          fetch(followUrl + encodeQueryString(param), { method: "DELETE" })
            .then((res) => res.json())
            .then((res) => {
              if (res.result) {
                btnFollow.dataset.follow = "0";
                follower_sel.innerText = follower - 1;
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
                follower_sel.innerText = follower + 1;
                btnFollow.classList.remove("btn-primary");
                btnFollow.classList.add("btn-outline-secondary");
                btnFollow.innerText = "팔로우 취소";
              }
            });
          break;
      }
    });
  }
  if (btnDelCurrentProfilePic) {
    btnDelCurrentProfilePic.addEventListener("click", (e) => {
      fetch("/user/profile", { method: "DELETE" })
        .then((res) => res.json())
        .then((res) => {
          if (res.result) {
            const profileImgList = document.querySelectorAll(".profileimg");
            profileImgList.forEach((item) => {
              item.src = "/static/img/profile/defaultProfileImg.png";
            });
          }
          btnProfileImgModalClose.click();
        });
    });
  }
})();
