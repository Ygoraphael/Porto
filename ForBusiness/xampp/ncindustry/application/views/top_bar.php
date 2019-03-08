<div class="sticky-header header-section ">
    <div class="header-left">
        <!--toggle button start-->
        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
        <!--toggle button end-->
        <!--logo -->
        <div class="logo">
            <a href="<?php echo base_url(); ?>">
                <h1>PSF</h1>
                <span>AdminPanel</span>
            </a>
        </div>
        <!--//logo-->
        <div class="clearfix"> </div>
    </div>
    <div class="header-right">
        <div class="profile_details">		
            <ul>
                <li class="dropdown profile_details_drop">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <div class="profile_img">	
                            <span class="prfil-img"><img src="<?php echo base_url() ?>images/nouser.png" alt=""> </span> 
                            <div class="user-name">
                                <p><?= $this->session->userdata('userdata')["usercode"] ?></p>
                                <span><?= $this->session->userdata('userdata')["grupo"] ?></span>
                            </div>
                            <div class="clearfix"></div>	
                        </div>	
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"> </div>				
    </div>
    <div class="clearfix"> </div>	
</div>