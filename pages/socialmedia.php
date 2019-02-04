<?php 
	if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
		$pageAction = $_REQUEST['action'];
		switch ($pageAction) {
			case "add":
				df_addsocialmedia();
			break;
			case "save":
				df_savesocialmedia();
			break;
			case "edit":
				df_editsocialmedia();
			break;
			case "update":
				df_updatesocialmedia();
			break;
			case "delete":
				df_deletesocialmedia();
			break;
			case "viewinfo":
				df_viewinfosocialmedia();
			break;
			default:
				df_socialmedia();
		}	
	}
	else{
		df_socialmedia();	
	}
	/*
		Create Function for display social media list
	*/
	function df_socialmedia(){
		/*
			Setup CSS And JS For Listing of socialmedia records.
		*/
		wp_register_script('socialmedia-js', DF_SCRIPTS . 'socialmedia.js', array('jquery'));
		wp_enqueue_style('socialmedia-css', DF_CSS . 'socialmedia.css');
		?><div id="pageparentdiv" class="postbox">
            <h3 class="hndle ui-sortable-handle inside">
                Social media settings &nbsp; 
                <a href="admin.php?page=dfsettings&tab=socialmedia&action=add" class="button button-primary button-medium">Add New</a>
                <a href="admin.php?page=dfsettings&tab=socialmedia&action=viewinfo" style="float:right;" class="button button-primary button-medium">How to use social media?</a>
            </h3>
            <div class="inside"><?php
                messagedisplay();
				?><table class="wp-list-table widefat fixed" id="socialmedialist">
                    <thead>
                    <tr>
                        <th><strong>Sr No</strong></th>
                        <th><strong>Social Media Site Title</strong></th>
                        <th><strong>Social Media Site URL</strong></th>
                        <th style="text-align:center;"><strong>Action</strong></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /*
                        Write Custom Query in wordpress
						Create socialmedia object for get all records from social media
                    */
					$objDB = new alldbfunction();
					/*
						selectAllRecords : Function name for get all records from table : df_socialmedia
					*/
					$resData = $objDB->selectAllRecords('df_socialmedia');
					/*
						Check records exists or not.
						IF no then display No Record Found Message.
					*/
					if (count($resData) > 0) {
                        $i = 0;
                        foreach ($resData as $r) {
                            ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td nowrap><?php echo $r['title']; ?></td>
                                <td nowrap><a href="<?php echo $r['url']; ?>"><?php echo $r['url']; ?></a></td>
                                <td style="text-align:center;">
                                        <a class="button button-secondary"
                                           href="admin.php?page=dfsettings&tab=socialmedia&action=edit&id=<?php echo $r['id']; ?>">Edit</a>
                                        <a class="button button-danger"
                                           onclick="return confirm('are you sure you want to delete <?php echo $r['title']; ?> socialmedia?');"
                                           href="admin.php?page=dfsettings&tab=socialmedia&action=delete&id=<?php echo $r['id']; ?>">Delete</a>
                                </td>
                            </tr><?php
                        }
    
                    } else {
                        ?><tr>
                        	<td colspan="5">No Record Found!</td>
                        <tr><?php
                    }
                    ?></tbody>
                </table>
            </div>
        </div><?php
	}
	/*
		Create Function for add social media
	*/
	function df_addsocialmedia(){
		
		?><script type="text/javascript">
		jQuery(document).ready(function ($) {
			$("#form-socialmedia").validationEngine();
		});
		</script><div id="pageparentdiv" class="postbox">
            <h3 class="hndle ui-sortable-handle inside">
                Add Social Media &nbsp; 
                <a href="admin.php?page=dfsettings&tab=socialmedia" style="float:right;" class="button button-primary button-medium">Back</a>
            </h3>
            <div class="inside"><?php
                messagedisplay();
				?><form name="form-socialmedia" id="form-socialmedia" method="post" action="admin.php?page=dfsettings&tab=socialmedia&action=save">
                    <p>
                        <table width="70%">
                            <tr>
                                <td><label><strong>Title :</strong></label></td>
                                <td><input type="text" name="txtTitle" id="txtTitle" class="validate[required]" /></td>
                                <td><label><strong>URL :</strong></label></td>
                                <td><input type="text" name="txtUrl" id="txtUrl" class="validate[required,custom[url]]" /></td>
                                <td align="right">
                                    <input type="submit" name="addsocialmedia" id="addsocialmedia" class="button" value="Add Social Media">
                                </td>
                            </tr>
                        </table>
                    </p>
                </form>
            </div>
		</div><?php
	
	}
	/*
		Create function for save social media information
	*/
	function df_savesocialmedia(){
		if(isset($_REQUEST['addsocialmedia']) && !empty($_REQUEST['addsocialmedia'])){			
				
			$df_social_table = 'df_socialmedia';
			$title = $_REQUEST['txtTitle'];
			$url = $_REQUEST['txtUrl'];
			$arrayInsertData = array(
				'title' => mysql_real_escape_string($title),
				'slug' => gte_sanitize_title(mysql_real_escape_string($title)),
				'url' 	=> $url
			);
			$objDB = new alldbfunction();
			$objDB->insertRecords($df_social_table,$arrayInsertData);
			wp_redirect("admin.php?page=dfsettings&tab=socialmedia&msg=rsi");
			exit;
		}
		else{
			wp_redirect("admin.php?page=dfsettings&tab=socialmedia&action=add&msg=swr");
			exit;
		}
	}
	/*
		Create Function for edit social media
	*/
	function df_editsocialmedia(){
		$df_social_table = 'df_socialmedia';
		$socialmedia_id = $_REQUEST['id'];
		$arrayEditData = array(
			'id' => mysql_real_escape_string($socialmedia_id)
		);
		$objDB = new alldbfunction();
		$resData = $objDB->editRecords($df_social_table,$arrayEditData);
		
		?><script type="text/javascript">
		jQuery(document).ready(function ($) {
			$("#form-socialmedia").validationEngine();
		});
		</script><div id="pageparentdiv" class="postbox">
            <h3 class="hndle ui-sortable-handle inside">
                Edit Social Media &nbsp; 
                <a href="admin.php?page=dfsettings&tab=socialmedia" style="float:right;" class="button button-primary button-medium">Back</a>
            </h3>
            <div class="inside"><?php
                messagedisplay();
				?><form name="form-socialmedia" id="form-socialmedia" method="post" action="admin.php?page=dfsettings&tab=socialmedia&action=update">
                	<input type="hidden" name="id" id="id" value="<?php echo $resData['id']; ?>" />
                    <p>
                        <table width="70%">
                            <tr>
                                <td><label><strong>Title :</strong></label></td>
                                <td><input type="text" name="txtTitle" id="txtTitle" class="validate[required]" value="<?php echo $resData['title']; ?>" /></td>
                                <td><label><strong>URL :</strong></label></td>
                                <td><input type="text" name="txtUrl" id="txtUrl" class="validate[required,custom[url]]" value="<?php echo $resData['url']; ?>" /></td>
                                <td align="right"><input type="submit" name="addsocialmedia" id="addsocialmedia" class="button" value="Update Social Media"></td>
                            </tr>
                        </table>
                    </p>
                </form>
            </div>
		</div><?php
	
	}
	/*
		Create function for Update Social Media Records.
	*/
	function df_updatesocialmedia(){
		if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){	
			$df_social_table = 'df_socialmedia';
			$socialmedia_id = $_REQUEST['id'];
			$title = $_REQUEST['txtTitle'];
			$url = $_REQUEST['txtUrl'];
			$objDB = new alldbfunction();
			$arrayUpdateData = array(
				'title' => mysql_real_escape_string($title),
				'url' 	=> $url
			);
			$arrayConditionData = array(
				'id' 	=> mysql_real_escape_string($socialmedia_id)
			);
			$objDB->updateRecords($df_social_table,$arrayUpdateData,$arrayConditionData);
			wp_redirect("admin.php?page=dfsettings&tab=socialmedia&msg=rus");
			exit;
		}
		else{
			wp_redirect("admin.php?page=dfsettings&tab=socialmedia&msg=swr");
			exit;
		}	
	}
	/*
		Create Function for Delete Social Media URL
	*/
	function df_deletesocialmedia(){
		if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){	
			$df_social_table = 'df_socialmedia';
			$socialmedia_id = $_REQUEST['id'];
			$objDB = new alldbfunction();
			$arrayDeleteData = array(
				'id' => $socialmedia_id
			);
			$objDB->deleteRecords($df_social_table,$arrayDeleteData);
			wp_redirect("admin.php?page=dfsettings&tab=socialmedia&msg=rds");
			exit;
		}
		else{
			wp_redirect("admin.php?page=dfsettings&tab=socialmedia&action=add&msg=swr");
			exit;
		}
	}
	/*
		Create Function for View How to use social Media in your page
	*/
	function df_viewinfosocialmedia(){
		?><div class="wrap">
        	<div id="pageparentdiv" class="postbox">
                <h3 class="hndle ui-sortable-handle inside">
                    How to use social media?
                    <a href="admin.php?page=dfsettings&tab=socialmedia" style="float:right;" class="button button-primary button-medium">Back</a>
                </h3>
                <div class="inside">
                    <div id="message2" class="updated notice below-h2">
                        <h2>How to use?</h2>
                        <br />
                        <p>
                        	If you want to display social media you can use our sortcode directly.<br /><br />
                        	How to use in template?<br /><br />
                        	<strong><code>&lt;?php echo do_shortcode("[df-socialmedia name="facebook"]"); ?&gt;&nbsp;</code></strong><br /><br />
                            How to use wordpress page?<br /><br />
                        	<strong><code>[df-socialmedia name="facebook"]</code></strong>
                        </p>
                   </div>
                </div>
            </div>
		</div><?php	
	}
?></div>