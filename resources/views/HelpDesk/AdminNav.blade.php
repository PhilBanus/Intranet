<?php $r = \Route::getCurrentRoute()->uri();?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark ICTONLY">
    <div class="navbar-brand" href="#">Admin View 
</div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if($r === "HelpDesk"){ echo "active"; } ?>">
               <a class="nav-link waves-effect waves-light" href="MyHelpDesk">My Requests</a>
            </li>
			<li class="nav-item <?php if($r === "MyAssets"){ echo "active"; } ?>">
               <a class="nav-link waves-effect waves-light" href="MyAssets">My Assets</a>
            </li>
            <li class="nav-item <?php if($r === "MyOpenUnassigned"){ echo "active"; } ?>">
                <a class="nav-link waves-effect waves-light" href="MyOpenUnassigned">Open or Unassigned</a>
            </li>
            <li class="nav-item <?php if($r === "OtherOpen"){ echo "active"; } ?>">
                <a class="nav-link waves-effect waves-light" href="OtherOpen">Other Open</a>
            </li>
       
        </ul>
        <form class="form-inline">
            <div class="md-form my-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            </div>
        </form>
    </div>
</nav>