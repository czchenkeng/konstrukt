<?php
class components_Root extends k2_Component {
  function dispatch() {
    $t = new k2_Template("templates/document.tpl.php");
    return
      $t->render(
        $this,
        array(
          'content' => parent::dispatch(),
          'title' => $this->document->title(),
          'scripts' => $this->document->scripts(),
          'styles' => $this->document->styles(),
          'onload' => $this->document->onload()));
  }
  function GET() {
    $t = new k2_Template("templates/root.tpl.php");
    return $t->render($this);
  }
}