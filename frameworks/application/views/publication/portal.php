<div id="portal">
<!--     <div id="img-links">
        <div class="img">
            <a href="<?php echo base_url('admin/myprofile/'.$this->session->userdata('u_id')) ?>">
            <img src="<?php echo base_url('/media/image/home/myprofile.png') ?>" alt="My Profile"/>
            <div class="desc">My Profile</div>
            </a>
        </div>
        <div class="img">
            <?php if ($this->session->userdata('u_level') == 1) 
                        $url = base_url('admin/manage_accounts');  
                  else 
                        $url = ""; 
            ?>
            <a href="<?php echo $url ?>">
            <img src="<?php echo base_url('/media/image/home/account.png') ?>" alt="User Accounts"/>
            <div class="desc">User Accounts</div>
            </a>
        </div>
        <div class="img">
            <a href="<?php echo base_url('author') ?>">
            <img src="<?php echo base_url('/media/image/home/author.png') ?>" alt="Authors" />
            <div class="desc">Authors</div>
            </a>
        </div>
        <div class="img">
            <a href="<?php echo base_url('research/preview') ?>">
            <img src="<?php echo base_url('/media/image/home/publications.png') ?>" alt="Publications"/>
             <div class="desc">Publications</div>
            </a>
        </div>
    </div> -->
    
<!--     <div id="gen-search">
        <input type="text" name="gs-item" class="text ui-corner-all ui-widget-content" />
        <select name="gs-category">
            <option value="1">Research Title</option>
            <option value="2">Author</option>
            <option value="3">User Account</option>
        </select>
        <button>Search</button>
    </div>
    
    <div id="gen-search-results">
        <div id="gsr-result-box">
            <table id="gsr-result">
            </table>
        </div>
    </div> -->

    <table id="home-records"></table>
    <div id="hr-pager"></div>
</div>