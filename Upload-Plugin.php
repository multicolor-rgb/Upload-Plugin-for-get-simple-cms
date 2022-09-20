<?php



# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

global $SITEURL;

# register plugin
register_plugin(
	$thisfile,							//Plugin id
	'Upload Plugin & Themes ',					//Plugin name
	'1.0',								//Plugin version
	'Multicolor & Islander',								//Plugin author 
	'',				//author website
	'Upload Plugin or Themes direct from CMS',				//Plugin description
	'plugins',							//page type - on which admin tab to display
	'plugin_upload'						//main function (administration)
);

add_action('plugins-sidebar','createSideMenu',array($thisfile,'Upload Plugin 📥'));

function plugin_upload(){  

    if(IN_GS == true){


global $SITEURL;
    global $message;


function rmdir_recursive($dir) {
    foreach (scandir($dir) as $file) {
        if ('.' === $file || '..' === $file)
            continue;
        if (is_dir("$dir/$file"))
            rmdir_recursive("$dir/$file");
        else
            unlink("$dir/$file");
    }
    rmdir($dir);
}

if (@$_FILES["zip_file"]["name"]) {
    $filename = $_FILES["zip_file"]["name"];
    $source = $_FILES["zip_file"]["tmp_name"];
    $type = $_FILES["zip_file"]["type"];

    $name = explode(".", $filename);
    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    foreach ($accepted_types as $mime_type) {
        if ($mime_type == $type) {
            $okay = true;
            break;
        }else{
            $okay = false;
        }
    }

  
    if($okay==true){


        $continue = strtolower($name[1]) == 'zip' ? true : false;
        if (!$continue) {
            $message = "The file you are trying to upload is not a .zip file. Please try again.";
        }
    
        /* PHP current path */
   
     if(isset($_POST['pluginorthemes'])){
        if($_POST['pluginorthemes']=='plugins'){
            $path = GSPLUGINPATH;
        }else{
            $path = GSTHEMESPATH;
        }
    };

       
        // absolute path to the directory where zipper.php is in
        $filenoext = basename($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
        $filenoext = basename($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)
    
        $targetdir = $path . $filenoext; // target directory
        $targetzip = $path . $filename; // target zip file
    
        /* create directory if not exists, otherwise overwrite */
        /* target directory is same as filename without extension */
    
        if (is_dir($targetdir))
            rmdir_recursive($targetdir);

      
            /* here it is really happening */
    
        if (move_uploaded_file($source, $targetzip)) {
            $zip = new ZipArchive();
            $x = $zip->open($targetzip);  // open the zip file to extract
            if ($x === true) {
                //

                if($_POST['pluginorthemes']==='themes'){
                    
                if($zip->locateName('template.php')!==false){
                    mkdir($targetdir, 0777);
                    $zip->extractTo($targetdir); 
                }else{
                    $zip->extractTo($path); 
                };

                };

    
    
                if($_POST['pluginorthemes']==='plugins'){
                    $zip->extractTo($path); 
                }
                
                $zip->close();
    
                unlink($targetzip);
            }
            $message = "<p class='mes animate__animated animate__fadeInDown' style='animation-delay:1s;opacity:0;animation-fill-mode:forwards'>Your Plugin or Themes was uploaded and unpacked.</p>";
        } 
    }else {
        $message = "<p class='mes mes-error animate__animated animate__fadeInDown' style='animation-delay:1s;opacity:0;animation-fill-mode:forwards'>There was a problem with the upload. Please try again.</p>";
    }


    }

 


echo '
<h3>Upload Plugins & Themes 📥</h3>';

if ($message !=='null'){
    echo "<p>$message</p>";
};

echo '

<style>

@import url("https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css");

.mes{
    width:100%;
    display:block;
    padding:10px;
    box-sizing:border-box;
    background:green;
    color:#fff;
    border-radius:5px;
}

.mes-error{
    background:red;
}

.pluginuploader{

    background:#fafafa;
    border:solid 1px #ddd;
    padding:15px;
    border-radius:5px;

}

.customfile{
    position:relative;
    width:100%;
    height:200px;
   background:#fff;
    font-size:1.2rem;
    font-weight:300;

    border:solid 1px #ddd;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;

    color: #333;
opacity: 0.8;
border-radius:5px;
 
}
 
.customfile input{
    opacity:0;
  width:100%;
  height:100%;
  position:absolute;
  top:0;
  left:0;
}

 
</style>

';

echo '<form class="pluginuploader"     enctype="multipart/form-data" method="post">
<label style="font-size:1rem;text-style:italic;">Choose a zip file to upload (and select either Plugin or Themes):</label> <br> 

<select name="pluginorthemes" class="pluginorthemes" style="width:100%;padding:10px;border:1px solid #ddd;margin-bottom:20px;">
<option value="plugins">Plugins</option>
<option value="themes">Themes</option>
</select>

<label for="zip_file" class="customfile">

<input type="file" name="zip_file" class="zip_file" style="font-size:1rem;color:#"/>


<p>Choose or drop file</p>
<p class="path"></p>

 
</label>
<br />
<input class="submit" type="submit" style=" all:unset;   cursor:pointer; padding:10px 25px !important;background:green !important;border-radius:5px;color:#fff !important" class="uploader" name="submit" value="Upload" />

</form>


<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="box-sizing:border-box;display:grid; width:100%;grid-template-columns:1fr auto; padding:10px;background:#fafafa;border:solid 1px #ddd;margin-top:20px;">
    <p style="margin:0;padding:0;"> Support my work via PayPal :) Thanks!  </p>
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="KFZ9MCBUKB7GL">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" border="0">
    <img alt="" src="https://www.paypal.com/en_PL/i/scr/pixel.gif" width="1" height="1" border="0">
</form>

<script>


setInterval(()=>{

   
    document.querySelector(".path").innerHTML =  document.querySelector(".zip_file").value.replace("/C:\/","");
    if( document.querySelector(".zip_file").value !== ""){

 
    };


 },1000)


 </script>
';

};

};
?>
