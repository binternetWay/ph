
<div class="menu__slider">
    <div class="top__container">
        <div class="logo__container">
            <img class="logo__img-white" src="https://www.internetway.com.br/assets/img/whiteLogo.svg" alt="logo com a escrita internet way">
            <span class="logo__name">Streaming</span>
        </div>
    </div>
    <div class="config__user">
        <ul class="config__user--ul">
            <li><a href="#"><i class="fa-solid fa-question"></i><span class="menu__text"></span></a></li>
            <li><a href="assets/controller/logout.php"><i class="fa-solid fa-person-running"></i><span class="menu__text"></span></a></li>
        </ul>
    </div>
</div>

<style>
ul ,li{
    width: 100%;
    list-style: none;
    margin: 0;
    padding: 0;
}

.menu__slider{
    top: 0;
    display: flex;
    align-items: center;
    flex-direction: row;
    justify-content: space-between;

    position: absolute;
    height: 70px;
    width: 100%;

    background: linear-gradient(180deg, rgba(0,24,57,1) 15%, rgba(241,241,241,0) 100%);
    z-index: 210;
}

.top__container{
    display: flex;
    align-items: center;
    flex-direction: column;
}

.logo__container{
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 0px;
    width: 35%;
}
.logo__container img{
    height: 40px;
    padding: 0px 10px;
    border-right: 2px solid;
    border-color: var(--bg-type2);
}
.logo__container span{
    color: var(--bg-type2);
    text-transform: uppercase;
    font-size: 13px;
    font-weight: 900;
    padding: 0px 10px;
}

.config__user--ul{
    display: flex;
    align-items: center;
    flex-direction: row;
}

.config__user--ul li a{
    padding: 0px 10px;
    color: var(--bg1-default);
}
.config__user--ul li a i{
    font-size: 20px;
}
</style>