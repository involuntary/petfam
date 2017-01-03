<?php
/*
* Theme: PREMIUMPRESS CORE FRAMEWORK FILE
* Url: www.premiumpress.com
* Author: Mark Fail
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $post, $CORE, $userdata;


	// MESSAGE BUTTON
	if($userdata->ID){
		$MSG = $GLOBALS['CORE_THEME']['links']['myaccount'].'?tab=msg&show=1&u='.$post->post_author;
	}else{
		$MSG = '" onclick="alert(\''.strip_tags($CORE->_e(array('validate','25'))).'\')';
	}

	// CURRENT RATING
	$rating 	= get_post_meta($post->ID, 'ratingup', true);
	if($rating == ""){ $rating = 0; }else{ $rating = number_format($rating); }

	// BASIC PROFILE DATA
	$a = get_post_meta($post->ID,'dabackground',true);
	$d = get_post_meta($post->ID,'map_location',true);
	$c = get_post_meta($post->ID,'dahobbies',true);

ob_start();
?>

<script>
function AddMYLike(pid){
	WLTSaveUpRating('<?php echo str_replace("http://","",get_home_url()); ?>', <?php echo $post->ID; ?>, 'up', <?php echo $post->ID; ?>+'__like');
}
</script>


<a name="toplisting"></a>
<div class="dauserprofile">

    <div class="user-menu-container square clearfix">
        <div class="col-md-10 user-details">
            <div class="row white">
                <div class="col-md-6 no-pad">
                    <div class="coralbg user-pad toppad">

                        <h1>[TITLE-NOLINK]</h1>
<!-- JOSH// Added profile attributes -->
                        <h4 class="white">[GENDER-ICON] [GENDER] / [AGE] / [neighbourhood] </h4>

                        <?php  ?>
                        <?php if($d != ""){ ?>
                        <h4 class="white"> [LOCATION-FLAG] [COUNTRY] / [CITY] </h4>
                        <?php } ?>

                        <a class="btn btn-labeled btn-success" href="<?php echo $MSG; ?>">
                            <span class="btn-label"><i class="fa fa-pencil"></i></span><?php echo $CORE->_e(array('single','7')); ?>
                        </a>

                          <a class="btn btn-labeled btn-danger" href="javascript:void(0);" onclick="AddMYLike('<?php echo $post->ID; ?>'); jQuery('#likemebtn').hide();" id="likemebtn">
                            <span class="btn-label"><i class="fa fa-heart"></i></span>+1 <?php echo $CORE->_e(array('single','54')); ?>
                        </a>

                    </div>


                <div class="overview clearfix hidden-xs">
                    <div class="col-md-6 user-pad text-center">
                        <h3><?php echo $CORE->_e(array('graphs','4')); ?></h3>
                        <h4>[hits]</h4>
                    </div>
                    <div class="col-md-6 user-pad text-center">
                        <h3><?php echo $CORE->_e(array('single','54')); ?></h3>
                        <h4 id="<?php echo $post->ID; ?>__like"><?php echo $rating; ?></h4>
                    </div>
            	</div>

                </div>

                <div class="col-md-6 no-pad">
                    <div class="user-image">
                        [IMAGE]
                    </div>
                </div>
            </div>


        </div>


        <div class="col-md-2 user-menu-btns hidden-xs">
            <div class="btn-group-vertical square" id="responsive">

            [PROFILEBUTTONS style=3]

            </div>
        </div>


    </div>



<div class="clearfix"></div>

<div class="row">

<div class="col-md-12">

<div class="profilewrap">

<ul class="nav nav-tabs" id="Tabs">

        <li class="active"><a href="#t1" data-toggle="tab">{Details}</a></li>

        <li><a href="#t2" data-toggle="tab">{Description}</a></li>


        <li><a href="#t4" data-toggle="tab" > <?php echo $CORE->_e(array('single','37')); ?> </a></li>

       <li><a href="#t6" data-toggle="tab" > <?php echo $CORE->_e(array('single','55')); ?> </a></li>


</ul>

<div class="pull-right socialicons hidden-xs">[D_SOCIAL]</div>

<div class="tab-content">

				<!-- JOSH About Me Tab -->
				<div class="tab-pane active" id="t1">

					  <h3> <?php echo $CORE->_e(array('single','56')); ?></h3>

            [CONTENT extra="0"]

						</br>

						[FIELDS hide="pettype|mybreeds|Schedule|careneeddescription|exchangetypeseeking|lastminutecarerequired|behaviour|specialneedsrequired"]

						

        </div>

        <div class="tab-pane" id="t2">

					[FIELDS hide="linkedin|carecalendaravailable|lastminutecareavailable|exchangetypeoffering|facebook|website|twitter|experience|willingtosharephotoid|specialneeds|havepolicerecordcheck|numberofexchanges|neighbourhood|references|phone|address|category"]

        </div>



				<div class="tab-pane fade" id="t4">

					<h3>PetFam Member Testimonials</h3>
					<p>Had a great exchange? Request and leave testimonials to help others know how awesome you both are!</p>

					[COMMENTS tab=0]


				</div>




        <div class="tab-pane fade" id="t6">[IMAGES]</div>


</div>

</div>

</div>

</div>

[RELATED perrow=4]

<?php $SavedContent = ob_get_clean();
echo hook_item_cleanup($CORE->ITEM_CONTENT($post, hook_content_single_listing($SavedContent)));

?>
