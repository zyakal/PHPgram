<div class="d-flex flex-column align-items-center">
    <div class="size_box_100"></div>
    <div class="w100p_mw614">
        <div class="d-flex flex-row">            
                <div class="d-flex flex-column justify-content-center">
                    <a href="#" id="btnNewUser" data-bs-toggle="modal" data-bs-target="#newUser">
                        <div class="circleimg h150 w150 pointer feedwin">
                            
                            <img src='/static/img/profile/<?=$this->data->iuser?>/<?=$this->data->mainimg?>' onerror='this.error=null;this.src="/static/img/profile/defaultProfileImg.png"'>
                        </div>
                    </a>
                </div>
                <div class="flex-grow-1 d-flex flex-column justify-content-evenly">
                    <div><?=$this->data->email?> 
                        
                        <?php
                        if(!(getIuser()===$this->data->iuser)){
                            if($this->data->youme === 1 && $this->data->meyou === 0){
                                print '<button type="button" id="btnFollow" data-follow="0" class="btn btn-primary">맞팔로우 하기</button>';
                            }
                            else if($this->data->youme === 0 && $this->data->meyou === 0){
                                print '<button type="button" id="btnFollow" data-follow="0" class="btn btn-primary">팔로우</button>';
                            }
                            else { 
                                print '<button type="button" id="btnFollow" data-follow="1" class="btn btn-outline-secondary">팔로우 취소</button>';
                            }
                        } else { print '<button type="button" id="btnModProfile" class="btn btn-outline-secondary">프로필 수정</button>';}

                        ?>
                        
                        

                        
                       
                    </div>
                    <div class="d-flex flex-row">
                        <div class="flex-grow-1">게시물 <span><?=$this->data->feedcnt?></span></div>
                        <div class="flex-grow-1">팔로워 <span><?=$this->data->Follower?></span></div>
                        <div class="flex-grow-1">팔로우 <span><?=$this->data->Follow?></span></div>
                    </div>
                    <div class="bold"><?=$this->data->nm?></div>
                    <div><?=$this->data->cmt?></div>
                    
                </div>
        </div>
    </div>
</div>



<!--Modal -->
<div class="modal fade" id="newUser" tabindex="-1" aria-labelledby="newUserImg" aria-hidden="true">
    <div class="modal-dialog modal_profile_size  modal-dialog-centered">
        <div class="modal-content modal_profile align-content-center justify-content-center" id="newUserContent">
            <div class="h-full">
            <div class="modal-header justify-content-center bold" >프로필 사진 바꾸기</div>            
            <div class="modal-body container-center"  style="color:#0095F6">사진 업로드</div>
            <hr>
            <div class="modal-body container-center" style="color:#ED4956">현재 사진 삭제</div>
            <hr>
            <div class="modal-body container-center" style="color:#262626"><span class="pointer" data-bs-dismiss="modal">취소</span></div>
            </div>
        </div>

        
    </div>
</div>