<?php
class VMetaInformation{
    public function __construct(){
    }

    public function __destruct(){
    }

    public function showOgProperties(){
        echo <<<'NOW'
        <meta property="og:url"           content="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?=$content['title']?>" />
        <meta property="og:description"   content="<?=$content['description']?>" />
        <meta property="og:image"         content="https://img15.hostingpics.net/pics/629252fbMiniatureV2.png" />
NOW;
        return;
    }

    public function showFavicon(){
        echo <<<'NOW'
        <link href="http://cnam.atwebpages.com/NFA017/PERSONNAL04_PURECSS_MVC/img/favicon/favicon.ico" rel="icon" type="image/x-icon" />
NOW;
    }
}