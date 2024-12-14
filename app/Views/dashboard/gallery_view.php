<div class="rightArea">
    <div class="heading">
        <h2>Add Gallery: <span><?php echo $eventName; ?></span></h2>
    </div>
    <div id="previewSec">
        <div class="grid-row padding20">
            <div class="grid-lg-8 grid-md-12 grid-sm-12 nopadding">
                <div class="fs-form fs-form-widget-setting boxshadow">
                    <?php if (isset($galleryImages) && $galleryImages['status'] && $galleryImages['response']['total'] <= 15) { ?>
                        <h2 class="fs-box-title">Gallery</h2>
                        <div class="fs-form fs-form-widget-setting">
                            <div class="ticketFields fs-form-content">
                                <p>Upload only jpg/jpeg/png format files (maximum file size 2MB)</p>
                                <div class="editFields">
                                    <form enctype="multipart/form-data" name='galleryForm' id='galleryForm'  method='post' action=''>
                                        <input type="file"  name='eventGallery[]' id='eventGallery' multiple style="border: 1px solid #ccc; padding: 10px; width: 350px;">
                                        <div>
                                            <input type="submit" name='gallerySubmit' id='gallerySubmit' class="createBtn" value='UPLOAD'>
                                        </div>
                                    </form>
                                    <div class='error'><span id='galleryNoSelectError'></span></div>
                                    <div id='galleryDiv'>
                                        <span class='error' id='galleryError' style='font-size:18px;'> <?php
                                            if (isset($insertedGallery) && !$insertedGallery['status']) {
                                                echo $insertedGallery['response']['messages'][0];
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="GalleryView-Thumb" style="margin-top: 0px">
            <?php if (isset($galleryImages) && $galleryImages['status'] && $galleryImages['response']['total'] > 0) { ?>
                <ul class="GalleryThumb">
                    <?php foreach ($galleryImages['response']['galleryList'] as $gallery) { ?>
                        <li>
                            <img src="<?php echo $gallery['thumbnailPath']; ?> " width="200" height="200">
                            <p class="Gallery-Delete">
                                <a href="<?php echo commonHelperGetPageUrl('dashboard-gallery', $eventId . '&' . $gallery['imageId']); ?>">
                                    <span class="icon2-trash-o"></span>
                                </a>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
            <?php } elseif ($galleryImages['response']['total'] == 0) { ?>
                <div><div class="db-alert db-alert-info"><strong>There is no gallery for this event. You can add it now</strong></div></div>
            <?php } ?>
        </div>
    </div>
    <?php if (isset($deleteGallery) && !$deleteGallery['status']) { ?>
        <div id="galleryErrorMessage" class="db-alert db-alert-danger flashHide">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>&nbsp;&nbsp;  <?php echo $deleteGallery['response']['messages'][0]; ?></strong> 
        </div>
    <?php } ?>
</div>