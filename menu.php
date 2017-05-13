<?php $rootPath = "/paginaweb/" ?>
<div class="row">

    <div class="large-10 medium-10 small-10 small-centered medium-centered large-centered columns">
        <a href="<?php echo $rootPath; ?>index">
            <img class="float-center" src="<?php echo $rootPath; ?>img/workstation-147953_960_720.png"
                 style="width: 30%; height: 30%;">
        </a>

        <div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
            <button class="menu-icon" type="button" data-toggle="example-menu"></button>
            <div class="title-bar-title">Menu</div>
        </div>

        <ul class="dropdown menu" data-dropdown-menu id="example-menu">
            <li><a href="<?php echo $rootPath; ?>computer_parts">Computer parts</a>
                <ul class="menu vertical">
                    <li><a href="<?php echo $rootPath; ?>motherboards">Motherboards</a></li>
                    <li><a href="<?php echo $rootPath; ?>video_cards">Video cards</a></li>
                    <li><a href="<?php echo $rootPath; ?>processors">Processors</a></li>
                    <li><a href="<?php echo $rootPath; ?>ssds">SSDs</a></li>
                    <li><a href="<?php echo $rootPath; ?>hdds">HDDs</a></li>
                    <li><a href="<?php echo $rootPath; ?>power_supplies">Power supplies</a></li>
                    <li><a href="<?php echo $rootPath; ?>chassis">Chassis</a></li>
                </ul>
            </li>
            <li><a href="<?php echo $rootPath; ?>peripherials">Peripherials</a>
                <ul class="menu vertical">
                    <li><a href="<?php echo $rootPath; ?>monitors">Monitors</a></li>
                    <li><a href="<?php echo $rootPath; ?>mice">Mice</a></li>
                    <li><a href="<?php echo $rootPath; ?>keyboards">Keyboardss</a></li>
                    <li><a href="<?php echo $rootPath; ?>external_hdds">External HDDs</a></li>
                </ul>
            </li>
            <li><a href="<?php echo $rootPath; ?>software">Software</a>
                <ul class="menu vertical">
                    <li><a href="<?php echo $rootPath; ?>operating_system">Operating systems</a></li>
                    <li><a href="<?php echo $rootPath; ?>office_apps">Office applications</a></li>
                    <li><a href="<?php echo $rootPath; ?>security_solutions">Security solutions</a></li>
                </ul>
            </li>
            <li><a href="<?php echo $rootPath; ?>telephones">Telephones</a>
                <ul class="menu vertical">
                    <li><a href="<?php echo $rootPath; ?>smartphones">Smartphones</a></li>
                    <li><a href="<?php echo $rootPath; ?>smartwatches">Smartwatches</a></li>
                    <li><a href="<?php echo $rootPath; ?>external_batteries"> External batteries</a></li>
                    <li><a href="<?php echo $rootPath; ?>gsm_accessories">GSM accesories</a>
                        <ul class="menu vertical">
                            <li><a href="<?php echo $rootPath; ?>gsm_accessories/selfie_sticks">Selfie sticks</a></li>
                            <li><a href="<?php echo $rootPath; ?>gsm_accessories/memory_cards">Memory cards</a></li>
                            <li><a href="<?php echo $rootPath; ?>gsm_accessories/chargers">Chargers</a></li>
                            <li><a href="<?php echo $rootPath; ?>gsm_accessories/wireless_chargers">Wireless
                                    chargers</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="<?php echo $rootPath; ?>audio_photo">Audio Photo/video</a>
                <ul class="menu vertical">
                    <li><a href="<?php echo $rootPath; ?>speakers">Speakers</a>
                        <ul class="menu vertical">
                            <li><a href="<?php echo $rootPath; ?>speakers/portable_speakers">Portable speakers</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo $rootPath; ?>microphones">Microphones</a></li>
                    <li><a href="<?php echo $rootPath; ?>microphones">Cameras</a>
                        <ul class="menu vertical">
                            <li><a href="<?php echo $rootPath; ?>cameras/d_slr">D-SLR Cameras</a></li>
                            <li><a href="<?php echo $rootPath; ?>cameras/compact">Compact Cameras</a></li>
                            <li><a href="<?php echo $rootPath; ?>cameras/bridge">Bridge Cameras</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="<?php echo $rootPath; ?>informations">Informations</a></li>
            <li><a href="<?php echo $rootPath; ?>contact">Contact</a></li>
            <li><a href="<?php echo $rootPath; ?>account">My account</a></li>

            <!-- Show login link if user is not logged in, register link otherwise -->
            <?php if (!isset($_SESSION['userId'])) { ?>
                <li><a href="<?php echo $rootPath; ?>log_in">Log In</a></li>
            <?php } else { ?>
                <li><a href="<?php echo $rootPath; ?>logout">Log out</a></li>
            <?php } ?>
            <li><a href="<?php echo $rootPath; ?>register">Register</a></li>
        </ul>
    </div>
</div>

<script src="<?php echo $rootPath; ?>js/vendor/jquery.js"></script>
<script src="<?php echo $rootPath; ?>js/vendor/foundation.js"></script>
<script>
    $(document).foundation();
    var elem = new Foundation.DropdownMenu(".dropdown");
</script>
