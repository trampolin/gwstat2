<?php
/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 26.08.15
 * Time: 13:16
 */
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">

            <?php foreach ($menu as $item) { ?>
                <li>
                    <a href="<?= $item['href'] ?>"><?php if($item['icon'] != '' && $item['icon'] != null) { ?><i class="fa <?= $item['icon'] ?>"></i><?php } ?> <span class="nav-label"><?= $item['label'] ?></span><?php if(count($item['items']) > 0) { ?> <span class="fa arrow"></span><?php } ?></a>
                    <?php if(count($item['items']) > 0) { ?>
                        <ul class="nav nav-second-level">
                        <?php foreach ($item['items'] as $subItem) { ?>
                        <li>
                            <a href="<?= $subItem['href'] ?>"><?php if($subItem['icon'] != '' && $subItem['icon'] != null) { ?><i class="fa <?= $subItem['icon'] ?>"></i><?php } ?> <span class="nav-label"><?= $subItem['label'] ?></span><?php if(count($subItem['items']) > 0) { ?> <span class="fa arrow"></span><?php } ?></a>
                            <?php if(count($subItem['items']) > 0) { ?>
                            <ul class="nav nav-third-level">
                                <?php foreach ($subItem['items'] as $subSubItem) { ?>
                                <li>
                                    <a href="<?= $subSubItem['href'] ?>"><?php if($subSubItem['icon'] != '' && $subSubItem['icon'] != null) { ?><i class="fa <?= $subSubItem['icon'] ?>"></i><?php } ?> <?= $subSubItem['label'] ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>

            <!--li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="public/img-circle" src="public/img/profile_small.jpg" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li-->



        </ul>

    </div>
</nav>
