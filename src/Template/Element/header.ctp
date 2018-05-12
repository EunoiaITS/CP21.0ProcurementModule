<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-sm-7 col-md-5 col-lg-5 col-xs-12">
                <div class="icon-menu">
                    <div id="sidebar-btn">
                        <button type="button" class="btn btn-link btn-sm" id="button-swip"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                    </div>
                    <p class="menu-i">menu</p>
                </div>
                <div class="home-icon">
                    <h2><a href="#">Indkom Sdn Bhd.</a><h2>
                </div>
            </div>
            <div class="col-sm-5 col-md-6 col-md-offset-1 col-sm-offset-0 col-lg-offset-2 col-lg-5 col-xs-12">
                <div class="print-icon-right">
                    <ul>
                        <li><a href="#"><i class="fa fa-arrow-circle-left fa-2x"></i></a></li>
                        <li><a href="#"><i class="fa fa-arrow-circle-right fa-2x"></i></a></li>
                        <li><a href="#"><img class="img-icon" src="<?php echo $this->request->webroot.'assets/img/search.png'; ?>" alt=""></a></li>
                        <li><a href="#"><i class="fa fa-pencil-square-o fa-2x"></i></a></li>
                        <li><a href="#"><img class="img-icon" src="<?php echo $this->request->webroot.'assets/img/file-1.png'; ?>" alt=""></a></li>
                        <li><a href="#"><img class="img-icon" src="<?php echo $this->request->webroot.'assets/img/file-2.png'; ?>" alt=""></a></li>
                        <li><a href="#" onclick="jQuery.print('#ele3')"><i class="fa fa-print fa-2x"></i></a></li>
                        <li><a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'logout']); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>