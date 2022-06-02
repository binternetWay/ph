
<div class="menu__slider">
    <div class="top__container">
        <div class="logo__container">
            <img class="logo__img-white" src="https://www.internetway.com.br/assets/img/whiteLogo.svg" alt="logo com a escrita internet way">
            <span class="logo__name">Streaming</span>
        </div>
    </div>
    <div class="config__user" id="config__user">
        <ul class="config__user--ul">
            <li><a href="#" style="text-decoration: none;"><span class="menu__text"><?php echo $_SESSION['nome_cliente'] ?></span><i class="fa-solid fa-angle-left"></i></a></li>
        </ul>
    </div>
</div>
<div class="menu__user" id="menu__user" style="display: none;">
    <a href="logout" class="line__option"><span>Sair</span><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
</div>


<script>
    var config = document.getElementById('config__user');
    config.onclick = function get() {ativeMenu()};
    
function ativeMenu () {
    var menu = document.getElementById('menu__user');
    if (menu.style.display === 'none'){
        menu.style.display = 'flex';
    }else {
        menu.style.display = 'none'
    }
}
</script>

<style>
.line__option{
    display: flex;
    flex-direction: row;
    align-items: center;
}
.line__option span{
    padding: 5px;
    text-decoration: none;
    color: black;
}
.line__option i{
    padding-right: 5px;
}

.menu__user{
    display: flex;
    flex-direction: column;
    position: absolute;
    background-color: var(--bg1-default);
    border-radius: 10px;

    right: 5px;
    margin-top: 70px;
    padding: 5px;
    z-index: 600;
}

ul ,li{
    width: 90%;
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