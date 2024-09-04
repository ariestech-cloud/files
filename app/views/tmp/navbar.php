    <header class="header navbar-fixed-top sticky-top border-bottom border-primary" id="top">
   <nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="#top">Aries<span class="text-primary">Tech</span></a>
    <button class="navbar-toggler text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      &asympeq;
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-circle"></i> <?=$data["user"]["username"];?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?=$this->base_url('Home/Setting');?>"><i class="fas fa-cog"></i> Setting</a></li>
            
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?=$this->base_url('Auth/Logout');?>"><i class="fas fa-sign-out-alt"></i> Sign Out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav> 
</header>
