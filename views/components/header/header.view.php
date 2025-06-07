<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="<?= url('') ?>" class="logo">
                        <img src="assets/images/logo.png" alt="">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Search End ***** -->
                    <div class="search-input">
                      <form id="search" action="#">
                        <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" onkeypress="handle" />
                        <i class="fa fa-search"></i>
                      </form>
                    </div>
                    <!-- ***** Search End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="<?= url('') ?>" class="<?= is_url()? 'active' : ''?>">Home</a></li>
                        <li><a href="<?= url('browse') ?>" class="<?= is_url('browse')? 'active' : ''?>">Browse</a></li>
                        <li><a href="<?= url('details') ?>" class="<?= is_url('details')? 'active' : ''?>">Details</a></li>
                        <li><a href="<?= url('streams') ?>" class="<?= is_url('streams')? 'active' : ''?>">Streams</a></li>
                        <li><a href="<?= url('profile') ?>" class="<?= is_url('profile')? 'active' : ''?>">Profile <img src="assets/images/profile-header.jpg" alt=""></a></li>
                    </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>