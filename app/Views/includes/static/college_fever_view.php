<!--important-->
<style type="text/css">
    .bugbountycontainer { font-size:16px;}
    .bugbountycontainer h4{ color: #252525; margin:25px 0 10px 0; font-size: 22px; font-weight: 400;}

    .bugbountycontainer p { font-size:16px;}
    ul.bugbounty { margin-left: 20px; margin-bottom: 20px; float: left; width: 100%; padding:5px 0 5px 10px; }
    ul.bugbounty li{ list-style-type:disc; width: 100%; padding:3px 0; }
    .bounty_heading_1 { }

</style>
<div class="page-container">
<div class="wrap">
  <div class="container newsContainer bugbountycontainer">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
      <p>TheCollegeFever is now part of MeraEvents.com (a subsidiary of EventsNow Pvt. Ltd ). If you are an organiser, you can create your event on www.MeraEvents.com. For any assistance please contact - support@meraevents.com, Mobile - 7032905684</p>
    </div>
    <br />
    <div align="center">
    <?php
      $createEvent = commonHelperGetPageUrl('create-event');
    ?>
      <a href="<?php echo $createEvent; ?>" class="createBtn">Create Event</a>
    </div>
    <br /><br />
  </div>
  <!-- /.wrap --> 
</div>
<!-- /.page-container --> 
<!-- on scroll code-->
<?php  $this->load->view("includes/elements/home_scroll_filter.php"); ?>
                        

<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>
