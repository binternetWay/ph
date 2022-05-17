
<div class="menu__slider">
    <div class="top__container">
        <div class="logo__container">
            <img class="logo__img-white" src="https://www.internetway.com.br/assets/img/whiteLogo.svg" alt="logo com a escrita internet way">
            <span class="logo__name">Streaming</span>
        </div>
    </div>
    <div class="config__user">
        <ul class="config__user--ul">
            <li><span class="menu__text">Daniel</span><i class="fa-solid fa-angle-left"></i></li>
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
.config__user--ul li{
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 1px 10px;
    border-radius: 10px;
    background-color: var(--bg-type2);
    transition: 0.3s;
}

.config__user--ul li:hover {
    transform: scale(1.1);
    transition: 0.3s;
}
.config__user--ul li:hover i{
    transform: rotate(-90deg);
    transition: 0.6s;
}

.config__user--ul li i{
    color: var(--bg1-default);
    margin: 0px 0px 0px 10px;
    transition: 0.6s;
}
.menu__text{
    font-weight: 400;
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