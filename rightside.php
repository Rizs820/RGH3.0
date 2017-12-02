<!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" <?php  echo $rm_theme_color=="theme-red" ? "class='active'" : ""; ?>>
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink" <?php  echo $rm_theme_color=="theme-pink" ? "class='active'" : ""; ?>>
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple" <?php  echo $rm_theme_color=="theme-purple" ? "class='active'" : ""; ?>>
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple" <?php  echo $rm_theme_color=="theme-deep-purple" ? "class='active'" : ""; ?>>
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo" <?php  echo $rm_theme_color=="theme-indigo" ? "class='active'" : ""; ?>>
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue" <?php  echo $rm_theme_color=="theme-blue" ? "class='active'" : ""; ?>>
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue" <?php  echo $rm_theme_color=="theme-light-blue" ? "class='active'" : ""; ?>>
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan" <?php  echo $rm_theme_color=="theme-cyan" ? "class='active'" : ""; ?>>
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal" <?php  echo $rm_theme_color=="theme-teal" ? "class='active'" : ""; ?>>
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green" <?php  echo $rm_theme_color=="theme-green" ? "class='active'" : ""; ?>>
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green" <?php  echo $rm_theme_color=="theme-light-green" ? "class='active'" : ""; ?>>
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime" <?php  echo $rm_theme_color=="theme-lime" ? "class='active'" : ""; ?>>
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow" <?php  echo $rm_theme_color=="theme-yellow" ? "class='active'" : ""; ?>>
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber" <?php  echo $rm_theme_color=="theme-amber" ? "class='active'" : ""; ?>>
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange" <?php  echo $rm_theme_color=="theme-orange" ? "class='active'" : ""; ?>>
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange" <?php  echo $rm_theme_color=="theme-deep-orange" ? "class='active'" : ""; ?>>
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown" <?php  echo $rm_theme_color=="theme-brown" ? "class='active'" : ""; ?>>
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey" <?php  echo $rm_theme_color=="theme-grey" ? "class='active'" : ""; ?>>
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey" <?php  echo $rm_theme_color=="theme-blue-grey" ? "class='active'" : ""; ?>>
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black" <?php  echo $rm_theme_color=="theme-black" ? "class='active'" : ""; ?>>
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
   