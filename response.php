<?php

class Response {

    private $include_template = true;

    private $header = "";
    private $footer = "";
    private $body = "";

    public function isTemplate( $is_tmpl ) {
        $this->include_template = $is_tmpl;
    }

    public function setHeader() {
        $this->header = \imvision\Template::Render( dirname(__FILE__) . '/header.php' );
    }

    public function setFooter() {
        $scripts = renderScripts();
        $this->footer = \imvision\Template::Render( dirname(__FILE__) . '/footer.php', array("scripts"=>$scripts) );
    }

    public function setBody( $template, $data ) {
        $this->body = \imvision\Template::Render( dirname(__FILE__) . '/' . $template, $data );
    }

    public function Send( $template, $data = array() ) {

        if( $this->include_template ) {
            $this->setHeader();
        }

        $this->setBody( $template, $data );

        if( $this->include_template ) {
            $this->setFooter();
        }

        echo $this->header . $this->body . $this->footer;
        exit;
    }
}
