<?php
class VMetaInformation {
    private $metaTitle;
    private $metaDescription;
    private $metaImage;
    private $metaFavicon;

    public function __construct(){
    }

    public function __destruct(){
    }

    //Ajout du balisage meta pour l'identification des contenus qui varient selon les pages en cas de partage sur le net (social)
    public function showOgProperties($_metadata = null){
        $this->metaTitle = $_metadata['title'];
        $this->metaDescription = $_metadata['description'];
        $this->metaImage = $_metadata['image'];

        echo <<<'NOW'
        <meta property="og:url"           content="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
        <meta property="og:type"          content="website" />
NOW;
        echo '<meta property="og:title"         content="'.$this->metaTitle.'" />';
        echo '<meta property="og:description"   content="'.$this->metaDescription.'" />';
        echo '<meta property="og:image"         content="'.$this->metaImage.'" />'; //L'image doit avoir un chemin absolu et non relatif pour les balises meta

        return;
    }

    //Ajout de la favicon qui peut être définie soit une fois via le controller soit être dynamique en réaffectant la clé via une variable disposée dans chaque fonction de controle
    public function showFavicon($__metadata = null){
        $this->metaFavicon = $__metadata['favicon'];
        echo '<link href="'.$this->metaFavicon.'" rel="icon" type="image/x-icon" />';
    }
}