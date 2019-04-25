<ul>
	<li class="ec_admin_wizard_item<?php if( $this->step == 1 ){ ?> ec_admin_wizard_current<?php }else if( $this->step > 1 ){ ?> ec_admin_wizard_complete<?php }?>">
    	<div class="nav-label">Page Setup</div><span class="bubble"><span class="dot"></span></span>
    </li>
    <li class="ec_admin_wizard_item<?php if( $this->step == 2 ){ ?> ec_admin_wizard_current<?php }else if( $this->step > 2 ){ ?> ec_admin_wizard_complete<?php }?>">
    	<div class="nav-label">Location</div><span class="bubble"><span class="dot"></span></span>
    </li>
    <li class="ec_admin_wizard_item<?php if( $this->step == 3 ){ ?> ec_admin_wizard_current<?php }else if( $this->step > 3 ){ ?> ec_admin_wizard_complete<?php }?>">
    	<div class="nav-label"> Payments</div><span class="bubble"><span class="dot"></span></span>
    </li>
    <li class="ec_admin_wizard_item<?php if( $this->step == 4 ){ ?> ec_admin_wizard_current<?php }else if( $this->step > 4 ){ ?> ec_admin_wizard_complete<?php }?>">
    	<div class="nav-label"> Shipping</div><span class="bubble"><span class="dot"></span></span>
    </li>
    <li class="ec_admin_wizard_item<?php if( $this->step == 5 ){ ?> ec_admin_wizard_current<?php }?>">
    	<div class="nav-label">Complete!</div><span class="bubble"><span class="dot"></span></span>
    </li>
</ul>