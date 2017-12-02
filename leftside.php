        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $user_name;?></div>
                    <div class="email"><?php echo $email;?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                           
                            <li role="seperator" class="divider"></li>
                            <li><a href="includes/logout.php"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li>
                        <a href="includes/logout.php">
                            <i class="material-icons">power_settings_new</i>
                            <span>Logout</span>
                        </a>
                    </li>
                    <li class="header">MAIN NAVIGATION</li>
                    
                    <li <?php echo in_array("home", $path) ? 'class="active"' : ""; ?>>
                        <a href="./?act=home">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                     <li <?php echo in_array("location", $path) ? 'class="active"' : ""; ?>>
                        <a href="./?act=location/add">
                            <i class="material-icons">home</i>
                            <span>Find POIs by Locality</span>
                        </a>
                    </li>
                    <li <?php echo in_array("location", $path) ? 'class="active"' : ""; ?>>
                        <a href="./?act=locationm/add">
                            <i class="material-icons">home</i>
                            <span>Find POIs near Me</span>
                        </a>
                    </li>
                    
                    
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2017 <a href="javascript:void(0);">RAGA - By Rizwan R Syed</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0 (BETA)
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        