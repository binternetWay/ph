
<div class="menu__slider">
    <div class="top__container">
        <div class="logo__container">
            <img class="logo__img-white" src="https://www.internetway.com.br/assets/img/whiteLogo.svg" alt="logo com a escrita internet way">
            <span class="logo__name">Streaming</span>
        </div>
    </div>
    <div class="config__user">
        <ul class="config__user--ul">
            <li><span class="menu__text">V</span></li>
        </ul>
    </div>
</div>

<style>
ul ,li{
    width: 80%;
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

    background: linear-gradient(167deg, rgba(0,24,57,1) 11%, rgb(255 246 255 / 0%) 39%);
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

    margin: 0px 10px;
    cursor: pointer;
}
.menu__text{
    padding: 11px 17px;
    border-radius: 50%;
    font-weight: 800;

    background-color: var(--bg-type2);
    color: var(--bg1-default);
}

@media only screen and (max-width: 930px) {
    .menu__slider{
        background: linear-gradient(167deg, rgba(0,24,57,1) 11%, rgb(255 246 255 / 0%) 70%);
    }
}

@media only screen and (max-width: 430px) {
    .menu__slider{
        background: linear-gradient(167deg, rgba(0,24,57,1) 11%, rgb(255 246 255 / 0%) 70%);
    }
}

@media only screen and (max-width: 380px) {
    .menu__slider{
        background: linear-gradient(167deg, rgba(0,24,57,1) 11%, rgb(255 246 255 / 0%) 70%);
    }
}
</style>