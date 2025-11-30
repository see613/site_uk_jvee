
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
            <li class="<?=$this->activePage == 'about' ? 'active' : ''?>"><a href="/about">ABOUT US</a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">SERVICES</a>

                <ul class="dropdown-menu">
                    <li class="<?=$this->activePage == 'domestic-services' ? 'active' : ''?>">
                        <a href="/domestic-services">Domestic Electrical Services</a>
                    </li>
                    <li class="<?=$this->activePage == 'commercial-services' ? 'active' : ''?>">
                        <a href="/commercial-services">Commercial Electrical Services</a>
                    </li>
                </ul>
            </li>

            <li class="<?=$this->activePage == 'gallery' ? 'active' : ''?>"><a href="/gallery">GALLERY</a></li>
            <li class="<?=$this->activePage == 'contact' ? 'active' : ''?>"><a href="/contact">CONTACT US</a></li>
        </ul>
    </div>
</nav>