
<nav class="navbar" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
            <span class="sr-only white">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>

    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li class="<?=$this->activePage == 'about' ? 'active' : ''?>"><a href="/">ABOUT US</a></li>
            <li class="<?=$this->activePage == 'services' ? 'active' : ''?>"><a href="/">SERVICES</a></li>
            <li class="<?=$this->activePage == 'gallery' ? 'active' : ''?>"><a href="/">GALLERY</a></li>
            <li class="<?=$this->activePage == 'contact' ? 'active' : ''?>"><a href="/">CONTACT US</a></li>
        </ul>
    </div>
</nav>