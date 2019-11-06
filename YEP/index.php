<!DOCTYPE html>
<?php

    $uncache_str = time();

?>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>YEP - Yanick's Euroscope ᶠᵃᵏᵉPlugin</title>

    <script>
        let _ = undefined;
        window.uncacheStr = <?=$uncache_str?>;
        less = {};
        less.env = 'development';
    </script>


	<link rel="stylesheet" type="text/css" href="assets/css/base.css?<?=$uncache_str?>">
	<link rel="stylesheet/less" type="text/css" href="assets/css/styles.less?<?=$uncache_str?>" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js" ></script>
    
    <script src="assets/js/settings.js?<?=$uncache_str?>" ></script>
    <script src="assets/js/scripts.js?<?=$uncache_str?>" ></script>

</head>

	<body>
		<div id="mainYepContainer">

            <div id="newBar">
            
                <button id="spawnButton" class="left">
                      <span>New Airport:</span>
                      <input id="newAirportICAO" size="4" maxLength="4" value="cybg" />
                      <select id="spawnButtonSelect">
                          <option>option 1</option>
                          <option>option 2</option>
                          <option>They all do the same</option>
                          <option>Im just showing off my front end skills</option>
                      </select>
                      <!--
                      -->
                      <span id="spawnButtonClickableSpan">Fetch</span>
                </button>
                
                <?php
                class TopLink
                {
                    public $name = '';
                    public $task = '';
                    public $url = '';
                    public function __construct($name, $url)
                    {
                        $this->name = $name;
                        $this->task = str_replace(' ', '', $name);
                        $this->url = $url;
                    }
                }

                $topLink_list = [
                    new TopLink('Preferred IFR Routes', '//rt2.czulfir.com/Docs/YEP/CFS%20-%20Preferred%20IFR%20Routes%20-%202019%2001%2003.pdf'),
                    new TopLink('NavCanada IIDS', '//atm.navcanada.ca/gca/iwv/CZAE'),
                    new TopLink('NavCanada Notices', '//plan.navcanada.ca/awws/notices/show/en'),
                    new TopLink('NavCanada OIS', '//extranetapps.navcanada.ca/ois/ois.aspx'),

                ];
                foreach($topLink_list as $topLink)
                {
                    ?>
                    <button class="genericTopLinkButton topMiddleButton"
                        data-yepWindow-a-href = "<?=$topLink->url?>" 
                        data-yepWindow-a-task = "<?=$topLink->task?>" 
                        data-yepWindow-a-title = "<?=$topLink->name?>"
                        >
                          <span><?=$topLink->name?></span>
                    </button>
                    <?php
                }
                ?>


                <button id="aboutButton" class="right" disabled>
                      <span>About</span>
                </button>
                <button id="settingsButton" class="right">
                      <span>Settings</span>
                </button>
                <!--
                <button id="uploadButton" class="right">
                      <span>Upload Session</span>
                </button>
                <button id="saveButton" class="right">
                      <span>Save Session</span>
                </button>
                -->
            </div>
            <div id="playground">

            </div>
        </div>
		<div id="mouseDragAntiSelectDiv">
        </div>


	</body>

</html>
