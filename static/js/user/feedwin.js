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

// ------------------개인 프로필 사진 업로드 ------------------------
(function () {
  const btnNewUserImg = document.querySelector("#btnNewUserImg");
  const modal = document.querySelector("#newUserImg");
  const frmElem = modal.querySelector("form");
  const body = modal.querySelector("#id-modal-body");
  if (btnNewUserImg) {
    btnNewUserImg.addEventListener("click", function () {
      const selFromComBtn = document.createElement("button");
      selFromComBtn.type = "button";
      selFromComBtn.className = "btn btn-primary";
      selFromComBtn.innerText = "컴퓨터에서 선택";
      selFromComBtn.addEventListener("click", function () {
        frmElem.imgs.click();
      });
      body.innerHTML = null;
      body.appendChild(selFromComBtn);
    });
  }

  //이미지 값이 변하면
  frmElem.imgs.addEventListener("change", function (e) {
    if (e.target.files.length > 0) {
      body.innerHTML = `      
                <div>
                    <div class="d-flex flex-md-row">
                        <div class="flex-grow-1 h-full"><img id="id-img" class="w300"></div>                        
                    </div>
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-primary">사진 업로드</button>
                </div>
            `;

      const profileImgList = document.querySelectorAll(".profileimg");
      const imgElem = body.querySelector("#id-img");

      const imgSource = e.target.files[0];
      const reader = new FileReader();

      reader.readAsDataURL(imgSource);
      reader.onload = function () {
        imgElem.src = reader.result;
      };

      const btnInsProfilePic = modal.querySelector("button");

      if (btnInsProfilePic) {
        btnInsProfilePic.addEventListener("click", (e) => {
          const btnClose = document.querySelector("#profile-btn-close");
          const fData = new FormData();
          fData.append("imgs", imgSource);
          fetch("/user/profile", {
            method: "post",
            body: fData,
          })
            .then((res) => res.json())
            .then((res) => {
              profileImgList.forEach((item) => {
                item.src = reader.result;
              });
              btnClose.click();
            });
        });
      }
    }
  });
})();
