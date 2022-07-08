<div class="header">
    <header class="container py-3">
        <div id="globalConst">
            <div class="d-flex flex-row align-items-center">
                <div class="d-inline-flex flex-grow-1 flex-shrink-0">
                    <a href="/feed/index">
                        <img src="/static/svg/logo.svg">
                    </a>
                </div>

                <div class="d-inline-flex flex-grow-1 flex-shrink-1">
                </div>

                <div class="d-inline-flex flex-grow-1 flex-shrink-0">
                    <nav class="d-flex flex-grow-1 flex-row justify-content-end">
                        <div class="d-inline-flex me-3">
                            <a href="#" id="btnNewFeedModal" data-bs-toggle="modal" data-bs-target="#newFeedModal">
                                <svg aria-label="새로운 게시물" class="_8-yf5 " color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 24 24" width="24"><path d="M2 12v3.45c0 2.849.698 4.005 1.606 4.944.94.909 2.098 1.608 4.946 1.608h6.896c2.848 0 4.006-.7 4.946-1.608C21.302 19.455 22 18.3 22 15.45V8.552c0-2.849-.698-4.006-1.606-4.945C19.454 2.7 18.296 2 15.448 2H8.552c-2.848 0-4.006.699-4.946 1.607C2.698 4.547 2 5.703 2 8.552z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="6.545" x2="17.455" y1="12.001" y2="12.001"></line><line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12.003" x2="12.003" y1="6.545" y2="17.455"></line></svg>                           
                            </a>
                        </div>
                        <div class="d-inline-flex me-3">
                            <span class="position-relative">                                
                                <svg id="dmIcon" aria-label="다이렉트 메시지" class="_8-yf5 pointer" color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 24 24" width="24"><line fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2" x1="22" x2="9.218" y1="3" y2="10.083"></line><polygon fill="none" points="11.698 20.334 22 3.001 2 3.001 9.218 10.084 11.698 20.334" stroke="currentColor" stroke-linejoin="round" stroke-width="2"></polygon></svg>                                
                                <span id="totalDmUnreadCntParent" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                                    <span id="totalDmUnreadCnt">0</span>
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </span>
                        </div>                    
                        <div class="d-inline-flex dropdown">
                            <a href="#" role="button" id="navDropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" class="header_profile">
                                <div class="circleimg h30 w30">
                                    <img class="profileimg" src="/static/img/profile/<?=getMainImgSrc()?>" onerror="this.onerror=null;this.src='/static/img/profile/defaultProfileImg.png'">
                                </div>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navDropdownMenuLink">
                                <li>
                                    <a class="dropdown-item" href="/user/feedwin?iuser=<?=getIuser()?>">
                                        <span><svg aria-label="프로필" class="_8-yf5 " color="#262626" fill="#262626" height="16" role="img" viewBox="0 0 24 24" width="16"><circle cx="12.004" cy="12.004" fill="none" r="10.5" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></circle><path d="M18.793 20.014a6.08 6.08 0 00-1.778-2.447 3.991 3.991 0 00-2.386-.791H9.38a3.994 3.994 0 00-2.386.791 6.09 6.09 0 00-1.779 2.447" fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></path><circle cx="12.006" cy="9.718" fill="none" r="4.109" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></circle></svg></span></span>
                                        <span>프로필</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/user/logout">로그아웃</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</div>
<!-- New Feed Create Modal -->
<div class="modal fade" id="newFeedModal" tabindex="-1" aria-labelledby="newFeedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" id="newFeedModalContent">
            <div class="modal-header">
                <h5 class="modal-title" id="newFeedModalLabel">새 게시물 만들기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="id-modal-body"></div>
        </div>

        <form class="d-none">
            <input type="file" accept="image/*" name="imgs" multiple>
        </form>
    </div>
</div>