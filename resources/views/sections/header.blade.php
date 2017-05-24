<div id="header-background"></div>
<nav class="navbar brb" role="navigation">
    <div class="col-md-2">
        <a href="{{route('home')}}" style="line-height:55px; float:left;"><img src="/img/myLogo4.png"/></a>
    </div>

    <?php
    /*
    <a href="/tr">TR</a>
    <a href="/en">EN</a>

    <input type="radio" value="tr" name="lang-tr" onclick="document.location='/tr'">
    <label for="lang-tr">TR</label>

    <br>

    <input type="radio" value="en" name="lang-en" onclick="document.location='/en'">
    <label for="lang-en">EN</label>
    */
    ?>

    <div id='cssmenu' style="float:right;">
        <ul>
            <!--
            <li class='active' id="tr"><a href='index.html'></a></li>
            <li id="en"><a href='#'></a></li>
            -->
            <?php if(count(config('application.languages')) > 1): ?>
            <li id="lang-settings"><a href="#modalChangeLanguage" onclick="modalOpen()"></a></li>
            <?php endif; ?>
            <li class='last' id="logout"><a href="{{route('common_logout')}}"></a></li>
        </ul>
    </div>
</nav>
