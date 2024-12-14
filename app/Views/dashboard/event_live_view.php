<input type="hidden" name="meeting_number" id="meeting_number" value="<?php echo $eventMeetingId; ?>"/>
<input type="hidden" name="display_name" id="display_name" value="<?php echo $eventMeetingDisplayName; ?>"/>
<input type="hidden" name="meeting_pwd" id="meeting_pwd" value="<?php echo $eventMeetingPassword; ?>"/>
<input type="hidden" name="meeting_role" id="meeting_role" value="<?php echo $eventMeetingRole; ?>"/>
<button type="button" class="btn btn-primary" id="join_meeting" style="display: none;">Join</button>
<script>
    var site_url = '<?php echo site_url(); ?>';
</script>
<link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.7/css/bootstrap.css"/>
<link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.7/css/react-select.css"/>
<script src="https://source.zoom.us/1.7.7/lib/vendor/react.min.js"></script>
<script src="https://source.zoom.us/1.7.7/lib/vendor/react-dom.min.js"></script>
<script src="https://source.zoom.us/1.7.7/lib/vendor/redux.min.js"></script>
<script src="https://source.zoom.us/1.7.7/lib/vendor/redux-thunk.min.js"></script>
<script src="https://source.zoom.us/1.7.7/lib/vendor/jquery.min.js"></script>
<script src="https://source.zoom.us/1.7.7/lib/vendor/lodash.min.js"></script>
<script src="https://source.zoom.us/zoom-meeting-1.7.7.min.js"></script>
<script src="<?php echo $this->config->item('js_public_path') . 'zoom/index.js'; ?>"></script>
<style>
    .meeting-client-inner {
        top: 80px;
        height: calc(100% - 80px);
    }
    .headerSec {
        height: 80px;
        background: #FFF;
        width: 100%;
        position: fixed;
        z-index: 10;
        top: 0px;
        -webkit-box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.2);
        box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.2);
    }
    .float-left {
        float: left;
    }
    #mobile-menu-toggle {
        position: absolute;
        left: 20px;
        top: 30px;
        color: #5f259f;
    }
    @media only screen and (min-width: 1001px) {
        #mobile-menu-toggle {
            display: none;
        }
    }
    @media only screen and (max-width: 600px) {
        #mobile-menu-toggle {
            left: 10px;
            top: 18px;
        }
    }
    .logo {
        margin-left: 20px;
        padding-top: 8px;
        float: left;
        max-width: 180px;
    }
    .float-right {
        float: right;
    }
    .rightList {
        width: auto;
        margin-right: 20px;
    }
    .rightList li {
        list-style-type: none;
        display: inline-block;
        float: left;
        line-height: 80px;
        margin-left: 20px;
    }
    .rightList .createBtn {
        background-color: #FDDA24!important;
        border-radius: 5px;
        -moz-background-clip: padding;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        margin-left: 4px;
        margin-top: 13px;
        padding: 7px 10px!important;
        font-size: 13px;
        text-transform: uppercase;
        color: black !important;
    }
    .createBtn, .saveBtn, .detailBtn, .fs-btn {
        padding: 5px 15px;
        text-transform: capitalize;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -moz-background-clip: padding;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        cursor: pointer;
        display: inline-block;
        border: 0;
        color: white;
        line-height: 28px !important;
        outline: none;
        font-family: 'Lato', sans-serif;
    }
    .headerSec ul {
        overflow: hidden;
    }
    .helpdropdown-menu {
        position: absolute;
        top: 99%;
        /* right: 85px; */
        right: 230px;
        z-index: 1000;
        padding: 10px;
        margin: 2px 0 0;
        font-size: 14px;
        text-align: left;
        list-style: none;
        background-color: #fff;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.15);
        /* border-radius: 4px; */
        -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    }
    .none {
        display: none;
    }
    .rightList li a {
        color: #333;
        font-size: 13px;
    }
    .fs-usermenu > a {
        display: block;
        width: 50px;
        height: 80px;
        background-image: url(/images/static/profile-icon-50.png);
        background-repeat: no-repeat;
        background-position: left center;
    }
    .db-usermenu {
        position: absolute;
        top: 99%;
        right: 15px;
        z-index: 1000;
        width: 170px;
        padding: 5px 0;
        margin: 2px 0 0;
        font-size: 14px;
        text-align: left;
        list-style: none;
        background-color: #fff;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.15);
        /* border-radius: 4px; */
        -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    }
    .fs-usermenu .db-usermenu > li {
        margin-left: 10px !important;
    }
    .db-usermenu li {
        height: 40px;
    }
    .db-usermenu > li {
        /* display: block; */
        float: left;
    }
    .db-usermenu li {
        list-style: none;
        display: block;
    }
    .db-usermenu > li > a {
        display: block;
        padding: 3px;
        clear: both;
        font-weight: normal;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
    }
    .db-usermenu li span {
        margin-right: 10px;
        font-weight: normal;
        font-size: 18px;
        float: left;
    }
    .db-usermenu hr {
        border: 0;
        border-top: 1px solid #eee;
        clear: both;
        width: 100%;
    }
    hr {
        margin: 10px 0 20px 0;
        border: 0;
        background-color: #ccc;
        height: 1px;
        width: 100%;
    }
    .rightList li {
        list-style-type: none;
        display: inline-block;
        float: left;
        line-height: 80px;
        margin-left: 20px;
    }
    .rightList .icon-downarrow {
        margin-top: 32px;
        margin-left: 5px;
    }
    .accessibility {
        position: absolute;
        left: -9999px;
    }
    .helpdropdown-menu {
        position: absolute;
        top: 99%;
        /* right: 85px; */
        right: 230px;
        z-index: 1000;
        padding: 10px;
        margin: 2px 0 0;
        font-size: 14px;
        text-align: left;
        list-style: none;
        background-color: #fff;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.15);
        /* border-radius: 4px; */
        -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    }
    .rightList .fs-header-help ul a {
        font-size: 13px;
    }
    .rightList .fs-header-help a {
        font-size: 16px;
        position: relative;
        top: 3px;
    }
    #helpdropdown-menu li {
        margin-left: 0;
    }
    .helpdropdown-menu li {
        line-height: 40px;
        float: none;
    }
    .helpdropdown-menu li {
        list-style: none;
        display: block;
    }
    .rightList .fs-header-help ul a {
        font-size: 13px;
    }
    .rightList .fs-header-help a {
        font-size: 16px;
        position: relative;
        top: 3px;
    }
</style>
<script>
    $(function () {
        $("#join_meeting").trigger('click');
    });
    function getProfileLink(pageCall) {
        if ($('.profile-dropdown').text().trim() != '') {
            return true;
        }
        $('.profile-dropdown').html('<br>' + $('#menudvLoading').html());
        if ((pageCall == 'event_header' && !$('.afterlogindiv').hasClass('active')) ||
                (pageCall == 'header' && !$('.dropdown').hasClass('open'))) {
            $.ajax({
                type: 'GET',
                async: true,
                url: '<?php echo commonHelperGetPageUrl('api_getProfileDropdown') ?>',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Authorization': 'bearer 930332c8a6bf5f0850bd49c1627ced2092631250'
                },
                success: function (response) {
                    $('.profile-dropdown').html(response);
                }
            });
        } else {
            $('.profile-dropdown').empty();
        }
    }
    $('#user-toggle').click(function (event) {
        event.stopPropagation();
        $("#helpdropdown-menu").hide();
        $('#dropdown-menu').toggle();
    });
    $("#help-toggle").click(function (event) {
        event.stopPropagation();
        $('#dropdown-menu').hide();
        $("#helpdropdown-menu").toggle();
    });
</script>