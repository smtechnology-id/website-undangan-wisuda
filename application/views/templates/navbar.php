            <!-- ========== Left Sidebar Start ========== -->
            <div class="leftside-menu">

                <!-- Brand Logo Light -->
                <!-- Sidebar -left -->
                <div class="h-100" id="leftside-menu-container" data-simplebar>
                    <!--- Sidemenu -->
                    <ul class="side-nav">
                        <?php
                        $role_id = $this->session->userdata('role_id');
                        $queryMenu = "
                        SELECT user_menu.id, menu
                        FROM user_menu
                        JOIN user_access_menu
                        ON user_menu.id = user_access_menu.menu_id
                        WHERE user_access_menu.role_id = $role_id
                        ORDER BY user_access_menu.menu_id ASC
                      ";

                        $menu = $this->db->query($queryMenu)->result_array();
                        ?>

                        <?php
                        foreach ($menu as $m) :
                        ?>
                            <li class="side-nav-title"><?php echo $m['menu'] ?></li>
                            <?php
                            $menuId = $m['id'];
                            $querySubMenu = "
                              SELECT *
                              FROM user_sub_menu
                              JOIN user_menu
                                ON user_sub_menu.menu_id = user_menu.id
                              WHERE user_sub_menu.menu_id = $menuId
                                AND user_sub_menu.is_active = 1
                            ";

                            $subMenu = $this->db->query($querySubMenu)->result_array();

                            ?>

                            <?php foreach ($subMenu as $sm) : ?>
                                <li class="side-nav-item">
                                    <a href="<?= base_url($sm['url']) ?>" class="side-nav-link">
                                        <i class="<?= $sm['icon'] ?>"></i>
                                        <span> <?= $sm['title'] ?> </span>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        <?php endforeach; ?>    
                    </ul>
                    <!--- End Sidemenu -->

                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- ========== Left Sidebar End ========== -->