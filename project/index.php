<?php

include_once("models/DB.php");
include("models/TabelPembalap.php");
include("views/ViewPembalap.php");
include("presenters/PresenterPembalap.php");

$tabelPembalap = new TabelPembalap('localhost', 'mvp_db', 'root', '');
$viewPembalap = new ViewPembalap();
$presenter = new PresenterPembalap($tabelPembalap, $viewPembalap);



if(isset($_GET['screen'])){
    if($_GET['screen'] == 'add'){
        $formHtml = $presenter->tampilkanFormPembalap();
        echo $formHtml;
    }
    else if($_GET['screen'] == 'edit' && isset($_GET['id'])){
        $formHtml = $presenter->tampilkanFormPembalap();
        echo $formHtml;
    }
} 
else if(isset($_POST['action'])){
    // Redirect back to list without performing any action
    header("Location: index.php");
    exit();

} else{
    // Presenter now returns the full HTML (view injects the template and total)
    $html = $presenter->tampilkanPembalap();
    echo $html;
}

?>