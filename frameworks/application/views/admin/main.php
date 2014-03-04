<?php echo $header ?><!--Page Header-->

<div id="panel-left">
    <div id="logo">
        <img src="<?php echo base_url('media/image/logo.png') ?>" />
    </div>
    <?php if ($this->session->userdata('u_id') and $this->session->userdata('u_level')) { ?>
        <div id="left-navs">
            <ul>
                <li><a href="<?php echo base_url('admin/home') ?>">Home</a></li>
                <li><a href="<?php echo base_url('admin/myprofile/'.$this->session->userdata('u_id')) ?>">My Profile</a></li>
                <?php if ($this->session->userdata('u_level') == 1) { ?>
                
                <li><a href="<?php echo base_url('admin/manage_accounts') ?>">Manage Accounts</a></li>
                <?php } ?>
                
                <li><a href="<?php echo base_url('research/preview') ?>">Publications</a></li>
                <li><a href="<?php echo base_url('author') ?>">Authors</a></li>
                <li><a href="<?php echo base_url('admin/logout') ?>">Logout</a></li>
            </ul>
        </div>
    <?php } ?>
</div><!--#panel-left-->

<div id="panel-top">

    <div id="user-loggedin">
        <?php if ($this->session->userdata('u_id') and $this->session->userdata('u_level')) { ?>
        <div id="user-name">
            <h2><a href="<?php echo base_url('admin/myprofile/' . $this->session->userdata('u_id')); ?>">
                <?php echo $this->session->userdata('u_name') ?>
            </a></h2>
            <button id="logout">Logout</button> 
        </div>
        <?php } ?>
    </div>
</div>

<div id="panel-content">
    <?php echo $content ?>
</div>

<div style="clear: both"></div>
<?php echo $footer ?><!--Page Footer-->