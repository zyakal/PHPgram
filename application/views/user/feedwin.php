<div id="lData" data-toiuser="<?=$this->data->iuser?>"></div>
<div class="d-flex flex-column align-items-center">
    <div class="size_box_100"></div>
    <div class="w100p_mw614">
        <div class="d-flex flex-row">            
                <div class="d-flex flex-column justify-content-center">
                    <a href="#" id="btnNewUser" data-bs-toggle="modal" data-bs-target="#newUser">
                        <div class="circleimg h150 w150 pointer feedwin">
                            
                            <img class='profileimg' src='/static/img/profile/<?=$this->data->iuser?>/<?=$this->data->mainimg?>' onerror='this.error=null;this.src="/static/img/profile/defaultProfileImg.png"'>
                        </div>
                    </a>
                </div>
                <div class="flex-grow-1 d-flex flex-column justify-content-evenly">
                    <div><?=$this->data->email?> 
                        
                    <?php
                        if($this->data->iuser === getIuser()) {
                            echo '<button type="button" id="btnModProfile" class="btn btn-outline-secondary">프로필 수정</button>';
                        } else {                            
                            $data_follow = 0;
                            $cls = "btn-primary";
                            $txt = "팔로우";

                            if($this->data->meyou === 1) {
                                $data_follow = 1;
                                $cls = "btn-outline-secondary";
                                $txt = "팔로우 취소";
                            } else if($this->data->youme === 1 && $this->data->meyou === 0) {
                                $txt = "맞팔로우 하기";
                            }
                            echo "<button type='button' id='btnFollow' data-youme='{$this->data->youme}' data-follow='{$data_follow}' class='btn {$cls}'>{$txt}</button>";
                        }
                    ?>
                        
                        

                        
                       
                    </div>
                    <div class="d-flex flex-row">
                        <div class="flex-grow-1">게시물 <span><?=$this->data->feedcnt?></span></div>
                        <div class="flex-grow-1">팔로워 <span class="follower"><?=$this->data->Follower?></span></div>
                        <div class="flex-grow-1">팔로우 <span class="follow"><?=$this->data->Follow?></span></div>
                    </div>
                    <div class="bold"><?=$this->data->nm?></div>
                    <div><?=$this->data->cmt?></div>
                    
                </div>
        </div>
        <div id="item_container" class="w614"></div>
    </div>
    <div class="loading d-none"><img src="/static/img/loading.gif"></div>
</div>



<!--Modal -->
<div class="modal fade" id="newUser" tabindex="-1" aria-labelledby="newUserImg" aria-hidden="true">
    <div class="modal-dialog modal_profile_size  modal-dialog-centered">
        <div class="modal-content modal_profile align-content-center justify-content-center" id="newUserContent">
            <div class="h-full">
            <div class="modal-header justify-content-center bold" >프로필 사진 바꾸기</div>            
            <div class="modal-body container-center pointer"  style="color:#0095F6">사진 업로드</div>
            <hr>
            <?php if(isset($this->data->mainimg)){ ?>
            <div id = "btnDelCurrentProfilePic" class="modal-body container-center pointer" style="color:#ED4956">현재 사진 삭제</div>
            <?php } ?>
            <hr>
            <div class="modal-body container-center" style="color:#262626"><span  id="btnProfileImgModalClose" class="pointer" data-bs-dismiss="modal">취소</span></div>
            </div>
        </div>

        
    </div>
</div>